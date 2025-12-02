<?php
	include "session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>DonationStation: Notifications</title>
	<link rel="stylesheet" href="styles/output.css" />
	<link rel="stylesheet" href="styles/style.css" />
</head>

<body class="page-background">
	<div class="page-layout">

		<aside class="sidebar">
			<h1 class="sidebar-logo">DonationStation</h1>
			<div class="sidebar-section">
				<p class="sidebar-section-title">Navigation</p>
				<div class="sidebar-nav-list">
					<button class="nav-button" onclick="location.href='account.php'">Dashboard</button>
					<button class="nav-button" onclick="location.href='user_donate_page.php'">Donations</button>
					<button class="nav-button nav-button-active" onclick="location.href='user_profile.php'">Profile</button>
					<button class="nav-button" onclick="location.href='user_notifications.php'">Notifications</button>
					<button class="nav-button" onclick="location.href='user_help_and_support.php'">Help & Support</button>
				</div>
			</div>
			<div class="sidebar-logout">
				<button class="nav-button" onclick="location.href='logout.php'">Logout</button>
			</div>
		</aside>
    </div>
</body>
</html