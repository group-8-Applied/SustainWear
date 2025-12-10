<?php

class Auth {
	private static $user = null;

	public static function initSession() {
		if (session_status() === PHP_SESSION_NONE) {
			$settingsModel = new Settings();
			$timeoutSeconds = $settingsModel->getSessionTimeout() * 60 * 60;

			// set $_SESSION lifetime
			session_set_cookie_params($timeoutSeconds);

			session_start();
		}
	}

	public static function isAuthenticated() {
		self::initSession();

		// if we don't have a session to verify
		if (!isset($_SESSION["session_token"]) || !isset($_SESSION["user_id"])) {
			return false;
		}

		$settingsModel = new Settings();
		$timeoutSeconds = $settingsModel->getSessionTimeout() * 60 * 60;

		// if it has been more than $timeoutSeconds since user was last active
		if (time() - $_SESSION["last_activity_time"] > $timeoutSeconds) {
			self::logoutSession();
			return false;
		}

		// update activity time
		$_SESSION["last_activity_time"] = time();

		// get user info for session's user ID
		$user = Database::getInstance()->fetchOne(
			"SELECT * FROM accounts WHERE user_id = :user_id",
			[":user_id" => $_SESSION["user_id"]]
		);

		// check session's stored session token against database
		if (!$user || $user["session_token"] !== $_SESSION["session_token"]) {
			return false;
		}

		self::$user = $user;
		return true;
	}

	public static function getUser() {
		return self::$user;
	}

	public static function getUserRole() {
		return self::$user ? self::$user["user_role"] : null;
	}

	public static function loginWithSession($userID, $sessionToken) {
		self::initSession();

		// set up session info
		$_SESSION["user_id"] = $userID;
		$_SESSION["session_token"] = $sessionToken;
		$_SESSION["last_activity_time"] = time();

		Auth::redirectToDashboard();
	}

	public static function logoutSession() {
		self::initSession();
		session_destroy();
	}

	public static function requireRole($allowedRole, $strict = true) {
		// if signed out, redirect to login
		if (!self::isAuthenticated()) {
			header("Location: /login");
			exit();
		}

		if ($strict && self::getUserRole() !== $allowedRole) {
			self::redirectToDashboard();
		}

		// use hierarchical system
		$roles = ["donor", "staff", "admin"];
		$index = array_search(self::getUserRole(), $roles);
		$indexAllowed = array_search($allowedRole, $roles);
		
		// if role doesn't have access, redirect to the user's dashboard
		if ($index < $indexAllowed) {
			self::redirectToDashboard();
		}
	}

	public static function redirectToDashboard() {
		switch (self::getUserRole()) {
			case "admin":
				header("Location: /admin/dashboard");
				break;
			case "staff":
				header("Location: /staff/dashboard");
				break;
			default:
				header("Location: /user/dashboard");
				break;
		}
		exit();
	}

	public static function requireGuest() {
		self::initSession();

		// if a signed-in user is loading guest page, redirect to dashboard
		if (self::isAuthenticated()) {
			self::redirectToDashboard();
		}
	}
}
