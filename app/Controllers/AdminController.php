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

		$donations = $this->donationModel->getAll($filters);

		$this->render("admin/donations", [
			"donations" => $donations,
			"filters" => $filters
		]);
	}

	public function updateDonationStatus() {
		if ($_SERVER["REQUEST_METHOD"] !== "POST") {
			$this->redirect("/admin/donations");
			return;
		}

		$user = Auth::getUser();
		$donationId = $_POST["donation_id"] ?? "";
		$status = $_POST["status"] ?? "";

		if (empty($donationId) || empty($status)) {
			$this->redirect("/admin/donations");
			return;
		}

		if (!in_array($status, ["pending", "approved", "declined"])) {
			$this->redirect("/admin/donations");
			return;
		}

		try {
			$this->donationModel->updateStatus($donationId, $status, $user["user_id"]);
			$this->redirect("/admin/donations");
		} catch (Exception $e) {
			$this->redirect("/admin/donations");
		}
	}

	public function settings() {
		$this->render("admin/settings");
	}
}
