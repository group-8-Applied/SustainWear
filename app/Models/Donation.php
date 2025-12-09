<?php

class Donation {
	private $db;

	public function __construct() {
		$this->db = Database::getInstance();
	}

	public function createDonation($donorID, $donorName, $itemType, $size, $condition, $notes = "", $photoPath = null) {
		$donationID = $this->db->insert("donations", [
			"donor_id" => $donorID,
			"donor_name" => $donorName,
			"item_type" => $itemType,
			"size" => $size,
			"condition" => $condition,
			"notes" => $notes,
			"photo_path" => $photoPath,
			"status" => "pending",
			"submitted_date" => date("Y-m-d H:i:s")
		]);

		return $donationID;
	}

	public function getByDonor($donorID) {
		return $this->db->fetchAll(
			"SELECT * FROM donations WHERE donor_id = :donor_id ORDER BY submitted_date DESC",
			[":donor_id" => $donorID]
		);
	}

	public function getResults($filters = [], $limit = null, $offset = 0) {
		$query = "SELECT * FROM donations WHERE 1=1"; // select all to begin with
		$params = [];

		if (!empty($filters["status"])) {
			$query .= " AND status = :status";
			$params[":status"] = $filters["status"];
		}

		if (!empty($filters["donor_id"])) {
			$query .= " AND donor_id = :donor_id";
			$params[":donor_id"] = $filters["donor_id"];
		}

		if (!empty($filters["item_type"])) {
			$query .= " AND item_type = :item_type";
			$params[":item_type"] = $filters["item_type"];
		}

		if (!empty($filters["condition"])) {
			$query .= " AND condition = :condition";
			$params[":condition"] = $filters["condition"];
		}

		if (!empty($filters["donor_name"])) {
			$query .= " AND donor_name LIKE :donor_name";
			$params[":donor_name"] = "%" . $filters["donor_name"] . "%"; // % means it is contained *somewhere*
		}

		$query .= " ORDER BY submitted_date DESC"; // sort by latest

		// add limit and offset to allow for paginated queries
		if ($limit !== null) {
			$query .= " LIMIT :limit OFFSET :offset";
			$params[":limit"] = $limit;
			$params[":offset"] = $offset;
		}

		return $this->db->fetchAll($query, $params);
	}

	public function countUsingFilters($filters = []) {
		$query = "SELECT COUNT(*) as count FROM donations WHERE 1=1";
		$params = [];

		if (!empty($filters["status"])) {
			$query .= " AND status = :status";
			$params[":status"] = $filters["status"];
		}

		if (!empty($filters["donor_id"])) {
			$query .= " AND donor_id = :donor_id";
			$params[":donor_id"] = $filters["donor_id"];
		}

		if (!empty($filters["item_type"])) {
			$query .= " AND item_type = :item_type";
			$params[":item_type"] = $filters["item_type"];
		}

		if (!empty($filters["condition"])) {
			$query .= " AND condition = :condition";
			$params[":condition"] = $filters["condition"];
		}

		if (!empty($filters["donor_name"])) {
			$query .= " AND donor_name LIKE :donor_name";
			$params[":donor_name"] = "%" . $filters["donor_name"] . "%";
		}

		$result = $this->db->fetchOne($query, $params);
		return $result ? $result["count"] : 0;
	}

	public function updateStatus($donationID, $status, $reviewerID) {
		return $this->db->update(
			"donations",
			[
				"status" => $status,
				"reviewed_date" => date("Y-m-d H:i:s"),
				"reviewer_id" => $reviewerID
			],
			"donation_id = :donation_id",
			[":donation_id" => $donationID]
		);
	}

	public function getStats() {
		$stats = [];

		$result = $this->db->fetchOne("SELECT COUNT(*) as count FROM donations WHERE status = 'pending'");
		$stats["pending"] = $result ? $result["count"] : 0;

		$result = $this->db->fetchOne(
			"SELECT COUNT(*) as count FROM donations WHERE status = 'approved' AND DATE(reviewed_date) = DATE('now')"
		);
		$stats["approved_today"] = $result ? $result["count"] : 0;

		$result = $this->db->fetchOne("SELECT COUNT(*) as count FROM donations WHERE status = 'approved'");
		$stats["total_approved"] = $result ? $result["count"] : 0;

		$result = $this->db->fetchOne("SELECT COUNT(*) as count FROM donations");
		$stats["total"] = $result ? $result["count"] : 0;

		return $stats;
	}
}
