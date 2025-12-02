<?php
	include "session.php";

	// fake notifications list just for display
	$notificationsExampleData = [
		["title" => "Donation approved", "text" => "Your donation \"Winter Coat\" has been approved by staff.", "time" => "Today · 10:15", "kind" => "good"],
		["title" => "Donation pending review", "text" => "Your donation \"Jeans\" is waiting for a staff member to review it.", "time" => "Yesterday · 16:02", "kind" => "middle"],
		["title" => "Account details updated", "text" => "You changed your email address last week. If this wasn't you, contact support.", "time" => "2025-01-02 · 09:30", "kind" => "info"]
	];
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
					<button class="nav-button" onclick="location.href='user_donate.php'">Donations</button>
					<button class="nav-button" onclick="location.href='user_profile.php'">Profile</button>
					<button class="nav-button nav-button-active" onclick="location.href='user_notifications.php'">Notifications</button>
					<button class="nav-button" onclick="location.href='user_help_and_support.php'">Help & Support</button>
				</div>
			</div>
			<div class="sidebar-logout">
				<button class="nav-button" onclick="location.href='logout.php'">Logout</button>
			</div>
		</aside>
		<!-- main notifications content -->
		<main class="main-panel">
			<section class="section-block">
				<h2 class="section-title"><strong>Notifications</strong></h2>

				<div class="info-card">
					<p>You are logged in as <?=$account_data["full_name"]?> <?=$account_data["email"] ?></p>
					<p>This page shows a simple list of recent activity such as donations, status changes for the user, and account updates.</p>
				</div>
			</section>

			<!-- list of notifications -->
			<section class="section-block">
				<div class="notification-list-box">
					<p class="info-label">
						Recent activity
					</p>
					<ul class="notification-list">
						<?php foreach ($notificationsExampleData as $oneNote): ?>
							<?php
								$dotClass = "notification-dot";
								if ($oneNote["kind"] === "good") {
									$dotClass .= " notification-dot-good";
								} elseif ($oneNote["kind"] === "middle") {
									$dotClass .= " notification-dot-middle";
								} elseif ($oneNote["kind"] === "info") {
									$dotClass .= " notification-dot-info";
								}
							?>
							<li class="notification-item">
								<div class="notification-main-line">
									<span class="<?= $dotClass; ?>"></span>

									<div class="notification-text-block">
										<p class="notification-title">
											<?= htmlspecialchars($oneNote["title"]); ?>
										</p>

										<p class="notification-body">
											<?= htmlspecialchars($oneNote["text"]); ?>
										</p>

										<p class="notification-meta">
											<?= htmlspecialchars($oneNote["time"]); ?>
										</p>
									</div>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>

					<p class="table-hint">DEMO DATA</p>
				</div>
			</section>
		</main>
	</div>
</body>
</html>