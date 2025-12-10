<?php
	$user = Auth::getUser();
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
			</section>

			<section class="mb-6">
				<div class="flex flex-col sm:flex-row gap-4">
					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Total Items</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1"><?= $totalItems; ?></p>
					</div>

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Categories</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1"><?= $uniqueCategories; ?></p>
					</div>

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Low Stock Items</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1 text-amber-600"><?= $lowStockCount; ?></p>
					</div>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">Stock by category</p>

					<?php if (!empty($categoryStats)): ?>
						<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
							<?php foreach ($categoryStats as $category => $count): ?>
								<div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
									<p class="text-sm text-gray-600"><?= htmlspecialchars($category); ?></p>
									<p class="text-2xl font-bold mt-1"><?= $count; ?></p>
								</div>
							<?php endforeach; ?>
						</div>
					<?php else: ?>
						<p class="text-gray-500 text-sm mt-2">No approved inventory items yet.</p>
					<?php endif; ?>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">Filter inventory</p>

					<form method="GET" action="/staff/inventory" class="flex flex-wrap gap-4">
						<div style="flex: 1; min-width: 10rem;">
							<label for="filter-category" class="block text-sm mb-1">Item Type</label>
							<select name="item_type" id="filter-category" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
								<option value="">Any</option>
								<option value="Coat" <?= $selectedItemType === "Coat" ? "selected" : ""; ?>>Coat</option>
								<option value="Jeans" <?= $selectedItemType === "Jeans" ? "selected" : ""; ?>>Jeans</option>
								<option value="T-Shirt" <?= $selectedItemType === "T-Shirt" ? "selected" : ""; ?>>T-Shirt</option>
								<option value="Shoes" <?= $selectedItemType === "Shoes" ? "selected" : ""; ?>>Shoes</option>
							</select>
						</div>

						<div style="flex: 1; min-width: 10rem;">
							<label for="filter-condition" class="block text-sm mb-1">Condition</label>
							<select name="condition" id="filter-condition" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
								<option value="">Any</option>
								<option value="Excellent" <?= $selectedCondition === "Excellent" ? "selected" : ""; ?>>Excellent</option>
								<option value="Good" <?= $selectedCondition === "Good" ? "selected" : ""; ?>>Good</option>
								<option value="Acceptable" <?= $selectedCondition === "Acceptable" ? "selected" : ""; ?>>Acceptable</option>
							</select>
						</div>

						<div style="flex: 1; min-width: 10rem;">
							<label for="filter-stock" class="block text-sm mb-1">Stock level</label>
							<select name="stock_level" id="filter-stock" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
								<option value="" <?= $selectedStockLevel === "all" ? "selected" : ""; ?>>Any</option>
								<option value="in_stock" <?= $selectedStockLevel === "in_stock" ? "selected" : ""; ?>>In Stock (4+)</option>
								<option value="low" <?= $selectedStockLevel === "low" ? "selected" : ""; ?>>Low Stock (1-3)</option>
							</select>
						</div>

						<div style="flex: 1; min-width: 10rem; display: flex; align-items: flex-end; gap: 0.5rem;">
							<button type="submit" class="px-4 py-[0.4rem] bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-[0.9rem]">Apply</button>
							<a href="/staff/inventory" class="px-4 py-[0.4rem] bg-gray-200 text-gray-700 rounded hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[0.9rem] inline-block text-center">Clear</a>
						</div>
					</form>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">All inventory items</p>

					<?php if (!empty($inventoryItems)): ?>
						<div style="overflow-x: auto; margin-left: -1rem; margin-right: -1rem; max-height: 500px; overflow-y: auto;">
							<table class="w-full border-collapse text-sm">
								<thead style="background-color: #f3f4f6; position: sticky; top: 0;">
									<tr>
										<th class="px-3 py-2 text-left border-b border-gray-200">Item Type</th>
										<th class="px-3 py-2 text-left border-b border-gray-200">Size</th>
										<th class="px-3 py-2 text-left border-b border-gray-200">Condition</th>
										<th class="px-3 py-2 text-left border-b border-gray-200">Quantity</th>
										<th class="px-3 py-2 text-left border-b border-gray-200">Date Added</th>
										<th class="px-3 py-2 text-left border-b border-gray-200">Status</th>
									</tr>
								</thead>

								<tbody>
									<?php foreach ($inventoryItems as $item):
										if ($item["quantity"] <= 3) {
											$badgeClass = "bg-red-100 text-red-700";
											$badgeText = "Low stock";
										} else {
											$badgeClass = "bg-green-100 text-green-700";
											$badgeText = "In stock";
										}
									?>
										<tr>
											<td class="px-3 py-2 text-left border-b border-gray-200"><?= htmlspecialchars($item["item_type"]); ?></td>
											<td class="px-3 py-2 text-left border-b border-gray-200"><?= htmlspecialchars($item["size"]); ?></td>
											<td class="px-3 py-2 text-left border-b border-gray-200"><?= htmlspecialchars($item["condition"]); ?></td>
											<td class="px-3 py-2 text-left border-b border-gray-200 font-semibold"><?= $item["quantity"]; ?></td>
											<td class="px-3 py-2 text-left border-b border-gray-200"><?= $item["date_added"] ? date("Y-m-d", strtotime($item["date_added"])) : "N/A"; ?></td>
											<td class="px-3 py-2 text-left border-b border-gray-200">
												<span class="inline-block px-2.5 py-[0.15rem] rounded-full text-xs font-semibold <?= $badgeClass; ?>"><?= $badgeText; ?></span>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					<?php else: ?>
						<p class="text-gray-500 text-sm mt-2">Inventory is currently empty.</p>
					<?php endif; ?>
				</div>
			</section>
		</main>
	</div>
	<script src="/js/mobile-menu.js"></script>
</body>
</html>
