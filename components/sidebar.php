<?php
// Used to highlight current page
$current_page = basename($_SERVER["PHP_SELF"]);

// Set navigation options based on user role
if ($account_data["user_role"] === "admin") {
	$nav_items = [
		["label" => "Overview", "url" => "admin_dashboard.php"],
		["label" => "Manage Users", "url" => "admin_manage_users.php"],
		["label" => "Donations", "url" => "admin_donations.php"],
		["label" => "System Settings", "url" => "admin_system_settings.php"]
	];
} else if ($account_data["user_role"] === "staff") {
	$nav_items = [
		["label" => "Overview", "url" => "staff_dashboard.php"],
		["label" => "Pending Donations", "url" => "staff_pending_donations.php"],
		["label" => "Inventory", "url" => "staff_inventory.php"],
		["label" => "Reports", "url" => "staff_reports.php"]
	];
} else { // donor
	$nav_items = [
		["label" => "Dashboard", "url" => "account.php"],
		["label" => "Donations", "url" => "user_donate.php"],
		["label" => "Profile", "url" => "user_profile.php"],
		["label" => "Notifications", "url" => "user_notifications.php"],
		["label" => "Help & Support", "url" => "user_help_and_support.php"],
	];
}
?>

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
			<?php foreach ($nav_items as $item):
				$is_current = ($current_page === $item["url"]); ?>

				<button
					class="w-full border border-gray-300 rounded px-3 py-2 text-left cursor-pointer transition-opacity
					<?= // Highlight current page
					$is_current ? "bg-blue-200" : "bg-gray-200 hover:opacity-90" ?>"
					<?= // Link to page if not current
					!$is_current ? "onclick=\"location.href='{$item["url"]}'\"" : "" ?>
				>
				<?= $item["label"] ?>
				</button>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="mt-6 flex-shrink-0">
		<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='logout.php'">Logout</button>
	</div>
</aside>
