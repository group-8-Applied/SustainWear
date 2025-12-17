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
		$passwordHash = password_hash($password, PASSWORD_BCRYPT);
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


	public function deactivateUser($userID) {
		try {
			$this->db->update(
				"accounts",
				["is_active" => 0],
				"user_id = :user_id",
				[":user_id" => $userID]
			);

			return [
				"success" => true,
				"message" => "User deactivated successfully"
			];
		} catch (Exception $e) {
			return [
				"success" => false,
				"error" => "Error while deactivating user: " . $e->getMessage()
			];
		}
	}

	public function activateUser($userID) {
		try {
			$this->db->update(
				"accounts",
				["is_active" => 1],
				"user_id = :user_id",
				[":user_id" => $userID]
			);

			return [
				"success" => true,
				"message" => "User activated successfully"
			];
		} catch (Exception $e) {
			return [
				"success" => false,
				"error" => "Error while activating user: " . $e->getMessage()
			];
		}
	}

	public function buildFilterConditions($filters = []) {
		$conditions = [];
		$params = [];

		// filter by name/email
		if (!empty($filters["search"])) {
			$conditions[] = "(full_name LIKE :search OR email LIKE :search)";
			$params[":search"] = "%" . $filters["search"] . "%"; // % means contained anywhere
		}

		// filter by role
		if (!empty($filters["role"]) && $filters["role"] !== "Any") {
			$conditions[] = "user_role = :role";
			$params[":role"] = strtolower($filters["role"]);
		}

		// filter by status
		if (!empty($filters["status"]) && $filters["status"] !== "Any") {
			$isActive = boolval($filters["status"] === "Active");
			$conditions[] = "is_active = :is_active";
			$params[":is_active"] = $isActive;
		}

		return ["conditions" => $conditions, "params" => $params];
	}

	// so we can get a count without fetching all entries at once
	public function countUsingFilters($filters = []) {
		$query = "SELECT COUNT(*) as count FROM accounts WHERE 1=1"; // start with all

		// build conditions
		$filterData = $this->buildFilterConditions($filters);
		foreach ($filterData["conditions"] as $condition) {
			$query .= " AND " . $condition;
		}

		$result = $this->db->fetchOne($query, $filterData["params"]);
		return $result ? intval($result["count"]) : 0;
	}

	public function getFiltered($filters = [], $limit = null, $offset = 0) {
		$query = "SELECT user_id, full_name, email, user_role, is_active FROM accounts WHERE 1=1";

		$filterData = $this->buildFilterConditions($filters);
		foreach ($filterData["conditions"] as $condition) {
			$query .= " AND " . $condition;
		}

		$query .= " ORDER BY full_name ASC";

		if ($limit !== null) {
			$query .= " LIMIT :limit OFFSET :offset";
			$filterData["params"][":limit"] = $limit;
			$filterData["params"][":offset"] = $offset;
		}

		return $this->db->fetchAll($query, $filterData["params"]);
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

	public function deleteAccount($userID) {
		try {
			// remove any donation images they may have uploaded
			$donations = $this->db->fetchAll(
				"SELECT photo_path FROM donations WHERE donor_id = :donor_id AND photo_path IS NOT NULL",
				[":donor_id" => $userID]
			);

			foreach ($donations as $donation) {
				$filePath = __DIR__ . "/../../public" . $donation["photo_path"];
				// if file exists, remove it
				if (file_exists($filePath)) {
					unlink($filePath);
				}
			}

			$this->db->delete(
				"accounts",
				"user_id = :user_id",
				[":user_id" => $userID]
			);

			return [
				"success" => true,
				"message" => "Account deleted successfully"
			];
		} catch (Exception $e) {
			return [
				"success" => false,
				"error" => "Error while deleting account: " . $e->getMessage()
			];
		}
	}
}
