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
			"isError" => false
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

		// all valid options. same as in the js
		$validItemTypes = ["Coat", "Jeans", "T-Shirt", "Shoes"];
		$validSizes = [
			"Coat" => ["XS", "S", "M", "L", "XL", "XXL"],
			"Jeans" => ["26", "28", "30", "32", "34", "36", "38", "40", "42"],
			"T-Shirt" => ["XS", "S", "M", "L", "XL", "XXL"],
			"Shoes" => ["3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14"]
		];
		$validConditions = ["Excellent", "Good", "Acceptable"];

		if (empty($itemType) || empty($size) || empty($condition)) {
			$donations = $this->donationModel->getByDonor($user["user_id"]);
			$this->render("user/donate", [
				"user" => $user,
				"donations" => $donations,
				"donationMessage" => "Please fill in all required fields.",
				"isError" => true
			]);
			return;
		}

		// make sure size matches item type if it's not custom
		if (in_array($itemType, $validItemTypes) && !in_array($size, $validSizes[$itemType])) {
			$donations = $this->donationModel->getByDonor($user["user_id"]);
			$this->render("user/donate", [
				"user" => $user,
				"donations" => $donations,
				"donationMessage" => "Invalid size selected for this item type.",
				"isError" => true
			]);
			return;
		}

		// make sure condition is valid
		if (!in_array($condition, $validConditions)) {
			$donations = $this->donationModel->getByDonor($user["user_id"]);
			$this->render("user/donate", [
				"user" => $user,
				"donations" => $donations,
				"donationMessage" => "Invalid condition selected.",
				"isError" => true
			]);
			return;
		}

		// handle photo if one was uploaded
		$photoPath = null;
		if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] === UPLOAD_ERR_OK) { // exists and uploaded successfully
			$allowedTypes = ["image/jpeg", "image/jpg", "image/png", "image/gif", "image/webp"];

			$isValidType = in_array($_FILES["photo"]["type"], $allowedTypes);
			$isValidSize = $_FILES["photo"]["size"] < (1024 * 1024 * 10); // 10mb // todo: maybe make configurable?

			if (!$isValidType || !$isValidSize) {
				$donations = $this->donationModel->getByDonor($user["user_id"]);
				$this->render("user/donate", [
					"user" => $user,
					"donations" => $donations,
					"donationMessage" => $isValidType ? "Invalid file type. Please upload a JPG, PNG, GIF, or WebP image." : "File is too large. Maximum size is 10MB.",
					"isError" => true
				]);
				return;
			}

			$extension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
			$fileName = uniqid("donation_" . $user["user_id"] . "_", true) . "." . $extension; // 23 random hex chars
			
			// move from tmp dir to /uploads
			$targetPath = __DIR__ . "/../../public/uploads/donations/" . $fileName;
			if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetPath)) {
				$photoPath = "/uploads/donations/" . $fileName;
			} else {
				$donations = $this->donationModel->getByDonor($user["user_id"]);
				$this->render("user/donate", [
					"user" => $user,
					"donations" => $donations,
					"donationMessage" => "Error uploading photo. Please try again.",
					"isError" => true
				]);
				return;
			}
		}

		try {
			$this->donationModel->createDonation(
				$user["user_id"],
				$user["full_name"],
				$itemType,
				$size,
				$condition,
				$notes,
				$photoPath
			);

			$donations = $this->donationModel->getByDonor($user["user_id"]);
			$this->render("user/donate", [
				"user" => $user,
				"donations" => $donations,
				"donationMessage" => "Donation submitted successfully! Your donation is now pending review.",
				"isError" => false
			]);
		} catch (Exception $e) {
			$donations = $this->donationModel->getByDonor($user["user_id"]);
			$this->render("user/donate", [
				"user" => $user,
				"donations" => $donations,
				"donationMessage" => "Error submitting donation. Please try again.",
				"isError" => true
			]);
		}
	}

	public function profile() {
		$user = Auth::getUser();
		$this->render("user/profile", [
			"user" => $user,
			"statusMessage" => "",
			"isError" => false
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
				"isError" => true
			]);
			return;
		}

		// validate email address
		$emailValidation = $this->accountModel->validateEmailForUse($email);
		if ($email !== $user["email"] && !$emailValidation["success"]) {
			$this->render("user/profile", [
				"user" => $user,
				"statusMessage" => "Email address is invalid or already registered.",
				"isError" => true
			]);
			return;
		}

		// validate password if provided
		if (!empty($password) || !empty($passwordConfirmation)) {
			if ($password !== $passwordConfirmation) {
				$this->render("user/profile", [
					"user" => $user,
					"statusMessage" => "Passwords do not match.",
					"isError" => true
				]);
				return;
			}

			if (strlen($password) < 8) {
				$this->render("user/profile", [
					"user" => $user,
					"statusMessage" => "Password must be at least 8 characters long.",
					"isError" => true
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
				"isError" => false
			]);
		} catch (Exception $e) {
			$this->render("user/profile", [
				"user" => $user,
				"statusMessage" => "Error updating profile: " . $e->getMessage(),
				"isError" => true
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
