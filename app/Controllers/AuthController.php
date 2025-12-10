<?php

class AuthController extends ControllerBase {
	private $accountModel;
	private $settingsModel;

	public function __construct() {
		$this->accountModel = new Account();
		$this->settingsModel = new Settings();
	}

	public function showLogin() {
		$this->render("auth/login", ["login_msg" => ""]);
	}

	public function attemptLogin() {
		if ($_SERVER["REQUEST_METHOD"] !== "POST") {
			$this->redirect("/login");
			return;
		}

		$email = strtolower(trim($_POST["email"]));
		$password = $_POST["password"];

		$account = $this->accountModel->verifyPassword($email, $password);

		if (!$account) {
			$this->render("auth/login", ["login_msg" => "Invalid email or password"]);
			return;
		}

		// assign random session token
		$sessionToken = $this->accountModel->updateSessionToken($account["user_id"]);

		// sign the user in
		Auth::loginWithSession($account["user_id"], $sessionToken);
	}

	public function showSignup() {
		$allowRegistrations = $this->settingsModel->allowRegistrations();
		$this->render("auth/signup", [
			"statusMessage" => $allowRegistrations ? "" : "Registrations are closed",
			"allowRegistrations" => $allowRegistrations
		]);
	}

	public function signup() {
		if ($_SERVER["REQUEST_METHOD"] !== "POST") {
			$this->redirect("/signup");
			return;
		}

		$allowRegistrations = $this->settingsModel->allowRegistrations();

		$email = strtolower(trim($_POST["email"]));
		$fullName = ucwords(strtolower(trim($_POST["full_name"])));
		$password = $_POST["password"];
		$passwordConfirmation = $_POST["password_confirmation"];

		$errors = [];

		if (!$allowRegistrations) {
			$errors[] = "Registrations are closed";
		}
		
		// password validation
		if ($password !== $passwordConfirmation) {
			$errors[] = "Passwords do not match";
		}

		if (strlen($password) < 8) {
			$errors[] = "Password is too short";
		}

		if (substr_count($fullName, " ") < 1 || count(count_chars($fullName, 1)) < 4) {
			$errors[] = "Name invalid";
		}

		// validate email address
		$emailValidation = $this->accountModel->validateEmailForUse($email);
		if (!$emailValidation["success"]) {
			$errors = array_merge($errors, $emailValidation["errors"]);
		}

		if (!empty($errors)) {
			$this->render("auth/signup", [
				"statusMessage" => implode(", ", $errors),
				"allowRegistrations" => $allowRegistrations
			]);
			return;
		}

		// create user
		$result = $this->accountModel->createAccount($fullName, $email, $password);

		// sign the user in
		Auth::loginWithSession($result["user_id"], $result["session_token"]);
	}

	public function logout() {
		Auth::logoutSession();
		$this->redirect("/login");
	}
}
