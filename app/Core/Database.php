<?php

class Database {
	private static $instance = null; // singleton
	private $connection;

	private function __construct() {
		$dbPath = __DIR__ . "/../../database.db";
		if (!file_exists($dbPath)) {
			echo "Visit <a href='db-init.php'>db-init.php</a> to initialise the database.<br>";
			die("Database does not exist.");
		}
		$this->connection = new SQLite3($dbPath);
	}

	public static function getInstance() {
		if (self::$instance === null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function query($sql, $params = []) {
		$statement = $this->connection->prepare($sql);

		if ($statement === false) {
			throw new Exception("Failed to prepare statement: " . $this->connection->lastErrorMsg());
		}

		// bind params then execute
		foreach ($params as $key => $value) {
			$statement->bindValue($key, $value);
		}

		$result = $statement->execute();

		if ($result === false) {
			throw new Exception("Query execution failed: " . $this->connection->lastErrorMsg());
		}

		return $result;
	}

	public function fetchOne($sql, $params = []) {
		$result = $this->query($sql, $params);
		return $result->fetchArray(SQLITE3_ASSOC);
	}

	public function fetchAll($sql, $params = []) {
		$result = $this->query($sql, $params);
		$rows = [];
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$rows[] = $row;
		}
		return $rows;
	}

	public function insert($table_name, $data) {
		$keys = array_keys($data);
		$values = array_map(fn($col) => ":$col", $keys);

		// INSERT INTO table_name (keys) VALUES (values)
		$sql = "INSERT INTO $table_name (" . implode(", ", $keys) . ") VALUES (" . implode(", ", $values) . ")";

		$params = [];
		foreach ($data as $key => $value) {
			$params[":$key"] = $value;
		}

		$this->query($sql, $params);
		return $this->connection->lastInsertRowID();
	}

	public function update($table_name, $data, $where, $whereParams = []) {
		$setParts = [];
		foreach (array_keys($data) as $column) {
			$setParts[] = "$column = :$column";
		}

		$sql = "UPDATE $table_name SET " . implode(", ", $setParts) . " WHERE $where";

		$params = [];
		foreach ($data as $key => $value) {
			$params[":$key"] = $value;
		}
		$params = array_merge($params, $whereParams);

		$this->query($sql, $params);
		return $this->connection->changes();
	}

	public function delete($table_name, $where_condition, $params = []) {
		$sql = "DELETE FROM $table_name WHERE $where_condition";
		$this->query($sql, $params);
		return $this->connection->changes();
	}
}
