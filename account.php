<?php
	include "session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear • Account</title>
	<link rel="stylesheet" href="styles/output.css" />
	<link rel="stylesheet" href="styles/style.css" />
</head>

<body>
	<div class="authWrapper">
		<div class="authCards">
			<h1 class="logo text-2xl">SustainWear</h1>

			<div>
				<div>
					<h1 class="font-bold text-lg">Email</h1>
					<p><?php echo $account_data["email"]; ?> </p>
				</div>

				<div class="pt-4">
					<h1 class="font-bold text-lg">Full Name</h1>
					<p><?php echo $account_data["full_name"]; ?> </p>
				</div>
			</div>

			<!-- <form id="form-login" class="form active">
				<div class="row">
					<label for="login-email">Email</label>
					<input id="login-email" type="email" placeholder="you@example.com" required />
				</div>
				<div class="row">
					<label for="login-password">Password</label>
					<input id="login-password" type="password" placeholder="••••••••" required />
				</div>

				<div class="row">
					<label for="login-role">Role (demo)</label>
					<select id="login-role" required>
						<option value="" selected disabled>Select a role</option>
						<option value="donor">Donor</option>
						<option value="staff">Charity Staff</option>
						<option value="admin">Admin</option>
					</select>
				</div>

				<div class="actions">
					<label><input id="login-remember" type="checkbox" />Remember me</label>
					<a href="#" id="link-forgot">Forgot password?</a>
				</div>

				<button class="btn btn-primary" type="submit">Sign In</button>
			</form> -->

			<!-- <form id="form-signup" class="form">
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

				<button class="btn btn-primary" type="submit">Create Account</button>
			</form> -->
		</div>
	</div>

	<!-- <div id="twofa-backdrop" class="modal-backdrop">
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
	</div> -->

	<script src="scripts/main.js"></script>
</body>
</html>
