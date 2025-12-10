<?php

class Account {
	private $db;

	public function __construct() {
		$this->db = Database::getInstance();
	}

	public function validateEmailForUse($email) {
		$errors = [];

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors[] = "Email address is invalid";
		}

		if ($this->emailExists($email)) {
			$errors[] = "Email address is already registered";
		}

		return [
			"success" => empty($errors),
			"errors" => $errors
		];
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

	public function getEmployeeNames() {
		return $this->db->fetchAll(
			"SELECT user_id, full_name FROM accounts WHERE user_role IN ('staff', 'admin') ORDER BY full_name ASC"
		);
	}

	public function updateProfile($userID, $fullName, $email, $newPassword = null) {
		$updateData = [
			"full_name" => $fullName,
			"email" => $email
		];

		if ($newPassword !== null && !empty($newPassword)) {
			$updateData["password_hash"] = password_hash($newPassword, PASSWORD_BCRYPT);
		}

		$this->db->update(
			"accounts",
			$updateData,
			"user_id = :user_id",
			[":user_id" => $userID]
		);

		return true;
	}

	public function updateUser($email, $newRole = null, $newPassword = null) {
		$user = $this->db->fetchOne(
			"SELECT user_id FROM accounts WHERE email = :email",
			[":email" => $email]
		);

		if (!$user) {
			return [
				"success" => false,
				"error" => "User not found"
			];
		}

		// will contain the changes to make
		$updateData = [];

		if ($newRole !== null && !empty($newRole)) { // role is being changed
			if (!in_array($newRole, ["admin", "staff", "donor"])) { // ensure it's a valid value
				return [
					"success" => false,
					"error" => "Invalid role"
				];
			}
			$updateData["user_role"] = $newRole;
		}

		if ($newPassword !== null && !empty($newPassword)) {
			$updateData["password_hash"] = password_hash($newPassword, PASSWORD_BCRYPT);
		}

		$this->db->update(
			"accounts",
			$updateData,
			"user_id = :user_id",
			[":user_id" => $user["user_id"]]
		);

		return [
			"success" => true,
			"message" => "User updated successfully"
		];
	}
}
