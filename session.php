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

	// ensure the session is still valid
	if ($account_data["session_token"] !== $_SESSION["session_token"]) {
		$logged_in = false;
		header("Location: login.php");
	}
?>
