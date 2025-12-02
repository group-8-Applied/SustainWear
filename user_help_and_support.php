<?php
	include "session.php";

	// some fake FAQ items just for display
	$helpQuestionsFakeList = [
		["question" => "How do I donate clothes?", "answer" => "Go to the Donations page, fill in the item details, and submit the form. Staff will then review your donation."],
		["question" => "What happens after I submit a donation?", "answer" => "Your donation will appear with the status Pending. A staff member will approve or decline it and the status will update."],
		["question" => "I forgot my password, what do I do?", "answer" => "On the login screen, use the Forgot password link. You will be emailed instructions to reset it (planned feature)."],
		["question" => "Who can see my donations?", "answer" => "Only authorised charity staff and administrators can see detailed donation information."]
	];
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>DonationStation: Help & Support</title>
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
					<button class="nav-button" onclick="location.href='user_notifications.php'">Notifications</button>
					<button class="nav-button nav-button-active">Help & Support</button>
				</div>
			</div>
			<div class="sidebar-logout">
				<button class="nav-button" onclick="location.href='logout.php'">Logout</button>
			</div>
		</aside>

		<!-- main help content -->
		<main class="main-panel">

			<!-- intro card -->
			<section class="section-block">
				<h2 class="section-title">
					Help &amp; Support
				</h2>

				<div class="info-card">
					<p>
						You are logged in as
						<strong><?= htmlspecialchars($account_data["full_name"]); ?></strong><br />
						<?= htmlspecialchars($account_data["email"]); ?>
					</p>
					<p>
						This page is where you can find quick answers and send a short
						message to support. For now, everything here is demo-only and
						does not send real emails.
					</p>
				</div>
			</section>

			<!-- FAQ style list -->
			<section class="section-block">
				<div class="help-questions-box">
					<p class="info-label">
						Common questions
					</p>

					<ul class="help-list">
						<?php foreach ($helpQuestionsFakeList as $oneHelpRow): ?>
							<li class="help-item">
								<p class="help-question">
									<?= htmlspecialchars($oneHelpRow["question"]); ?>
								</p>

								<p class="help-answer">
									<?= htmlspecialchars($oneHelpRow["answer"]); ?>
								</p>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</section>

			<!-- simple contact-style form -->
			<section class="section-block">
				<div class="help-contact-box">
					<p class="info-label">
						Contact support
					</p>
					<p class="help-contact-text">Use this form to describe a problem or ask a question. Not functional as of right now</p>

					<!-- youtube video helped with forms (https://www.youtube.com/watch?v=2O8pkybH6po, https://www.youtube.com/watch?v=VLeERv_dR6Q)-->
					<form method="POST" class="help-form-box">
						<div class="help-form-row">
							<div class="help-form-field">
								<label class="filter-label-text" for="help_name">Your name</label>
								<input id="help_name" name="help_name" type="text" class="filter-text-input" placeholder="How should we address you?" />
							</div>
							<div class="help-form-field">
								<label class="filter-label-text" for="help_topic">Topic (optional)</label>
								<input id="help_topic" name="help_topic" type="text" class="filter-text-input" placeholder="e.g. Donations, Login, Account" />
							</div>
						</div>
						<div class="help-form-row">
							<div class="help-form-field">
								<label class="filter-label-text" for="help_message">What do you need help with?</label>
								<textarea id="help_message" name="help_message" rows="4" class="filter-text-input" placeholder="Write a short description of the issue."></textarea>
							</div>
						</div>
						<div class="help-form-row">
							<button type="submit" class="table-button">Send message</button>
						</div>
					</form>
				</div>
			</section>
		</main>
	</div>
</body>
</html>