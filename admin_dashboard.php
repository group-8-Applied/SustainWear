<?php
	include "session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear: Admin Dashboard</title>
	<link rel="stylesheet" href="styles/output.css" />
</head>

<body class="bg-gray-200 min-h-screen">
	<div class="flex flex-col lg:flex-row-reverse min-h-screen">

		<button id="mobile-menu-btn" class="lg:hidden fixed top-4 right-4 z-50 bg-white p-2 rounded-lg shadow-md hover:bg-gray-50 transition-opacity duration-150">
			<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
			</svg>
		</button>

		<aside id="sidebar" class="fixed lg:relative top-0 right-0 h-screen lg:h-auto w-64 bg-white shadow-lg lg:shadow-md p-8 pb-26 max-h-[640px]:pb-20 flex flex-col z-40 lg:z-auto transition-transform duration-300 ease-in-out lg:flex-shrink-0 order-last overflow-y-auto" style="transform: translateX(100%)">
			<h1 class="font-extrabold text-2xl text-center text-green-700 flex-shrink-0">SustainWear</h1>
			<div class="mt-6 flex-shrink-0 pb-6">
				<p class="font-bold text-lg">Navigation</p>
				<div class="mt-4 flex flex-col gap-4">
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-blue-200 text-left cursor-pointer">Overview</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='admin_manage_users.php'">Manage Users</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity">Donations</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity">System Settings</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity">Notifications</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity">Help Support</button>
				</div>
			</div>

			<div class="mt-auto flex-shrink-0">
				<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='logout.php'">Logout</button>
			</div>
		</aside>

		<main class="flex-1 p-4 sm:p-6 lg:p-8 pt-16 lg:pt-8">

			<section class="mb-6">
				<h2 class="text-2xl font-bold mb-4">Admin Dashboard</h2>

				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5 flex flex-col gap-3 items-start">
					<div>
						<h3 class="font-bold text-lg">Full Name</h3>
						<p><?= $account_data["full_name"]; ?></p>
					</div>

					<div class="mt-4">
						<h3 class="font-bold text-lg">Email</h3>
						<p><?= $account_data["email"]; ?></p>
					</div>

					<div class="mt-4">
						<h3 class="font-bold text-lg">Role</h3>
						<p><?= $account_data["user_role"]; ?></p>
					</div>
				</div>
			</section>
			<section class="mb-6">
				<div class="flex flex-col sm:flex-row gap-4">

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Total Users</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1">64</p>
					</div>

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Active Donors</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1">27</p>
					</div>

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Staff Accounts</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1">7</p>
					</div>
				</div>
			</section>
		</main>
	</div>

	<script src="js/mobile-menu.js"></script>
</body>
</html>
