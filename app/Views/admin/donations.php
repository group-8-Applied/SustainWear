<?php
	$user = Auth::getUser();
	$donationModel = new Donation();
	$stats = $donationModel->getStats();
	$filters = $filters ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear • Donations Management</title>
	<link rel="stylesheet" href="/styles/output.css" />
</head>

<body class="bg-gray-200 min-h-screen">
	<div class="flex flex-col lg:flex-row-reverse min-h-screen">
		<?php include __DIR__ . "/../components/sidebar.php"; ?>

		<main class="flex-1 p-4 sm:p-6 lg:p-8 pt-16 lg:pt-8">

			<section class="mb-6">
				<h2 class="text-2xl font-bold mb-4">Donations Management</h2>
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p>You are signed in as <strong><?= $user["full_name"]; ?></strong> (<?= $user["user_role"]; ?>).</p>
				</div>
			</section>

			<section class="mb-6">
				<div class="flex flex-col sm:flex-row gap-4">

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Total Donations</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1"><?= $stats["total"] ?></p>
					</div>

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Pending Review</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1 text-amber-600"><?= $stats["pending"] ?></p>
					</div>

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Approved</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1 text-green-600"><?= $stats["total_approved"] ?></p>
					</div>

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Declined</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1 text-red-600"><?= $stats["total"] - $stats["total_approved"] - $stats["pending"] ?></p>
					</div>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">Filter Donations</p>

					<form method="GET" action="/admin/donations">
						<div class="flex flex-wrap gap-4">
							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="donor_name">Search donor name</label>
								<input id="donor_name" name="donor_name" value="<?= htmlspecialchars($filters["donor_name"] ?? "") ?>" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="text" placeholder="John Smith" />
							</div>

							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="status">Status</label>
								<select id="status" name="status" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
									<option value="">Any</option>
									<option value="pending" <?= $filters["status"] === "pending" ? "selected" : "" ?>>Pending</option>
									<option value="approved" <?= $filters["status"] === "approved" ? "selected" : "" ?>>Approved</option>
									<option value="declined" <?= $filters["status"] === "declined" ? "selected" : "" ?>>Declined</option>
								</select>
							</div>

							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="condition">Condition</label>
								<select id="condition" name="condition" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
									<option value="">Any</option>
									<option value="Excellent" <?= $filters["condition"] === "Excellent" ? "selected" : "" ?>>Excellent</option>
									<option value="Good" <?= $filters["condition"] === "Good" ? "selected" : "" ?>>Good</option>
									<option value="Acceptable" <?= $filters["condition"] === "Acceptable" ? "selected" : "" ?>>Acceptable</option>
								</select>
							</div>

							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="item_type">Item type</label>
								<select id="item_type" name="item_type" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
									<option value="">Any</option>
									<option value="Coat" <?= $filters["item_type"] === "Coat" ? "selected" : "" ?>>Coat / Jacket</option>
									<option value="Jeans" <?= $filters["item_type"] === "Jeans" ? "selected" : "" ?>>Jeans</option>
									<option value="T-Shirt" <?= $filters["item_type"] === "T-Shirt" ? "selected" : "" ?>>T-Shirt</option>
									<option value="Shoes" <?= $filters["item_type"] === "Shoes" ? "selected" : "" ?>>Shoes</option>
									<option value="Other" <?= $filters["item_type"] === "Other" ? "selected" : "" ?>>Other</option>
								</select>
							</div>
						</div>

						<div class="mt-4 flex gap-2">
							<button type="submit" class="border border-gray-300 rounded bg-blue-500 text-white text-xs cursor-pointer px-4 py-2 hover:bg-blue-600 transition-colors">Apply Filters</button>
							<a href="/admin/donations" class="border border-gray-300 rounded bg-gray-200 text-gray-700 text-xs cursor-pointer px-4 py-2 hover:bg-gray-300 transition-colors inline-block">Clear Filters</a>
						</div>
					</form>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">All Donations</p>

					<div class="overflow-x-auto -mx-4 sm:mx-0">
						<table class="w-full border-collapse text-sm">
							<thead class="bg-gray-100">
								<tr>
									<th class="px-3 py-2 text-left border-b border-gray-200">ID</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Donor</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Item</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Size</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Condition</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Status</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Date</th>
								</tr>
							</thead>

							<tbody>
								<?php if (empty($donations)): ?>
									<tr>
										<td colspan="8" class="px-3 py-4 text-center text-gray-500">No donations found</td>
									</tr>
								<?php else: ?>
									<?php foreach ($donations as $donation): ?>
										<tr>
											<td class="px-3 py-2 text-left border-b border-gray-200">#<?= htmlspecialchars($donation["donation_id"]) ?></td>
											<td class="px-3 py-2 text-left border-b border-gray-200">
												<div class="font-semibold"><?= htmlspecialchars($donation["donor_name"]) ?></div>
											</td>
											<td class="px-3 py-2 text-left border-b border-gray-200"><?= htmlspecialchars($donation["item_type"]) ?></td>
											<td class="px-3 py-2 text-left border-b border-gray-200"><?= htmlspecialchars($donation["size"]) ?></td>
											<td class="px-3 py-2 text-left border-b border-gray-200"><?= htmlspecialchars($donation["condition"]) ?></td>
											<td class="px-3 py-2 text-left border-b border-gray-200">
												<?php
													$statusWord = ucfirst($donation["status"]);
													$statusClass = "inline-block px-2.5 py-[0.15rem] rounded-full text-xs font-semibold";
													if ($donation["status"] === "approved") {
														$statusClass .= " bg-green-100 text-green-700";
													} elseif ($donation["status"] === "pending") {
														$statusClass .= " bg-amber-100 text-amber-800";
													} elseif ($donation["status"] === "declined") {
														$statusClass .= " bg-red-100 text-red-700";
													}
												?>
												<span class="<?= $statusClass?>">
													<?= htmlspecialchars($statusWord) ?>
												</span>
											</td>
											<td class="px-3 py-2 text-left border-b border-gray-200"><?= htmlspecialchars(date("Y-m-d", strtotime($donation["submitted_date"]))) ?></td>
										</tr>
									<?php endforeach ?>
								<?php endif ?>
							</tbody>
						</table>
					</div>

					<!-- Page controls (if needed) -->
					<?php if ($pageCount > 1): ?>
						<div class="mt-4 flex flex-col sm:flex-row justify-between items-center gap-3">
							<div class="text-sm text-gray-600">
								<?= "Showing page " . $currentPage . " of " . $pageCount . " (" . $donationCount . " total donations)"; ?>
							</div>
							<div class="flex gap-2">
								<?php
									// build query string from filters
									$queryParams = [];
									foreach ($filters as $key => $value) {
										if (!empty($value)) $queryParams[$key] = $value;
									}
									$queryString = http_build_query($queryParams); // url encode
									$baseUrl = "/admin/donations?" . ($queryString ? $queryString . "&" : "");
								?>

								<?php if ($currentPage > 1): ?>
									<a href="<?= $baseUrl ?>page=1" class="px-3 py-1 text-sm border border-gray-300 rounded bg-white hover:bg-gray-100 transition-colors">First</a>
									<a href="<?= $baseUrl ?>page=<?= $currentPage - 1 ?>" class="px-3 py-1 text-sm border border-gray-300 rounded bg-white hover:bg-gray-100 transition-colors">Previous</a>
								<?php endif; ?>

								<?php
									$previousPage = max(1, $currentPage - 1);
									$nextPage = min($pageCount, $currentPage + 1);

									for ($i = $previousPage; $i <= $nextPage; $i++):
								?>
									<?php if ($i == $currentPage): ?>
										<span class="px-3 py-1 text-sm border border-blue-500 rounded bg-blue-500 text-white font-semibold"><?= $i ?></span>
									<?php else: ?>
										<a href="<?= $baseUrl ?>page=<?= $i ?>" class="px-3 py-1 text-sm border border-gray-300 rounded bg-white hover:bg-gray-100 transition-colors"><?= $i ?></a>
									<?php endif; ?>
								<?php endfor; ?>

								<?php if ($currentPage < $pageCount): ?>
									<a href="<?= $baseUrl ?>page=<?= $currentPage + 1 ?>" class="px-3 py-1 text-sm border border-gray-300 rounded bg-white hover:bg-gray-100 transition-colors">Next</a>
									<a href="<?= $baseUrl ?>page=<?= $pageCount ?>" class="px-3 py-1 text-sm border border-gray-300 rounded bg-white hover:bg-gray-100 transition-colors">Last</a>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">Quick Actions</p>

					<div class="flex flex-col gap-4">
						<div>
							<h4 class="font-bold mb-2">Update Donation Status</h4>
							<form method="POST" action="/admin/update-donation">
								<div class="flex flex-wrap gap-4 items-end">
									<div class="flex-1 min-w-full sm:min-w-[10rem]">
										<label class="block text-sm mb-1" for="donation_id">Donation ID</label>
										<input id="donation_id" name="donation_id" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="number" placeholder="e.g. 10" required />
									</div>
									<div class="flex-1 min-w-full sm:min-w-[10rem]">
										<label class="block text-sm mb-1" for="status">New status</label>
										<select id="status" name="status" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
											<option value="">Select...</option>
											<option value="approved">Approved</option>
											<option value="declined">Declined</option>
											<option value="pending">Pending</option>
										</select>
									</div>
									<div class="flex-none">
										<button type="submit" class="border border-gray-300 rounded bg-blue-500 text-white text-xs cursor-pointer px-4 py-2 hover:bg-blue-600 transition-colors">Update Status</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>

		</main>
	</div>

	<script src="/js/mobile-menu.js"></script>
</body>
</html>
