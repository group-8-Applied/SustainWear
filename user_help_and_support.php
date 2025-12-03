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
	<title>SustainWear • Help & Support</title>
	<link rel="stylesheet" href="styles/output.css" />
</head>

<body class="bg-gray-200 min-h-screen">
	<div class="flex flex-col lg:flex-row-reverse min-h-screen">

		<button id="mobile-menu-btn" class="lg:hidden fixed top-4 right-4 z-50 bg-white p-2 rounded-lg shadow-md hover:bg-gray-50 transition-opacity duration-150">
			<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
			</svg>
		</button>

		<aside id="sidebar" class="fixed lg:relative top-0 right-0 h-screen lg:h-auto w-64 bg-white shadow-lg lg:shadow-md p-8 max-h-[640px]:pb-20 flex flex-col z-40 lg:z-auto transition-transform duration-300 ease-in-out lg:flex-shrink-0 order-last overflow-y-auto" style="transform: translateX(100%)">
			<h1 class="font-extrabold text-2xl text-center text-green-700 flex-shrink-0">SustainWear</h1>
			<div class="mt-6 flex-shrink-0 pb-6">
				<p class="font-bold text-lg">Navigation</p>
				<div class="mt-4 flex flex-col gap-4">
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='account.php'">Dashboard</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='user_donate.php'">Donations</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='user_profile.php'">Profile</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='user_notifications.php'">Notifications</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-blue-200 text-left cursor-pointer">Help & Support</button>
				</div>
			</div>

			<div class="mt-6 flex-shrink-0">
				<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='logout.php'">Logout</button>
			</div>
		</aside>

		<main class="flex-1 p-4 sm:p-6 lg:p-8 pt-16 lg:pt-8">

			<section class="mb-6">
				<h2 class="text-2xl font-bold mb-4">
					Help &amp; Support
				</h2>

				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
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

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg">
						Common questions
					</p>

					<ul class="list-none mt-3 p-0">
						<?php foreach ($helpQuestionsFakeList as $oneHelpRow): ?>
							<li class="border-b border-gray-200 py-[0.6rem]">
								<p class="font-semibold text-[0.95rem] mb-[0.15rem]">
									<?= htmlspecialchars($oneHelpRow["question"]); ?>
								</p>

								<p class="text-[0.85rem] mb-[0.15rem]">
									<?= htmlspecialchars($oneHelpRow["answer"]); ?>
								</p>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg">
						Contact support
					</p>
					<p class="text-sm text-gray-600 mt-1">Use this form to describe a problem or ask a question. Not functional as of right now</p>

					<form method="POST" class="mt-3">
						<div class="flex flex-wrap gap-4 mt-3">
							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="help_name">Your name</label>
								<input id="help_name" name="help_name" type="text" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="How should we address you?" />
							</div>
							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="help_topic">Topic (optional)</label>
								<input id="help_topic" name="help_topic" type="text" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="e.g. Donations, Login, Account" />
							</div>
						</div>
						<div class="flex flex-wrap gap-4 mt-3">
							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="help_message">What do you need help with?</label>
								<textarea id="help_message" name="help_message" rows="4" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Write a short description of the issue."></textarea>
							</div>
						</div>
						<div class="flex flex-wrap gap-4 mt-3">
							<button type="submit" class="border border-gray-300 rounded bg-blue-500 text-white text-xs cursor-pointer mr-1 px-2 py-1 hover:bg-blue-600 transition-colors">Send message</button>
						</div>
					</form>
				</div>
			</section>
		</main>
	</div>

	<script src="js/mobile-menu.js"></script>
</body>
</html>
