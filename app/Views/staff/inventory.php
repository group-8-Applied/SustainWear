<?php
	$user = Auth::getUser();

	$inventoryItems = [
		["id" => 1, "category" => "Category A", "size" => "M", "condition" => "Good", "quantity" => 8, "date_added" => "2025-01-05"]
	];

	$totalItems = 1;

	$lowStockCount = 0;
	foreach ($inventoryItems as $item) {
		if ($item["quantity"] <= 3) {
			$lowStockCount++;
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear • Inventory</title>
	<link rel="stylesheet" href="/styles/output.css" />
</head>

<body class="bg-gray-200 min-h-screen">
	<div class="flex flex-col lg:flex-row-reverse min-h-screen">
		<?php include __DIR__ . "/../components/sidebar.php"; ?>

		<main class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8 pt-16 lg:pt-8">

			<section class="mb-6">
				<h2 class="text-2xl font-bold mb-4">Inventory</h2>
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p>You are signed in as <strong><?php echo $user["full_name"]; ?></strong> (<?php echo $user["user_role"]; ?>).</p>
					<p class="mt-2 text-sm text-gray-700">View and manage approved donation items currently in stock.</p>
				</div>
			</section>

			<section class="mb-6">
				<div class="flex flex-col sm:flex-row gap-4">
					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Total Items</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1"><?php echo $totalItems; ?></p>
					</div>

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Categories</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1">1</p>
					</div>

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Low Stock Items</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1 text-amber-600"><?php echo $lowStockCount; ?></p>
					</div>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">Stock by category</p>
					<p class="mt-3 text-xs text-gray-500">DEMO DATA</p>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">Filter inventory</p>

					<div class="flex flex-wrap gap-4">
						<div style="flex: 1; min-width: 10rem;">
							<label for="filter-category" class="block text-sm mb-1">Category</label>
							<select id="filter-category" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
								<option>Any</option>
								<!-- Add dropdown options here -->
							</select>
						</div>

						<div style="flex: 1; min-width: 10rem;">
							<label for="filter-condition" class="block text-sm mb-1">Condition</label>
							<select id="filter-condition" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
								<option>Any</option>
								<!-- Add dropdown options here -->
							</select>
						</div>

						<div style="flex: 1; min-width: 10rem;">
							<label for="filter-stock" class="block text-sm mb-1">Stock level</label>
							<select id="filter-stock" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
								<option>Any</option>
								<!-- Add dropdown options here -->
							</select>
						</div>
					</div>

					<p class="mt-2 text-xs text-gray-500">DEMO DATA</p>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">All inventory items</p>

					<div style="overflow-x: auto; margin-left: -1rem; margin-right: -1rem; max-height: 500px; overflow-y: auto;">
						<table class="w-full border-collapse text-sm">
							<thead style="background-color: #f3f4f6; position: sticky; top: 0;">
								<tr>
									<th class="px-3 py-2 text-left border-b border-gray-200">ID</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Category</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Size</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Condition</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Quantity</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Date Added</th>
									<th class="px-3 py-2 text-left border-b border-gray-200">Status</th>
								</tr>
							</thead>

							<tbody>
								<?php foreach ($inventoryItems as $item):
									if ($item["quantity"] === 0) {
										$badgeClass = "bg-gray-200 text-gray-900";
										$badgeText = "Out";
									} elseif ($item["quantity"] <= 3) {
										$badgeClass = "bg-red-100 text-red-700";
										$badgeText = "Low";
									} else {
										$badgeClass = "bg-green-100 text-green-700";
										$badgeText = "In stock";
									}
								?>
									<tr>
										<td class="px-3 py-2 text-left border-b border-gray-200">#<?php echo $item["id"]; ?></td>
										<td class="px-3 py-2 text-left border-b border-gray-200"><?php echo $item["category"]; ?></td>
										<td class="px-3 py-2 text-left border-b border-gray-200"><?php echo $item["size"]; ?></td>
										<td class="px-3 py-2 text-left border-b border-gray-200"><?php echo $item["condition"]; ?></td>
										<td class="px-3 py-2 text-left border-b border-gray-200 font-semibold"><?php echo $item["quantity"]; ?></td>
										<td class="px-3 py-2 text-left border-b border-gray-200"><?php echo $item["date_added"]; ?></td>
										<td class="px-3 py-2 text-left border-b border-gray-200">
											<span class="inline-block px-2.5 py-[0.15rem] rounded-full text-xs font-semibold <?php echo $badgeClass; ?>"><?php echo $badgeText; ?></span>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<p class="mt-3 text-xs text-gray-500">DEMO DATA</p>
				</div>
			</section>
		</main>
	</div>
	<script src="/js/mobile-menu.js"></script>
</body>
</html>
