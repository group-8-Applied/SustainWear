<?php

class StaffController extends ControllerBase {
	private $donationModel;

	public function __construct() {
		$this->donationModel = new Donation();
	}

	public function dashboard() {
		$user = Auth::getUser();
		$stats = $this->donationModel->getStats();

		$this->render("staff/dashboard", [
			"user" => $user,
			"stats" => $stats
		]);
	}

	public function pendingDonations() {
		$pendingDonations = $this->donationModel->getResults(["status" => "pending"]);

		$this->render("staff/pending-donations", [
			"donations" => $pendingDonations
		]);
	}

	public function approveDonation() {
		if ($_SERVER["REQUEST_METHOD"] !== "POST") {
			$this->redirect("/staff/pending-donations");
			return;
		}

		$user = Auth::getUser();
		$donationID = $_POST["donation_id"] ?? "";

		if (empty($donationID)) {
			$this->redirect("/staff/pending-donations");
			return;
		}

		try {
			$this->donationModel->updateStatus($donationID, "approved", $user["user_id"]);
			$this->redirect("/staff/pending-donations");
		} catch (Exception $e) {
			$this->redirect("/staff/pending-donations");
		}
	}

	public function declineDonation() {
		if ($_SERVER["REQUEST_METHOD"] !== "POST") {
			$this->redirect("/staff/pending-donations");
			return;
		}

		$user = Auth::getUser();
		$donationID = $_POST["donation_id"] ?? "";

		if (empty($donationID)) {
			$this->redirect("/staff/pending-donations");
			return;
		}

		try {
			$this->donationModel->updateStatus($donationID, "declined", $user["user_id"]);
			$this->redirect("/staff/pending-donations");
		} catch (Exception $e) {
			$this->redirect("/staff/pending-donations");
		}
	}

	public function inventory() {
		// start off filter list with approved status, since inventory will only include that
		$filters = [
			"status" => "approved"
		];

		if (!empty($_GET["item_type"])) {
			$filters["item_type"] = $_GET["item_type"];
		}

		if (!empty($_GET["condition"])) {
			$filters["condition"] = $_GET["condition"];
		}

		// use stock level param if exists else all
		$stockLevelFilter = !empty($_GET["stock_level"]) ? $_GET["stock_level"] : "all";
		
		// store stats per category
		$standardTypes = ["Coat", "Jeans", "T-Shirt", "Shoes"];
		$categoryStats = array_fill_keys($standardTypes, 0);
		$categoryStats["Other"] = 0;
		
		// load inventory items into array
		$inventoryItems = [];
		$filteredDonations = $this->donationModel->getResults($filters);
		foreach ($filteredDonations as $donation) {
			// create identifier for items with same features
			$key = $donation["item_type"] . "|" . $donation["size"] . "|" . $donation["condition"];

			// create entry if it doesn't exist
			if (!isset($inventoryItems[$key])) {
				$inventoryItems[$key] = [
					"item_type" => $donation["item_type"],
					"size" => $donation["size"],
					"condition" => $donation["condition"],
					"quantity" => 0,
					"date_added" => $donation["reviewed_date"]
				];
			}

			// increment count
			$inventoryItems[$key]["quantity"]++;

			// if it's not a regular item, just put it in the "Other" category
			$category = in_array($donation["item_type"], $standardTypes) ? $donation["item_type"] : "Other";
			$categoryStats[$category]++;
		}

		// filter based on stock level
		$inventoryItems = array_filter(array_values($inventoryItems), function($item) use ($stockLevelFilter) {
			if ($stockLevelFilter === "low") {
				return $item["quantity"] > 0 && $item["quantity"] <= 3;
			} elseif ($stockLevelFilter === "in_stock") {
				return $item["quantity"] > 3;
			}
			return true;
		});

		// count low stock
		$lowStockCount = 0;
		foreach ($inventoryItems as $item) {
			if ($item["quantity"] > 0 && $item["quantity"] <= 3) {
				$lowStockCount++;
			}
		}

		$this->render("staff/inventory", [
			"inventoryItems" => $inventoryItems,
			"totalItems" => count($filteredDonations),
			"uniqueCategories" => count($categoryStats),
			"lowStockCount" => $lowStockCount,
			"categoryStats" => $categoryStats,
			"selectedItemType" => $_GET["item_type"] ?? "",
			"selectedCondition" => $_GET["condition"] ?? "",
			"selectedStockLevel" => $stockLevelFilter
		]);
	}

	public function reports() {
		$this->render("staff/reports");
	}
}
