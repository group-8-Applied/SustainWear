<?php
	include "session.php";

	$pendingDonations = [
		["id" => 1, "donor_name" => "Prawn Teacon", "donor_email" => "PT123@live.com", "item" => "jacket", "size" => "M", "condition" => "Good", "date" => "2025-01-10", "notes" => "pretty much mint condition"],
		["id" => 2, "donor_name" => "Towers", "donor_email" => "Towers@example.com", "item" => "Jeans", "size" => "32", "condition" => "Acceptable", "date" => "2025-01-09", "notes" => "very nice and good"],
	];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear: Pending Donations</title>
	<link rel="stylesheet" href="styles/output.css" />
</head>

<body class="bg-gray-200 min-h-screen">
	<div class="flex flex-col lg:flex-row-reverse min-h-screen">
		<?php include "components/sidebar.php"; ?>

		<main class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8 pt-16 lg:pt-8">

			<section class="mb-6">
				<h2 class="text-2xl font-bold mb-4">Pending Donations</h2>
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p>You are signed in as <strong><?php echo $account_data["full_name"]; ?></strong> (<?php echo $account_data["user_role"]; ?>).</p>
					<p class="mt-2 text-sm text-gray-700">Review and approve or decline pending donation submissions from donors.</p>
				</div>
			</section>

			<section class="mb-6">
				<div class="flex flex-col sm:flex-row gap-4">
					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Pending Review</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1 text-amber-600">2</p>
					</div>

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Approved Today</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1 text-green-600">2</p>
					</div>

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Declined Today</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1 text-red-600">1</p>
					</div>
				</div>
			</section>
			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">Filter donations</p>

					<div class="flex flex-wrap gap-4">
						<div style="flex: 1; min-width: 10rem;">
							<label for="filter-donor" class="block text-sm mb-1">Search donor name / email</label>
							<input type="text" id="filter-donor" placeholder="Type to search..." class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
						</div>

						<div style="flex: 1; min-width: 10rem;">
							<label for="filter-condition" class="block text-sm mb-1">Condition</label>
							<select id="filter-condition" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
								<!-- Add drop down options here -->
							</select>
						</div>

						<div style="flex: 1; min-width: 10rem;">
							<label for="filter-item" class="block text-sm mb-1">Item type</label>
							<select id="filter-item" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
								<!-- Add drop down options here -->
							</select>
						</div>
					</div>

					<p class="mt-2 text-xs text-gray-500">DEMODATA</p>
				</div>
			</section>
			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">All pending donations</p>

					<div style="overflow-x: auto; margin-left: -1rem; margin-right: -1rem; max-height: 400px; overflow-y: auto;">
						<table class="w-full border-collapse text-sm">
							<thead style="background-color: #f3f4f6; position: sticky; top: 0;">
								<tr>
									<th class="px-3 py-2 text-left border-b border-gray-200">ID</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Donor</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Item</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Size</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Condition</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Date</th>
								</tr>
							</thead>

							<tbody>
								<?php
								// loop through pending donations
								foreach ($pendingDonations as $donation) {
								?>
									<tr>
										<td class="px-3 py-2 text-left border-b border-gray-200">#<?php echo $donation["id"]; ?></td>
										<td class="px-3 py-2 text-left border-b border-gray-200">
											<div class="font-semibold"><?php echo $donation["donor_name"]; ?></div>
											<div class="text-xs text-gray-500"><?php echo $donation["donor_email"]; ?></div>
										</td>
										<td class="px-3 py-2 text-left border-b border-gray-200"><?php echo $donation["item"]; ?></td>
										<td class="px-3 py-2 text-left border-b border-gray-200"><?php echo $donation["size"]; ?></td>
										<td class="px-3 py-2 text-left border-b border-gray-200"><?php echo $donation["condition"]; ?></td>
										<td class="px-3 py-2 text-left border-b border-gray-200"><?php echo $donation["date"]; ?></td>
									</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</div>

					<p class="mt-2 text-xs text-gray-500">DEMODATA</p>
				</div>
			</section>
			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">Donation details</p>
					<div class="mb-4">
						<label for="detail-search" class="block text-sm mb-1">Search by ID or donor name</label>
						<input type="text" placeholder="Type ID or donor name..." id="detail-search" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
					</div>
					<div class="space-y-4">
						<?php
						foreach ($pendingDonations as $donation) { ?>
							<div class="border border-gray-200 rounded p-4">
								<div class="flex flex-col sm:flex-row justify-between items-start gap-3">
									<div style="flex: 1;">
										<h4 class="font-bold text-base">
											<?php echo $donation["item"]; ?> (<?php echo $donation["size"]; ?>)
										</h4>
										<p class="text-sm text-gray-600 mt-1">
											<strong>Donation ID:</strong> #<?php echo $donation["id"]; ?><br>
											<strong>Donor:</strong> <?php echo $donation["donor_name"]; ?><br>
											<strong>Email:</strong> <?php echo $donation["donor_email"]; ?><br>
											<strong>Condition:</strong> <?php echo $donation["condition"]; ?><br>
											<strong>Submitted:</strong> <?php echo $donation["date"]; ?>
										</p>
										<?php
										if (!empty($donation["notes"])) {
										?>
											<p class="text-sm text-gray-700 mt-2">
												<strong>Notes:</strong> <?php echo $donation["notes"]; ?>
											</p>
										<?php
										}
										?>
									</div>
									<div class="flex gap-2 flex-shrink-0">
										<button title="Approve" class="w-8 h-8 rounded-full bg-green-500/20 text-green-600 font-bold text-base flex items-center justify-center hover:opacity-80 transition-opacity flex-shrink-0">✓</button>
										<button title="Decline" class="w-8 h-8 rounded-full bg-red-500/20 text-red-600 font-bold text-base flex items-center justify-center hover:opacity-80 transition-opacity flex-shrink-0">✕</button>
									</div>
								</div>
							</div>
						<?php }?>
					</div>
				</div>
			</section>
		</main>
	</div>
	<script src="js/mobile-menu.js"></script>
</body>
</html>