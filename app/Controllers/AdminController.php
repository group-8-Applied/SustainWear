<?php

class AdminController extends ControllerBase {
	private $accountModel;
	private $donationModel;

	public function __construct() {
		$this->accountModel = new Account();
		$this->donationModel = new Donation();
	}

	public function dashboard() {
		$user = Auth::getUser();
		$stats = $this->donationModel->getStats();

		$this->render("admin/dashboard", [
			"user" => $user,
			"stats" => $stats
		]);
	}

	public function manageUsers() {
		$users = $this->accountModel->getAll();
		$this->render("admin/manage-users", [
			"users" => $users
		]);
	}

	public function donations() {
		$filters = [];

		// load filters from get params
		if (isset($_GET["status"]) && !empty($_GET["status"])) {
			$filters["status"] = $_GET["status"];
		}
		if (isset($_GET["donor_name"]) && !empty($_GET["donor_name"])) {
			$filters["donor_name"] = $_GET["donor_name"];
		}
		if (isset($_GET["condition"]) && !empty($_GET["condition"])) {
			$filters["condition"] = $_GET["condition"];
		}
		if (isset($_GET["item_type"]) && !empty($_GET["item_type"])) {
			$filters["item_type"] = $_GET["item_type"];
		}
		if (isset($_GET["reviewer_id"]) && !empty($_GET["reviewer_id"])) {
			$filters["reviewer_id"] = $_GET["reviewer_id"];
		}

		$perPage = 10;
		$donationCount = $this->donationModel->countUsingFilters($filters);
		$pageCount = ceil($donationCount / $perPage);

		$pageGET = isset($_GET["page"]) && is_numeric($_GET["page"]) ? intval($_GET["page"]) : 1;
		$currentPage = min(max(1, $pageGET), $pageCount); // clamp between 1 and pageCount

		$this->render("admin/donations", [
			"donations" => $this->donationModel->getResults($filters, $perPage, ($currentPage - 1) * $perPage),
			"filters" => $filters,
			"currentPage" => $currentPage,
			"pageCount" => $pageCount,
			"donationCount" => $donationCount,
			"employees" => $this->accountModel->getEmployeeNames()
		]);
	}

	public function updateDonation() {
		if ($_SERVER["REQUEST_METHOD"] !== "POST") {
			$this->redirect("/admin/donations");
			return;
		}

		$user = Auth::getUser();
		$donationID = $_POST["donation_id"] ?? "";
		$status = $_POST["status"] ?? "";

		// if status is invalid, cancel
		if (empty($donationID) || empty($status) || !in_array($status, ["pending", "approved", "declined"])) {
			$this->redirect("/admin/donations");
			return;
		}

		try {
			$this->donationModel->updateStatus($donationID, $status, $user["user_id"]);
			$this->redirect("/admin/donations");
		} catch (Exception $e) {
			$this->redirect("/admin/donations");
		}
	}

	public function settings() {
		$this->render("admin/settings");
	}
}
