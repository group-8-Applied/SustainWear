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
		$this->render("staff/inventory");
	}

	public function reports() {
		$this->render("staff/reports");
	}
}
