<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<meta name="description" content="View a quick summary of submitted donations in the system" />
	<title>SustainWear • Reports</title>
	<link rel="stylesheet" href="/styles/output.css" />
</head>

<body class="bg-gray-200 min-h-screen">
	<div class="flex flex-col lg:flex-row-reverse min-h-screen">
		<?php include __DIR__ . "/../components/sidebar.php"; ?>
		<main class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8 pt-16 lg:pt-8">
			<section class="mb-6">
				<h2 class="text-2xl font-bold mb-4">Reports</h2>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">Monthly summary</p>
					<div class="flex flex-col sm:flex-row gap-4">
						<div class="flex-1 min-w-full sm:min-w-[200px] border border-gray-200 rounded p-4">
							<p class="text-sm text-gray-600"><?= $currentMonthName; ?></p>
							<p class="font-bold text-lg mt-1">Donations Received</p>
							<p class="text-2xl font-extrabold mt-1"><?= $currentMonthReceived; ?></p>
						</div>
						<div class="flex-1 min-w-full sm:min-w-[200px] border border-gray-200 rounded p-4">
							<p class="text-sm text-gray-600"><?= $currentMonthName; ?></p>
							<p class="font-bold text-lg mt-1">Items Approved</p>
							<p class="text-2xl font-extrabold mt-1"><?= $currentMonthApproved; ?></p>
						</div>
						<div class="flex-1 min-w-full sm:min-w-[200px] border border-gray-200 rounded p-4">
							<p class="text-sm text-gray-600"><?= $currentMonthName; ?></p>
							<p class="font-bold text-lg mt-1">Items Declined</p>
							<p class="text-2xl font-extrabold mt-1"><?= $currentMonthDeclined; ?></p>
						</div>
					</div>
				</div>
			</section>
			<section class="mb-6">
				<div class="flex flex-col lg:flex-row gap-6">
					<div class="flex-1 bg-white rounded-xl shadow-md p-4 sm:p-5">
						<p class="font-bold text-lg mb-3">Donations by month</p>
						<div class="overflow-x-auto">
							<table class="w-full border-collapse text-sm">
								<thead class="bg-gray-100">
									<tr>
										<th class="px-3 py-2 text-left border-b border-gray-200">Month</th>
										<th class="px-3 py-2 text-left border-b border-gray-200">Received</th>
										<th class="px-3 py-2 text-left border-b border-gray-200">Approved</th>
										<th class="px-3 py-2 text-left border-b border-gray-200">Declined</th>
									</tr>
								</thead>
								<tbody>
									<?php if (empty($monthlyStats)): ?>
										<tr>
											<td colspan="4" class="px-3 py-4 text-center text-gray-500">No donation data available</td>
										</tr>
									<?php else: ?>
										<?php foreach ($monthlyStats as $month => $stats): ?>
											<tr>
												<td class="px-3 py-2 text-left border-b border-gray-200"><?= $stats["label"]; ?></td>
												<td class="px-3 py-2 text-left border-b border-gray-200"><?= $stats["received"]; ?></td>
												<td class="px-3 py-2 text-left border-b border-gray-200"><?= $stats["approved"]; ?></td>
												<td class="px-3 py-2 text-left border-b border-gray-200"><?= $stats["declined"]; ?></td>
											</tr>
										<?php endforeach; ?>
									<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="flex-1 bg-white rounded-xl shadow-md p-4 sm:p-5">
						<p class="font-bold text-lg mb-3">Top categories this month</p>
						<div class="overflow-x-auto">
							<table class="w-full border-collapse text-sm">
								<thead class="bg-gray-100">
									<tr>
										<th class="px-3 py-2 text-left border-b border-gray-200">Category</th>
										<th class="px-3 py-2 text-left border-b border-gray-200">Items</th>
									</tr>
								</thead>
								<tbody>
									<?php if (empty($categoryStats)): ?>
										<tr>
											<td colspan="2" class="px-3 py-4 text-center text-gray-500">No approved items this month</td>
										</tr>
									<?php else: ?>
										<?php foreach ($categoryStats as $category => $count): ?>
											<tr>
												<td class="px-3 py-2 text-left border-b border-gray-200"><?= htmlspecialchars($category); ?></td>
												<td class="px-3 py-2 text-left border-b border-gray-200"><?= $count; ?></td>
											</tr>
										<?php endforeach; ?>
									<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">All-time statistics</p>
					<div class="flex flex-col sm:flex-row gap-4">
						<div class="flex-1 min-w-full sm:min-w-[200px] border border-gray-200 rounded p-4">
							<p class="font-bold text-lg">Total Donations</p>
							<p class="text-2xl font-extrabold mt-1"><?= $totalDonations; ?></p>
						</div>
						<div class="flex-1 min-w-full sm:min-w-[200px] border border-gray-200 rounded p-4">
							<p class="font-bold text-lg">Approved (All Time)</p>
							<p class="text-2xl font-extrabold mt-1"><?= $totalApproved; ?></p>
						</div>
						<div class="flex-1 min-w-full sm:min-w-[200px] border border-gray-200 rounded p-4">
							<p class="font-bold text-lg">Approval Rate</p>
							<p class="text-2xl font-extrabold mt-1"><?= $approvalRate; ?>%</p>
						</div>
					</div>
				</div>
			</section>
		</main>
	</div>
	<script src="/js/mobile-menu.js"></script>
</body>
</html>
