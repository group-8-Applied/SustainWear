<?php

class Account {
	private $db;

	public function __construct() {
		$this->db = Database::getInstance();
	}

	public function emailExists($email) {
		$result = $this->db->fetchOne(
			"SELECT * FROM accounts WHERE email = :email",
			[":email" => $email]
		);
		return $result !== false;
	}

	public function createAccount($fullName, $email, $password) {
		$passwordHash = password_hash($password, PASSWORD_DEFAULT);
		$sessionToken = bin2hex(random_bytes(32));

		$userID = $this->db->insert("accounts", [
			"full_name" => $fullName,
			"email" => $email,
			"password_hash" => $passwordHash,
			"session_token" => $sessionToken,
			"user_role" => "donor" // start all new accounts as donors
		]);

		return [
			"user_id" => $userID,
			"session_token" => $sessionToken
		];
	}

	public function verifyPassword($email, $password) {
		$account = $this->db->fetchOne(
			"SELECT * FROM accounts WHERE email = :email",
			[":email" => $email]
		);

		if (!$account) {
			return false;
		}

		if (password_verify($password, $account["password_hash"])) {
			return $account;
		}

		return false;
	}

	public function updateSessionToken($userID) {
		$sessionToken = bin2hex(random_bytes(32));

		$this->db->update(
			"accounts",
			["session_token" => $sessionToken],
			"user_id = :user_id",
			[":user_id" => $userID]
		);

		return $sessionToken;
	}

	public function getAll() {
		return $this->db->fetchAll("SELECT user_id, full_name, email, user_role FROM accounts");
	}
}
