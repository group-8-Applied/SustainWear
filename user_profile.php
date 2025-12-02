<?php
	include "session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear • Profile</title>
	<link rel="stylesheet" href="styles/output.css" />
</head>

<body class="bg-gray-200 min-h-screen">
	<div class="flex flex-col lg:flex-row-reverse min-h-screen">

		<button id="mobile-menu-btn" class="lg:hidden fixed top-4 right-4 z-50 bg-white p-2 rounded-lg shadow-md hover:bg-gray-50 transition-opacity duration-150">
			<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
			</svg>
		</button>

		<aside id="sidebar" class="fixed lg:relative top-0 right-0 h-screen lg:h-auto w-64 bg-white shadow-lg lg:shadow-md p-8 flex flex-col z-40 lg:z-auto transition-transform duration-300 ease-in-out lg:flex-shrink-0 order-last" style="transform: translateX(100%)">
			<h1 class="font-extrabold text-2xl text-center text-green-700">SustainWear</h1>
			<div class="mt-6">
				<p class="font-bold text-lg">Navigation</p>
				<div class="mt-4 flex flex-col gap-4">
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='account.php'">Dashboard</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='user_donate.php'">Donations</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-blue-200 text-left cursor-pointer" onclick="location.href='user_profile.php'">Profile</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='user_notifications.php'">Notifications</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='user_help_and_support.php'">Help & Support</button>
				</div>
			</div>
			<div class="mt-auto">
				<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='logout.php'">Logout</button>
			</div>
		</aside>

		<main class="flex-1 p-4 sm:p-6 lg:p-8 pt-16 lg:pt-8">
			<section class="mb-6">
				<h2 class="text-2xl font-bold mb-4">Profile</h2>
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p>You are logged in as <?= $account_data["full_name"]?> (<?= $account_data["email"]?>)</p>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<h3 class="font-bold text-lg">Edit profile details</h3>
					<form method="post" class="mt-3">
						<div class="flex flex-col sm:flex-row gap-4 sm:gap-8 mt-3">
							<div class="flex-1 flex flex-col">
								<label class="block text-sm mb-1" for="Name"><strong>Full Name</strong></label>
								<input id="Name" type="text" name="Name" placeholder="Enter your full name" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
							</div>

							<div class="flex-1 flex flex-col">
								<label class="block text-sm mb-1" for="Email"><strong>Email Address</strong></label>
								<input id="Email" type="email" name="Email" placeholder="Enter your email address" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
							</div>
						</div>

						<div class="flex flex-col sm:flex-row gap-4 sm:gap-8 mt-3">
							<div class="flex-1 flex flex-col">
								<label class="block text-sm mb-1" for="Password"><strong>New Password</strong></label>
								<input id="Password" type="password" name="Password" placeholder="Leave blank to keep current password" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
							</div>

							<div class="flex-1 flex flex-col">
								<label class="block text-sm mb-1" for="confirm_pass"><strong>Confirm New Password</strong></label>
								<input id="confirm_pass" type="password" name="confirm_pass" placeholder="Confirm your new password" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
							</div>
						</div>

						<div class="flex flex-wrap gap-4 mt-3">
							<button class="border border-gray-300 rounded bg-blue-500 text-white text-xs cursor-pointer mr-1 px-2 py-1 hover:bg-blue-600 transition-colors" type="submit">Save Changes</button>
						</div>
					</form>
				</div>
			</section>
		</main>
	</div>

	<script src="js/mobile-menu.js"></script>
</body>
</html>
