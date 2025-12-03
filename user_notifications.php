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
	<title>SustainWear • Notifications</title>
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
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-blue-200 text-left cursor-pointer" onclick="location.href='user_notifications.php'">Notifications</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='user_help_and_support.php'">Help & Support</button>
				</div>
			</div>

			<div class="mt-6 flex-shrink-0">
				<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='logout.php'">Logout</button>
			</div>
		</aside>

		<main class="flex-1 p-4 sm:p-6 lg:p-8 pt-16 lg:pt-8">
			<section class="mb-6">
				<h2 class="text-2xl font-bold mb-4"><strong>Notifications</strong></h2>

				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p>You are logged in as <?=$account_data["full_name"]?> <?=$account_data["email"] ?></p>
					<p>This page shows a simple list of recent activity such as donations, status changes for the user, and account updates.</p>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg">
						Recent activity
					</p>
					<ul class="list-none mt-3 p-0">
						<?php foreach ($notificationsExampleData as $oneNote): ?>
							<?php
								$dotClass = "w-2 h-2 rounded-full flex-shrink-0 mt-1";
								if ($oneNote["kind"] === "good") {
									$dotClass .= " bg-green-500";
								} elseif ($oneNote["kind"] === "middle") {
									$dotClass .= " bg-amber-500";
								} elseif ($oneNote["kind"] === "info") {
									$dotClass .= " bg-blue-500";
								}
							?>
							<li class="border-b border-gray-200 py-[0.6rem]">
								<div class="flex items-start gap-2">
									<span class="<?= $dotClass; ?>"></span>

									<div class="flex-1">
										<p class="font-semibold text-[0.95rem] mb-[0.15rem]">
											<?= htmlspecialchars($oneNote["title"]); ?>
										</p>

										<p class="text-[0.85rem] mb-[0.15rem]">
											<?= htmlspecialchars($oneNote["text"]); ?>
										</p>

										<p class="text-xs text-gray-500">
											<?= htmlspecialchars($oneNote["time"]); ?>
										</p>
									</div>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>

					<p class="mt-2 text-xs text-gray-500">DEMO DATA</p>
				</div>
			</section>
		</main>
	</div>

	<script src="js/mobile-menu.js"></script>
</body>
</html>
