<?php
	session_start();
	
	$db = new SQLite3("database.db");

	$logged_in = true;
	
	if (!isset($_SESSION["session_token"]) || !isset($_SESSION["user_id"])) {
		$logged_in = false;
		header("Location: login.php");
		exit();
	}

	$statement = $db->prepare("SELECT * FROM accounts WHERE user_id = :user_id");
	$statement->bindParam(":user_id", $_SESSION["user_id"]);
	$result = $statement->execute();
	$account_data = $result->fetchArray(SQLITE3_ASSOC);
	$user_role = $account_data["user_role"];

	// ensure the session is still valid
	if ($account_data["session_token"] !== $_SESSION["session_token"]) {
		$logged_in = false;
		header("Location: login.php");
		exit();
	}

	$is_admin_page = strpos($_SERVER["REQUEST_URI"], "/admin_") !== false;
	$is_staff_page = strpos($_SERVER["REQUEST_URI"], "/staff_") !== false;

	if ($user_role === "admin") {
		if (!$is_admin_page) {
			header("Location: admin_dashboard.php");
			exit();
		}
	} else if ($user_role === "staff") {
		if (!$is_staff_page) {
			header("Location: staff_dashboard.php");
			exit();
		}
	} else if ($is_admin_page || $is_staff_page) {
		header("Location: account.php");
		exit();
	}
?>
