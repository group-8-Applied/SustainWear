<?php

class UserController extends ControllerBase {
	private $accountModel;
	private $donationModel;
	private $settingsModel;

	public function __construct() {
		$this->accountModel = new Account();
		$this->donationModel = new Donation();
		$this->settingsModel = new Settings();
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
		$allowDonations = $this->settingsModel->allowDonations();

		$this->render("user/donate", [
			"user" => $user,
			"donations" => $donations,
			"statusMessage" => "",
			"isError" => false,
			"allowDonations" => $allowDonations
		]);
	}

	public function submitDonation() {
		if ($_SERVER["REQUEST_METHOD"] !== "POST") {
			$this->redirect("/user/donate");
			return;
		}

		$user = Auth::getUser();
		$statusMessage = null;
		$isError = false;

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

		// if donations are disabled or account has been deactivated
		$allowDonations = $this->settingsModel->allowDonations();
		if (!$allowDonations || !boolval($user["is_active"])) {
			// no need for a detailed error since this is the POST req. the UI shouldn't even let users reach this point
			$statusMessage = "Cannot submit donations at this time.";
			$isError = true;
		}
		// make sure all required fields were provided
		elseif (empty($itemType) || empty($size) || empty($condition)) {
			$statusMessage = "Please fill in all required fields.";
			$isError = true;
		}
		// make sure size matches item type if it's not custom
		elseif (in_array($itemType, $validItemTypes) && !in_array($size, $validSizes[$itemType])) {
			$statusMessage = "Invalid size selected for this item type.";
			$isError = true;
		}
		// make sure condition is valid
		elseif (!in_array($condition, $validConditions)) {
			$statusMessage = "Invalid condition selected.";
			$isError = true;
		} else { // handle photo if one was uploaded
			$photoPath = null;
			if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] === UPLOAD_ERR_OK) { // exists and uploaded successfully
				$allowedTypes = ["image/jpeg", "image/jpg", "image/png", "image/gif", "image/webp"];

				$isValidType = in_array($_FILES["photo"]["type"], $allowedTypes);
				$isValidSize = $_FILES["photo"]["size"] < (1024 * 1024 * 10); // 10mb // todo: maybe make configurable?

				if (!$isValidType) {
					$statusMessage = "Invalid file type. Please upload a JPG, PNG, GIF, or WebP image.";
					$isError = true;
				} elseif (!$isValidSize) {
					$statusMessage = "File is too large. Maximum size is 10MB.";
					$isError = true;
				} else {
					$extension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
					$fileName = uniqid("donation_" . $user["user_id"] . "_", true) . "." . $extension; // 23 random hex chars

					// move from tmp dir to /uploads
					$targetPath = __DIR__ . "/../../public/uploads/donations/" . $fileName;
					if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetPath)) {
						$photoPath = "/uploads/donations/" . $fileName;
					} else {
						$statusMessage = "Error uploading photo. Please try again.";
						$isError = true;
					}
				}
			}

			// create donation if no errors occurred
			if (!$isError) {
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

					$statusMessage = "Donation submitted successfully! Your donation is now pending review.";
				} catch (Exception $e) {
					$statusMessage = "Error submitting donation: " . $e->getMessage();
					$isError = true;
				}
			}
		}

		$this->render("user/donate", [
			"user" => $user,
			"donations" => $this->donationModel->getByDonor($user["user_id"]),
			"statusMessage" => $statusMessage,
			"isError" => $isError,
			"allowDonations" => $allowDonations
		]);
	}

	public function profile() {
		$user = Auth::getUser();
		$this->render("user/profile", [
			"user" => $user,
			"updateStatusMessage" => "",
			"update_isError" => false,
			"deleteStatusMessage" => "",
			"delete_isError" => false
		]);
	}

	public function updateProfile() {
		if ($_SERVER["REQUEST_METHOD"] !== "POST") {
			$this->redirect("/user/profile");
			return;
		}

		$user = Auth::getUser();
		$statusMessage = null;
		$isError = false;

		$email = strtolower(trim($_POST["email"])) ?? "";
		$fullName = ucwords(strtolower(trim($_POST["full_name"]))) ?? "";
		$password = $_POST["new_password"] ?? "";
		$passwordConfirmation = $_POST["password_confirmation"] ?? "";

		// these are autofilled so should exist
		if (empty($fullName) || empty($email)) {
			$statusMessage = "Full name and email are required.";
			$isError = true;
		} else {
			// validate email address
			$emailValidation = $this->accountModel->validateEmailForUse($email);
			if ($email !== $user["email"] && !$emailValidation["success"]) {
				$statusMessage = "Email address is invalid or already registered.";
				$isError = true;
			}
			// validate password if provided
			elseif (!empty($password) || !empty($passwordConfirmation)) {
				if ($password !== $passwordConfirmation) {
					$statusMessage = "Passwords do not match.";
					$isError = true;
				} elseif (strlen($password) < 8) {
					$statusMessage = "Password must be at least 8 characters long.";
					$isError = true;
				}
			}

			// update profile if no errors occurred
			if (!$isError) {
				try {
					$this->accountModel->updateProfile(
						$user["user_id"],
						$fullName,
						$email,
						$password
					);

					Auth::isAuthenticated(); // refresh Auth::$user
					$statusMessage = "Profile updated successfully!";
				} catch (Exception $e) {
					$statusMessage = "Error updating profile: " . $e->getMessage();
					$isError = true;
				}
			}
		}

		$this->render("user/profile", [
			"user" => $user,
			"updateStatusMessage" => $statusMessage,
			"update_isError" => $isError,
			"deleteStatusMessage" => "",
			"delete_isError" => false
		]);
	}

	public function help() {
		$this->render("user/help", [
			"faqs" => [
				["question" => "How do I donate clothes?", "answer" => "To make a donation, go to the Donations page and fill out the form. You can attach a photo if you'd like, as well as a special note. Your donation will be reviewed by a member of staff and its status will be available on the Donations page."],
				["question" => "What happens after I submit a donation?", "answer" => "Your donation will appear with the status 'pending'. A staff member will approve or decline it and the status will be updated on the Donations page."],
				["question" => "Who can see my donations?", "answer" => "Only authorised charity staff and administrators can see donation information."],
				["question" => "Where can I see my donation history?", "answer" => "You can view your donation history from the Donations page."],
				["question" => "How can I delete my account?", "answer" => "You can delete your account by going to the Profile page and confirming your password. This process will remove all information associated with your account."],
				["question" => "Can I change my account information or password?", "answer" => "You can update your account information by going to the Profile page."]
			]
		]);
	}

	public function deleteProfile() {
		if ($_SERVER["REQUEST_METHOD"] !== "POST") {
			$this->redirect("/user/profile");
			return;
		}

		$user = Auth::getUser();
		$password = $_POST["delete_password"] ?? "";
		$statusMessage = null;
		$isError = false;

		// verify password
		$account = $this->accountModel->verifyPassword($user["email"], $password);

		if (!$account) {
			$statusMessage = "Incorrect password. Please try again.";
			$isError = true;
		} else {
			// delete account
			$result = $this->accountModel->deleteAccount($user["user_id"]);

			if ($result["success"]) {
				// log out and go back to login page
				Auth::logoutSession();
				$this->redirect("/login");
				return;
			} else {
				$statusMessage = $result["error"];
				$isError = true;
			}
		}

		$this->render("user/profile", [
			"user" => $user,
			"updateStatusMessage" => "",
			"update_isError" => false,
			"deleteStatusMessage" => $statusMessage,
			"delete_isError" => $isError
		]);
	}
}
