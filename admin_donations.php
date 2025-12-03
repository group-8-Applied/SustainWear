<?php
	include "session.php";

	$allDonationsExampleData = [
		["donor_name" => "Mike Davis", "donors_email" => "mike@example.com", "item" => "T-Shirt", "condition" => "Good", "status" => "Pending", "size" => "XL","date" => "02-08-2006", "notes" => "note", "id" => 1],
		["donor_name" => "Emma Wilson", "donors_email" => "emma@example.com", "item" => "Shoes", "condition" => "Acceptable", "status" => "Declined", "size" => "L","date" => "20-06-2006", "notes" => "note about", "id" => 2],
		["donor_name" => "James Brown", "donors_email" => "james@example.com", "item" => "Jacket", "condition" => "Mint", "status" => "Approved", "size" => "M", "date" => "14-12-1990", "notes" => "note about jacket", "id" => 3],
	];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear • Donations Management</title>
	<link rel="stylesheet" href="styles/output.css" />
</head>

<body class="bg-gray-200 min-h-screen">
	<div class="flex flex-col lg:flex-row-reverse min-h-screen">
		<?php include "components/sidebar.php"; ?>

		<main class="flex-1 p-4 sm:p-6 lg:p-8 pt-16 lg:pt-8">

			<section class="mb-6">
				<h2 class="text-2xl font-bold mb-4">Donations Management</h2>
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p>You are signed in as <strong><?= $account_data["full_name"]; ?></strong> (<?= $account_data["user_role"]; ?>).</p>
				</div>
			</section>

			<section class="mb-6">
				<div class="flex flex-col sm:flex-row gap-4">

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Total Donations</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1">47</p>
					</div>

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Pending Review</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1 text-amber-600">12</p>
					</div>

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Approved</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1 text-green-600">28</p>
					</div>

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Declined</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1 text-red-600">7</p>
					</div>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">Filter donations</p>

					<div class="flex flex-wrap gap-4">
						<div class="flex-1 min-w-full sm:min-w-[10rem]">
							<label class="block text-sm mb-1" for="filter-donor">Search donor name / email</label>
							<input id="filter-donor" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="text" placeholder="Type to search..." />
						</div>

						<div class="flex-1 min-w-full sm:min-w-[10rem]">
							<label class="block text-sm mb-1" for="filter-status">Status</label>
							<select id="filter-status" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
								<option>Any</option>
								<option>Pending</option>
								<option>Approved</option>
								<option>Declined</option>
							</select>
						</div>

						<div class="flex-1 min-w-full sm:min-w-[10rem]">
							<label class="block text-sm mb-1" for="filter-condition">Condition</label>
							<select id="filter-condition" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
								<option>Any</option>
								<option>Excellent</option>
								<option>Good</option>
								<option>Acceptable</option>
							</select>
						</div>

						<div class="flex-1 min-w-full sm:min-w-[10rem]">
							<label class="block text-sm mb-1" for="filter-item">Item type</label>
							<select id="filter-item" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
								<option>Any</option>
								<option>Coat / Jacket</option>
								<option>Jeans</option>
								<option>T-Shirt</option>
								<option>Shoes</option>
								<option>Other</option>
							</select>
						</div>
					</div>

					<p class="mt-2 text-xs text-gray-500">DEMO</p>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">All donations</p>

					<div class="overflow-x-auto -mx-4 sm:mx-0">
						<table class="w-full border-collapse text-sm">
							<thead class="bg-gray-100">
								<tr>
									<th class="px-3 py-2 text-left border-b border-gray-200">id</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Donor</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Item</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Size</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Condition</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Status</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Date</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Actions</th>
								</tr>
							</thead>

							<tbody>
								<?php foreach ($allDonationsExampleData as $donation): ?>
									<tr>
										<td class="px-3 py-2 text-left border-b border-gray-200">#<?= $donation["id"] ?></td>
										<td class="px-3 py-2 text-left border-b border-gray-200">
											<div class="font-semibold"><?= $donation["donor_name"] ?></div>
											<div class="text-xs text-gray-500"><?= $donation["donors_email"] ?></div>
										</td>
										<td class="px-3 py-2 text-left border-b border-gray-200"><?= $donation["item"] ?></td>
										<td class="px-3 py-2 text-left border-b border-gray-200"><?= $donation["size"] ?></td>
										<td class="px-3 py-2 text-left border-b border-gray-200"><?= $donation["condition"] ?></td>
										<td class="px-3 py-2 text-left border-b border-gray-200">
											<?php
												$statusWord = $donation["status"];
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
												<?= $statusWord ?>
											</span>
										</td>
										<td class="px-3 py-2 text-left border-b border-gray-200"><?= $donation["date"] ?></td>
										<td class="px-3 py-2 text-left border-b border-gray-200">
											<button class="border border-gray-300 rounded bg-blue-500 text-white text-xs cursor-pointer mr-1 px-2 py-1 hover:bg-blue-600 transition-colors">View</button>
											<?php if ($donation["status"] === "Pending"): ?>
												<button class="border border-gray-300 rounded bg-green-500 text-white text-xs cursor-pointer mr-1 px-2 py-1 hover:bg-green-600 transition-colors">Approve</button>
												<button class="border border-gray-300 rounded bg-red-500 text-white text-xs cursor-pointer px-2 py-1 hover:bg-red-600 transition-colors">Decline</button>
											<?php endif ?>
										</td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>

					<p class="mt-2 text-xs text-gray-500">DEMO DATA</p>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">Quick actions</p>

					<div class="flex flex-col gap-4">
						<div>
							<h4 class="font-bold mb-2">Approve or decline by id</h4>
							<form method="POST">
								<div class="flex flex-wrap gap-4 items-end">
									<div class="flex-1 min-w-full sm:min-w-[10rem]">
										<label class="block text-sm mb-1" for="action-donation-id">Donation id</label>
										<input id="action-donation-id" name="action_donation_id" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="number" placeholder="e.g., 1" />
									</div>
									<div class="flex-1 min-w-full sm:min-w-[10rem]">
										<label class="block text-sm mb-1" for="action-status">New status</label>
										<select id="action-status" name="action_status" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
											<option value="">Select...</option>
											<option value="Approved">Approved</option>
											<option value="Declined">Declined</option>
											<option value="Pending">Pending</option>
										</select>
									</div>
									<div class="flex-none">
										<button type="submit" class="border border-gray-300 rounded bg-blue-500 text-white text-xs cursor-pointer px-2 py-1 hover:bg-blue-600 transition-colors">Update status</button>
									</div>
								</div>
							</form>
						</div>

						<div class="border-t border-gray-200 pt-4">
							<h4 class="font-bold mb-2">approve all pending donations</h4>
							<button class="border border-gray-300 rounded bg-green-600 text-white px-4 py-2 hover:bg-green-700 transition-colors">Approve All Pending</button>
						</div>
					</div>
				</div>
			</section>

		</main>
	</div>

	<script src="js/mobile-menu.js"></script>
</body>
</html>