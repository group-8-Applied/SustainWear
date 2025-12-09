<?php

class Auth {
	private static $user = null;

	public static function initSession() {
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
	}

	public static function isAuthenticated() {
		self::initSession();

		if (!isset($_SESSION["session_token"]) || !isset($_SESSION["user_id"])) {
			return false;
		}

		$db = Database::getInstance();
		$user = $db->fetchOne(
			"SELECT * FROM accounts WHERE user_id = :user_id",
			[":user_id" => $_SESSION["user_id"]]
		);

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

	public static function loginWithSession($userId, $sessionToken) {
		self::initSession();

		$_SESSION["user_id"] = $userId;
		$_SESSION["session_token"] = $sessionToken;

		Auth::redirectToDashboard();
	}

	public static function logoutSession() {
		self::initSession();
		session_destroy();
	}

	public static function requireRole($allowedRole) {
		// if signed out, redirect to login
		if (!self::isAuthenticated()) {
			header("Location: /login");
			exit();
		}

		// if wrong role, redirect to correct dashboard
		if (self::getUserRole() !== $allowedRole) {
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
