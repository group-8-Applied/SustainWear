<?php

class UserController extends ControllerBase {
	private $donationModel;

	public function __construct() {
		$this->donationModel = new Donation();
	}

	public function dashboard() {
		$user = Auth::getUser();
		$donations = $this->donationModel->getByDonor($user["user_id"]);
		$stats = $this->donationModel->getStats();

		$this->render("user/dashboard", [
			"user" => $user,
			"donations" => $donations,
			"stats" => $stats
		]);
	}

	public function donate() {
		$user = Auth::getUser();
		$donations = $this->donationModel->getByDonor($user["user_id"]);

		$this->render("user/donate", [
			"user" => $user,
			"donations" => $donations,
			"donationMessage" => "",
			"messageType" => ""
		]);
	}

	public function submitDonation() {
		if ($_SERVER["REQUEST_METHOD"] !== "POST") {
			$this->redirect("/user/donate");
			return;
		}

		$user = Auth::getUser();

		$itemType = $_POST["item_type"] ?? "";
		$size = $_POST["size"] ?? "";
		$condition = $_POST["condition"] ?? "";
		$notes = $_POST["notes"] ?? "";

		if (empty($itemType) || empty($size) || empty($condition)) {
			$donations = $this->donationModel->getByDonor($user["user_id"]);
			$this->render("user/donate", [
				"user" => $user,
				"donations" => $donations,
				"donationMessage" => "Please fill in all required fields.",
				"messageType" => "error"
			]);
			return;
		}

		try {
			$donationID = $this->donationModel->createDonation(
				$user["user_id"],
				$user["full_name"],
				$itemType,
				$size,
				$condition,
				$notes
			);

			$donations = $this->donationModel->getByDonor($user["user_id"]);
			$this->render("user/donate", [
				"user" => $user,
				"donations" => $donations,
				"donationMessage" => "Donation submitted successfully! Your donation is now pending review.",
				"messageType" => "success"
			]);
		} catch (Exception $e) {
			$donations = $this->donationModel->getByDonor($user["user_id"]);
			$this->render("user/donate", [
				"user" => $user,
				"donations" => $donations,
				"donationMessage" => "Error submitting donation. Please try again.",
				"messageType" => "error"
			]);
		}
	}

	public function profile() {
		$user = Auth::getUser();
		$this->render("user/profile", [
			"user" => $user
		]);
	}

	public function notifications() {
		$this->render("user/notifications");
	}

	public function help() {
		$this->render("user/help");
	}
}
