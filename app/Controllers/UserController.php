<?php

class UserController extends ControllerBase {
	private $accountModel;
	private $donationModel;

	public function __construct() {
		$this->accountModel = new Account();
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
			"user" => $user,
			"statusMessage" => "",
			"messageType" => ""
		]);
	}

	public function updateProfile() {
		if ($_SERVER["REQUEST_METHOD"] !== "POST") {
			$this->redirect("/user/profile");
			return;
		}

		$user = Auth::getUser();

		$email = strtolower(trim($_POST["email"])) ?? "";
		$fullName = ucwords(strtolower(trim($_POST["full_name"]))) ?? "";
		$password = $_POST["password"] ?? "";
		$passwordConfirmation = $_POST["password_confirmation"] ?? "";

		// these are autofilled so should exist
		if (empty($fullName) || empty($email)) {
			$this->render("user/profile", [
				"user" => $user,
				"statusMessage" => "Full name and email are required.",
				"messageType" => "error"
			]);
			return;
		}

		// validate email address
		$emailValidation = $this->accountModel->validateEmailForUse($email);
		if ($email !== $user["email"] && !$emailValidation["success"]) {
			$this->render("user/profile", [
				"user" => $user,
				"statusMessage" => "Email address is invalid or already registered.",
				"messageType" => "error"
			]);
			return;
		}

		// validate password if provided
		if (!empty($password) || !empty($passwordConfirmation)) {
			if ($password !== $passwordConfirmation) {
				$this->render("user/profile", [
					"user" => $user,
					"statusMessage" => "Passwords do not match.",
					"messageType" => "error"
				]);
				return;
			}

			if (strlen($password) < 8) {
				$this->render("user/profile", [
					"user" => $user,
					"statusMessage" => "Password must be at least 8 characters long.",
					"messageType" => "error"
				]);
				return;
			}
		}

		try {
			// Update profile
			$this->accountModel->updateProfile(
				$user["user_id"],
				$fullName,
				$email,
				$password
			);

			$this->render("user/profile", [
				"user" => Auth::getUser(),
				"statusMessage" => "Profile updated successfully!",
				"messageType" => "success"
			]);
		} catch (Exception $e) {
			$this->render("user/profile", [
				"user" => $user,
				"statusMessage" => "Error updating profile: " . $e->getMessage(),
				"messageType" => "error"
			]);
		}
	}

	public function notifications() {
		$this->render("user/notifications");
	}

	public function help() {
		$this->render("user/help");
	}
}
