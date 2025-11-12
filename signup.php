<?php
	session_start();
	$signup_msg = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$email = $_POST["email"];
		$full_name = $_POST["full_name"];
		$password = $_POST["password"];
		$password_confirmation = $_POST["password-confirmation"];

		
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear • Sign Up</title>
	<link rel="stylesheet" href="styles/output.css" />
	<link rel="stylesheet" href="styles/style.css" />
</head>

<body class="">
	<div class="authWrapper">
		<div class="authCards">
			<h1 class="logo text-2xl">SustainWear</h1>

			<div class="tabs">
				<button id="tab-login" class="tab" type="button" onclick="location.href='login.php'">Log In</button>
				<button id="tab-signup" class="tab active" type="button">Sign Up</button>
			</div>

			<form action="signup.php" method="POST" class="form active">
				<div class="row">
						<label for="su-name">Full name</label>
						<input id="su-name" name="Full Name" type="text" placeholder="Taylor Green" required />
				</div>

				<div class="row">
					<label for="su-email">Email</label>
					<input id="su-email" name="email" type="email" placeholder="you@example.com" required />
				</div>

				<div class="row">
					<label for="su-password">Password</label>
					<input id="su-password" name="password" type="password" placeholder="Create password" required />
				</div>

				<div class="row">
					<label for="su-confirm">Confirm password</label>
					<input id="su-confirm" name="password-confirmation" type="password" placeholder="Confirm password" required />
				</div>

				<button class="btn btn-primary mt-2" type="submit">Create Account</button>
			</form>

			<p class="text-red-500 text-center mt-4">
				<?php echo $signup_msg; ?>
			</p>
		</div>
	</div>
</body>
</html>
