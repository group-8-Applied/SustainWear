<?php
	//include "session.php";
	// temp login bypass
	$account_data = [
		"email"     => "test@example.com",
		"full_name" => "Test User",
		"user_role" => "donor",
	];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear: User Dashboard</title>
	<link rel="stylesheet" href="styles/output.css" />
	<link rel="stylesheet" href="styles/style.css" />
</head>

<body class="page-background">
	<div class="page-layout">

		<!-- Sidebar -->
		<aside class="sidebar">
			<h1 class="sidebar-logo">
				SustainWear
			</h1>

			<div class="sidebar-section">
				<p class="sidebar-section-title">Navigation</p>

				<div class="sidebar-nav-list">
					<button class="nav-button nav-button-active">
						Dashboard
					</button>

					<button class="nav-button">
						Donations
					</button>

					<button class="nav-button">
						Profile
					</button>

					<button class="nav-button">
						Notifications
					</button>

					<button class="nav-button">
						Help &amp; Support
					</button>
				</div>
			</div>

			<div class="sidebar-logout">
				<button
					class="nav-button"
					onclick="location.href='logout.php'">
					Logout
				</button>
			</div>
		</aside>

		<!-- Main content -->
		<main class="main-panel">

			<!-- user info + title -->
			<section class="section-block">
				<h2 class="section-title">Dashboard</h2>

				<div class="info-card">
					<div>
						<h3 class="info-label">Email</h3>
						<p><?= $account_data["email"]; ?></p>
					</div>

					<div class="info-group">
						<h3 class="info-label">Full Name</h3>
						<p><?= $account_data["full_name"]; ?></p>
					</div>

					<div class="info-group">
						<h3 class="info-label">Account Type</h3>
						<p><?= $account_data["user_role"]; ?></p>
					</div>
				</div>
			</section>
			<section class="section-block">
				<div class="stats-row">
					<div class="stats-card">
						<p class="info-label">Total Donations</p>
						<p class="stats-value">0</p>
					</div>

					<div class="stats-card">
						<p class="info-label">Pending</p>
						<p class="stats-value">0</p>
					</div>

					<div class="stats-card">
						<p class="info-label">Approved</p>
						<p class="stats-value">0</p>
					</div>
				</div>
			</section>

		</main>
	</div>
</body>
</html>