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
		$user = Auth::getUser();
		$stats = $this->donationModel->getStats();
		$pendingDonations = $this->donationModel->getResults(["status" => "pending"]);

		$approvedToday = $this->donationModel->getResults(["status" => "approved"]);
		$approvedTodayCount = count(array_filter($approvedToday, function($d) {
			return date("Y-m-d", strtotime($d["reviewed_date"])) === date("Y-m-d");
		}));

		$declinedToday = $this->donationModel->getResults(["status" => "declined"]);
		$declinedTodayCount = count(array_filter($declinedToday, function($d) {
			return date("Y-m-d", strtotime($d["reviewed_date"])) === date("Y-m-d");
		}));

		$this->render("staff/pending-donations", [
			"user" => $user,
			"stats" => $stats,
			"donations" => $pendingDonations,
			"approvedTodayCount" => $approvedTodayCount,
			"declinedTodayCount" => $declinedTodayCount
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
		$standardTypes = ["Coat", "Jeans", "T-Shirt", "Shoes"];

		$allDonations = $this->donationModel->getResults([]);
		$totalDonations = count($allDonations);

		$currentMonth = date("Y-m"); // numeric
		$currentMonthName = date("F Y"); // text

		// will store stats
		$monthlyStats = [];
		$currentMonthReceived = 0;
		$currentMonthApproved = 0;
		$currentMonthDeclined = 0;

		// will be $categoryStats["Coats"] etc
		$categoryStats = [];

		foreach ($allDonations as $donation) {
			$monthSubmitted = date("Y-m", strtotime($donation["submitted_date"]));
			$monthLabel = date("F Y", strtotime($donation["submitted_date"]));

			// insert month dict if not yet created
			if (!isset($monthlyStats[$monthSubmitted])) {
				$monthlyStats[$monthSubmitted] = [
					"label" => $monthLabel,
					"received" => 0,
					"approved" => 0,
					"declined" => 0
				];
			}

			// increment stats
			$monthlyStats[$monthSubmitted]["received"]++;

			if ($donation["status"] === "approved") {
				$monthlyStats[$monthSubmitted]["approved"]++;
			} elseif ($donation["status"] === "declined") {
				$monthlyStats[$monthSubmitted]["declined"]++;
			}

			// if month is current month
			if ($monthSubmitted === $currentMonth) {
				$currentMonthReceived++;

				if ($donation["status"] === "approved") {
					$currentMonthApproved++;

					// if it's not a regular item, just put it in the "Other" category
					$itemType = in_array($donation["item_type"], $standardTypes) ? $donation["item_type"] : "Other";
					if (!isset($categoryStats[$itemType])) {
						$categoryStats[$itemType] = 0;
					}

					$categoryStats[$itemType]++;
				} elseif ($donation["status"] === "declined") {
					$currentMonthDeclined++;
				}
			}
		}

		// sort months to have most recent first
		krsort($monthlyStats);

		// sort categories to have the most popular ones first
		arsort($categoryStats);

		// count all-time stats
		$totalApproved = 0;
		$totalDeclined = 0;

		foreach ($allDonations as $donation) {
			// we don't care about pending here
			if ($donation["status"] === "approved") {
				$totalApproved++;
			} elseif ($donation["status"] === "declined") {
				$totalDeclined++;
			}
		}

		$this->render("staff/reports", [
			"currentMonthName" => $currentMonthName,
			"currentMonthReceived" => $currentMonthReceived,
			"currentMonthApproved" => $currentMonthApproved,
			"currentMonthDeclined" => $currentMonthDeclined,
			"monthlyStats" => $monthlyStats,
			"categoryStats" => $categoryStats,
			"totalDonations" => $totalDonations,
			"totalApproved" => $totalApproved,
			"approvalRate" => $totalDonations > 0 ? round(($totalApproved / $totalDonations) * 100) : 0
		]);
	}
}
