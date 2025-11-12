<?php
	session_start();
	$login_msg = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$email = $_POST["email"];
		$password = $_POST["password"];

		$db = new SQLite3("database.db");

		$statement = $db->prepare("SELECT * FROM accounts WHERE email = :email");
		$statement->bindParam(":email", $email);
		$result = $statement->execute();

		$account_data = $result->fetchArray(SQLITE3_ASSOC);

		if (!$account_data) {
			$login_msg = "No account exists with that email address";
		} else if (password_verify($password, $account_data["password_hash"])) {
			$login_msg = "Login successful";

			// generate and set session token
			$session_token = bin2hex(random_bytes(32));
			$statement = $db->prepare("UPDATE accounts SET session_token = :session_token WHERE email = :email");
			$statement->bindParam(":session_token", $session_token);
			$statement->bindParam(":email", $email);
			$statement->execute();

			// store for authentication
			$_SESSION["session_token"] = $session_token;
			$_SESSION["user_id"] = $account_data["user_id"];

			header("Location: account.php");
		} else {
			$login_msg = "Incorrect password";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear • Log In</title>
	<link rel="stylesheet" href="styles/output.css" />
	<link rel="stylesheet" href="styles/style.css" />
</head>

<body class="">
	<div class="authWrapper">
		<div class="authCards">
			<h1 class="logo text-2xl">SustainWear</h1>

			<div class="tabs">
				<button id="tab-login" class="tab active" type="button">Log In</button>
				<button id="tab-signup" class="tab" type="button" onclick="location.href='signup.php'">Sign Up</button>
			</div>

			<form action="login.php" method="POST" class="form active">
				<div class="row">
					<label for="login-email">Email</label>
					<input id="login-email" name="email" type="email" placeholder="you@example.com" required />
				</div>
				<div class="row">
					<label for="login-password">Password</label>
					<input id="login-password" name="password" type="password" placeholder="••••••••" required />
				</div>

				<button class="btn btn-primary mt-2" type="submit">Sign In</button>
			</form>

			<p class="text-red-500 text-center mt-4">
				<?php echo $login_msg; ?>
			</p>
		</div>
	</div>
</body>
</html>
