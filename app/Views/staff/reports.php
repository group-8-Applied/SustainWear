<?php
	$user = Auth::getUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
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
							<p class="text-sm text-gray-600">dec 2025</p>
							<p class="font-bold text-lg mt-1">Donations Received</p>
							<p class="text-2xl font-extrabold mt-1">47</p>
						</div>
						<div class="flex-1 min-w-full sm:min-w-[200px] border border-gray-200 rounded p-4">
							<p class="text-sm text-gray-600">dec 2025</p>
							<p class="font-bold text-lg mt-1">Items Approved</p>
							<p class="text-2xl font-extrabold mt-1">42</p>
						</div>
						<div class="flex-1 min-w-full sm:min-w-[200px] border border-gray-200 rounded p-4">
							<p class="text-sm text-gray-600">dec 2025</p>
							<p class="font-bold text-lg mt-1">Items Declined</p>
							<p class="text-2xl font-extrabold mt-1">5</p>
						</div>
					</div>
					<p class="mt-3 text-xs text-gray-500">DEMO DATA</p>
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
									<tr>
										<td class="px-3 py-2 text-left border-b border-gray-200">dec 2025</td>
										<td class="px-3 py-2 text-left border-b border-gray-200">47</td>
										<td class="px-3 py-2 text-left border-b border-gray-200">42</td>
										<td class="px-3 py-2 text-left border-b border-gray-200">5</td>
									</tr>
								</tbody>
							</table>
						</div>
						<p class="mt-3 text-xs text-gray-500">DEMO DATA</p>
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
									<tr>
										<td class="px-3 py-2 text-left border-b border-gray-200">Category A</td>
										<td class="px-3 py-2 text-left border-b border-gray-200">14</td>
									</tr>
								</tbody>
							</table>
						</div>
						<p class="mt-3 text-xs text-gray-500">DEMO DATA</p>
					</div>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">All-time statistics</p>
					<div class="flex flex-col sm:flex-row gap-4">
						<div class="flex-1 min-w-full sm:min-w-[200px] border border-gray-200 rounded p-4">
							<p class="font-bold text-lg">Total Donations</p>
							<p class="text-2xl font-extrabold mt-1">287</p>
						</div>
						<div class="flex-1 min-w-full sm:min-w-[200px] border border-gray-200 rounded p-4">
							<p class="font-bold text-lg">Approved (All Time)</p>
							<p class="text-2xl font-extrabold mt-1">261</p>
						</div>
						<div class="flex-1 min-w-full sm:min-w-[200px] border border-gray-200 rounded p-4">
							<p class="font-bold text-lg">Approval Rate</p>
							<p class="text-2xl font-extrabold mt-1">91%</p>
						</div>
					</div>
					<p class="mt-3 text-xs text-gray-500">DEMO DATA</p>
				</div>
			</section>
		</main>
	</div>
	<script src="/js/mobile-menu.js"></script>
</body>
</html>
