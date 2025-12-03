<?php
	include "session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear • System Settings</title>
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
			<div class="mt-6 flex-shrink-0">
				<p class="font-bold text-lg">Navigation</p>
				<div class="mt-4 flex flex-col gap-4">
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='admin_dashboard.php'">Overview</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='admin_manage_users.php'">Manage Users</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='admin_donations.php'">Donations</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-blue-200 text-left cursor-pointer">System Settings</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity">Notifications</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity">Help & Support</button>
				</div>
			</div>

			<div class="mt-6 flex-shrink-0">
				<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='logout.php'">Logout</button>
			</div>
		</aside>

		<main class="flex-1 p-4 sm:p-6 lg:p-8 pt-16 lg:pt-8">

			<section class="mb-6">
				<h2 class="text-2xl font-bold mb-4">System Settings</h2>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-6">
					<h3 class="font-bold text-lg mb-4">General Settings</h3>

					<div class="flex flex-col gap-4">
						<div>
							<label class="block font-bold mb-2">SustainWear</label>
							<input type="text" value="SustainWear" class="w-full border border-gray-300 rounded px-3 py-2" />
						</div>

						<div>
							<label class="block font-bold mb-2">Contact Email</label>
							<input type="email" value="support@sustainwear.com" class="w-full border border-gray-300 rounded px-3 py-2" />
						</div>

						<div>
							<label class="block font-bold mb-2">System Status</label>
							<select class="w-full border border-gray-300 rounded px-3 py-2">
								<option>Active</option>
								<option>Maintenance Mode</option>
							</select>
						</div>
					</div>

					<button class="mt-6 bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 transition-colors">Save General Settings</button>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-6">
					<h3 class="font-bold text-lg mb-4">Donation Settings</h3>

					<div class="flex flex-col gap-4">
						<div>
							<label class="flex items-center gap-2">
								<input type="checkbox" checked class="w-4 h-4" />
								<span>Allow new donations</span>
							</label>
						</div>

						<div>
							<label class="flex items-center gap-2">
								<input type="checkbox" checked class="w-4 h-4" />
								<span>Require staff approval for donations</span>
							</label>
						</div>

						<div>
							<label class="block font-bold mb-2">Maximum items per donation</label>
							<input type="number" value="10" class="w-full border border-gray-300 rounded px-3 py-2" />
						</div>

						<div>
							<label class="block font-bold mb-2">Donation categories (comma-separated)</label>
							<textarea class="w-full border border-gray-300 rounded px-3 py-2 h-20">Shirts, Pants, Dresses, Jackets, Shoes, Accessories</textarea>
						</div>
					</div>

					<button class="mt-6 bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 transition-colors">Save Donation Settings</button>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-6">
					<h3 class="font-bold text-lg mb-4">User Settings</h3>

					<div class="flex flex-col gap-4">
						<div>
							<label class="flex items-center gap-2">
								<input type="checkbox" checked class="w-4 h-4" />
								<span>Allow new user registrations</span>
							</label>
						</div>

						<div>
							<label class="flex items-center gap-2">
								<input type="checkbox" class="w-4 h-4" />
								<span>Require email verification</span>
							</label>
						</div>

						<div>
							<label class="block font-bold mb-2">Default user role</label>
							<select class="w-full border border-gray-300 rounded px-3 py-2">
								<option selected>Donor</option>
								<option>Staff</option>
								<option>Admin</option>
							</select>
						</div>

						<div>
							<label class="block font-bold mb-2">Session timeout (minutes)</label>
							<input type="number" value="60" class="w-full border border-gray-300 rounded px-3 py-2" />
						</div>
					</div>

					<button class="mt-6 bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 transition-colors">Save User Settings</button>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-6">
					<h3 class="font-bold text-lg mb-4">Notification Settings</h3>

					<div class="flex flex-col gap-4">
						<div>
							<label class="flex items-center gap-2">
								<input type="checkbox" checked class="w-4 h-4" />
								<span>Email notifications for new donations</span>
							</label>
						</div>

						<div>
							<label class="flex items-center gap-2">
								<input type="checkbox" checked class="w-4 h-4" />
								<span>Email notifications for user registrations</span>
							</label>
						</div>

						<div>
							<label class="flex items-center gap-2">
								<input type="checkbox" class="w-4 h-4" />
								<span>Daily summary reports</span>
							</label>
						</div>

						<div>
							<label class="block font-bold mb-2">Admin notification email</label>
							<input type="email" value="admin@sustainwear.com" class="w-full border border-gray-300 rounded px-3 py-2" />
						</div>
					</div>

					<button class="mt-6 bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 transition-colors">Save Notification Settings</button>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-6">
					<h3 class="font-bold text-lg mb-4">Emergency Settings</h3>

					<div class="flex flex-col gap-4">
						<div class="border border-red-300 rounded p-4 bg-red-50">
							<p class="font-bold mb-2">Clear all pending donations</p>
							<p class="text-sm text-gray-700 mb-3">This will permanently delete all pending donation requests.</p>
							<button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors">Clear Pending Donations</button>
						</div>

						<div class="border border-red-300 rounded p-4 bg-red-50">
							<p class="font-bold mb-2">Reset database</p>
							<p class="text-sm text-gray-700 mb-3">This will delete all data and reset the system to defaults.</p>
							<button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors">Reset Database</button>
						</div>
					</div>
				</div>
			</section>

		</main>
	</div>

	<script src="js/mobile-menu.js"></script>
</body>
</html> 