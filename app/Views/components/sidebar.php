<?php
$user = Auth::getUser();
$userRole = $user["user_role"];

// Used to highlight current page
$currentPath = $_SERVER["REQUEST_URI"];

// Set navigation options based on user role
if ($userRole === "admin") {
	$navItems = [
		["label" => "Overview", "url" => "/admin/dashboard"],
		["label" => "Manage Users", "url" => "/admin/users"],
		["label" => "Donations", "url" => "/admin/donations"],
		["label" => "System Settings", "url" => "/admin/settings"]
	];
} elseif ($userRole === "staff") {
	$navItems = [
		["label" => "Overview", "url" => "/staff/dashboard"],
		["label" => "Pending Donations", "url" => "/staff/pending-donations"],
		["label" => "Donations", "url" => "/admin/donations"],
		["label" => "Inventory", "url" => "/staff/inventory"],
		["label" => "Reports", "url" => "/staff/reports"]
	];
} else { // donor
	$navItems = [
		["label" => "Dashboard", "url" => "/user/dashboard"],
		["label" => "Donations", "url" => "/user/donate"],
		["label" => "Profile", "url" => "/user/profile"],
		["label" => "Notifications", "url" => "/user/notifications"],
		["label" => "Help & Support", "url" => "/user/help"],
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
			<?php foreach ($navItems as $item):
				$isCurrent = ($currentPath === $item["url"]); ?>

				<button
					class="w-full border border-gray-300 rounded px-3 py-2 text-left cursor-pointer transition-opacity
					<?= $isCurrent ? "bg-blue-200" : "bg-gray-200 hover:opacity-90" ?>"
					<?= !$isCurrent ? "onclick=\"location.href='{$item["url"]}'\"" : "" ?>
				>
				<?= $item["label"] ?>
				</button>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="mt-6 flex-shrink-0">
		<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='/logout'">Logout</button>
	</div>
</aside>
