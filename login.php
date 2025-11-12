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
	<title>SustainWear • Login</title>
	<link rel="stylesheet" href="styles/output.css" />
	<link rel="stylesheet" href="styles/style.css" />
</head>

<body class="">
	<div class="authWrapper">
		<div class="authCards">
			<h1 class="logo text-2xl">SustainWear</h1>

			<div class="tabs">
				<button id="tab-login" class="tab active" type="button">Login</button>
				<button id="tab-signup" class="tab" type="button">Sign Up</button>
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

				<!-- <div class="row">
					<label for="login-role">Role (demo)</label>
					<select id="login-role" required>
						<option value="" selected disabled>Select a role</option>
						<option value="donor">Donor</option>
						<option value="staff">Charity Staff</option>
						<option value="admin">Admin</option>
					</select>
				</div> -->

				<!-- <div class="actions">
					<label><input id="login-remember" type="checkbox" />Remember me</label>
					<a href="#" id="link-forgot">Forgot password?</a>
				</div> -->

				<button class="btn btn-primary" type="submit">Sign In</button>
			</form>

			<p class="text-red-500 text-center mt-4">
				<?php echo $login_msg; ?>
			</p>

			<form id="form-signup" class="form">
				<div class="row">
						<label for="su-name">Full name</label>
						<input id="su-name" type="text" placeholder="Taylor Green" required />
				</div>

				<div class="row">
					<label for="su-email">Email</label>
					<input id="su-email" type="email" placeholder="you@example.com" required />
				</div>

				<div class="row">
					<label for="su-password">Password</label>
					<input id="su-password" type="password" placeholder="Create password" required />
				</div>

				<div class="row">
					<label for="su-confirm">Confirm password</label>
					<input id="su-confirm" type="password" placeholder="Confirm password" required />
				</div>

				<button class="btn btn-primary" type="submit">Create Account (DISABLED)</button>
			</form>
		</div>
	</div>

	<div id="twofa-backdrop" class="modal-backdrop">
		<div class="modal">
			<h3>Two-Factor Verification</h3>
			<p>Enter the 6-digit code from your authenticator app.</p>
			<div class="row" style="margin-top:8px;">
				<input id="twofa-code" inputmode="numeric" maxlength="6" placeholder="123456" />
			</div>

			<div class="actions" style="margin-top:12px;">
				<button id="twofa-cancel" class="btn btn-ghost" type="button">Cancel</button>
				<button id="twofa-verify" class="btn btn-primary" type="button">Verify</button>
			</div>
		</div>
	</div>

	<script src="scripts/main.js"></script>
</body>
</html>
