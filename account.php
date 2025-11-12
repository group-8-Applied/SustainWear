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
					<p><?= $account_data["email"]; ?></p>
				</div>

				<div class="pt-4">
					<h1 class="font-bold text-lg">Full Name</h1>
					<p><?= $account_data["full_name"]; ?></p>
				</div>

				<div class="pt-4">
					<h1 class="font-bold text-lg">Account Type</h1>
					<p><?= $account_data["user_role"]; ?></p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
