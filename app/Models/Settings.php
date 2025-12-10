<?php

class Settings {
	private $db;

	public function __construct() {
		$this->db = Database::getInstance();
	}

	public function get($key) {
		$row = $this->db->fetchOne(
			"SELECT setting_value FROM settings WHERE setting_key = :key",
			[":key" => $key]
		);
		return $row ? $row["setting_value"] : null;
	}

	public function set($key, $value) {
		$this->db->upsert("settings", [
			"setting_key" => $key,
			"setting_value" => $value
		], ["setting_key"]);
	}

	public function getAll() {
		$result = $this->db->query("SELECT setting_key, setting_value FROM settings");
		$settings = [];

		// load settings from database into dict
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$settings[$row["setting_key"]] = $row["setting_value"];
		}

		return $settings;
	}

	public function allowDonations() {
		return $this->get("allow_donations") === "1";
	}

	public function allowRegistrations() {
		return $this->get("allow_registrations") === "1";
	}

	public function getSessionTimeout() {
		// default to 24 hours
		return intval($this->get("session_timeout") ?? 24);
	}
}
