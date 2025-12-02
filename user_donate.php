<?php
	include "session.php";

	$donationMessage = "";
	$pastDonationsExampleData = [
		["item" => "Winter Coat", "size" => "M", "condition" => "Good", "status" => "Approved", "date" => "2025-01-04"],
		["item" => "Jeans", "size" => "32", "condition" => "Acceptable", "status" => "Pending", "date" => "2025-01-06"],
		["item" => "T-Shirt", "size" => "L", "condition" => "Excellent", "status" => "Declined", "date" => "2025-01-02"]
	];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear • Donate Clothes</title>
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
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='account.php'">Dashboard</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-blue-200 text-left cursor-pointer">Donations</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='user_profile.php'">Profile</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='user_notifications.php'">Notifications</button>
					<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='user_help_and_support.php'">Help & Support</button>
				</div>
			</div>
			<div class="mt-auto flex-shrink-0">
				<button class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-200 text-left cursor-pointer hover:opacity-90 transition-opacity" onclick="location.href='logout.php'">Logout</button>
			</div>
		</aside>

		<main class="flex-1 p-4 sm:p-6 lg:p-8 pt-16 lg:pt-8">
			<section class="mb-6">
				<h2 class="text-2xl font-bold mb-4">My Donations</h2>

				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5 flex flex-col gap-3 items-start">
					<p>You are logged in as <?=$account_data["full_name"]?> <br> <?=$account_data["email"] ?>.</p>
					<p>Use the form below to record a clothing donation. Staff will review it and later change the status to <strong class="text-green-600">Approved</strong> or <strong class="text-red-500">Declined</strong>.</p>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<h3 class="font-bold text-lg">New donation</h3>
					<form method="POST" class="mt-3">
						<div class="flex flex-wrap gap-4 mt-3">
							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="donation_item">Item type</label>
								<select id="donation_item" name="donation_item" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
									<option value="">Pick an item…</option>
									<option value="Coat">Coat / Jacket</option>
									<option value="Jeans">Jeans</option>
									<option value="T-Shirt">T-Shirt</option>
									<option value="Shoes">Shoes</option>
									<option value="Other">Other clothing</option>
								</select>
							</div>

							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="donation_size">Size</label>
								<input id="donation_size" name="donation_size" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="text" placeholder="example: M, 32, 8" />
							</div>

							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="donation_condition">Condition</label>
								<select id="donation_condition" name="donation_condition" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
									<option value="">Select condition…</option>
									<option value="Excellent">Excellent</option>
									<option value="Good">Good</option>
									<option value="Acceptable">Acceptable</option>
								</select>
							</div>
						</div>

						<div class="flex flex-wrap gap-4 mt-3">
							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="donation_notes">Notes (optional)</label>
								<textarea id="donation_notes" name="donation_notes" rows="3" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Anything else staf should know?"></textarea>
							</div>
						</div>

						<div class="flex flex-wrap gap-4 mt-3">
							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1">Photo (coming later)</label>
								<input type="file" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-gray-100 cursor-not-allowed" disabled />
								<p class="text-xs text-gray-500">Photos don't work currently, this is just so where the field will be.</p>
							</div>
						</div>

						<div class="flex flex-wrap gap-4 mt-3">
							<button type="submit" class="border border-gray-300 rounded bg-blue-500 text-white text-xs cursor-pointer mr-1 px-2 py-1 hover:bg-blue-600 transition-colors">Submit donation</button>
						</div>
					</form>

					<?php if ($donationMessage !== ""): ?>
						<p class="mt-3 text-[0.8rem] text-green-600"><?= $donationMessage ?></p>
					<?php endif ?>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">Donation history</p>
					<div class="overflow-x-auto -mx-4 sm:mx-0">
						<table class="w-full min-w-[600px] border-collapse text-sm">
							<thead class="bg-gray-100">
								<tr>
									<th class="px-3 py-2 text-left border-b border-gray-200">Item</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Size</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Condition</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Status</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Date</th>
								</tr>
							</thead>

							<tbody>
								<?php foreach ($pastDonationsExampleData as $oneRow): ?>
									<tr>
										<td class="px-3 py-2 text-left border-b border-gray-200"><?= htmlspecialchars($oneRow["item"]) ?></td>
										<td class="px-3 py-2 text-left border-b border-gray-200"><?= htmlspecialchars($oneRow["size"]) ?></td>
										<td class="px-3 py-2 text-left border-b border-gray-200"><?= htmlspecialchars($oneRow["condition"]) ?></td>
										<td class="px-3 py-2 text-left border-b border-gray-200">
											<?php
												$statusWord = $oneRow["status"];
												$statusClass = "inline-block px-2.5 py-[0.15rem] rounded-full text-xs font-semibold";
												if ($statusWord === "Approved") {
													$statusClass .= " bg-green-100 text-green-700";
												} elseif ($statusWord === "Pending") {
													$statusClass .= " bg-amber-100 text-amber-800";
												} elseif ($statusWord === "Declined") {
													$statusClass .= " bg-red-100 text-red-700";
												}
											?>
											<span class="<?= $statusClass?>">
												<?= htmlspecialchars($statusWord) ?>
											</span>
										</td>
										<td class="px-3 py-2 text-left border-b border-gray-200"><?= htmlspecialchars($oneRow["date"]) ?></td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>

					<p class="mt-2 text-xs text-gray-500">DEMO DATA</p>
				</div>
			</section>

		</main>
	</div>

	<script src="js/mobile-menu.js"></script>
</body>
</html>