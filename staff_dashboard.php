<?php
	include "session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear • Staff Dashboard</title>
	<link rel="stylesheet" href="styles/output.css" />
</head>

<body class="bg-gray-200 min-h-screen">
	<div class="flex flex-col lg:flex-row-reverse min-h-screen">
		<?php include "components/sidebar.php"; ?>

		<main class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8 pt-16 lg:pt-8">
			<section class="mb-6">
				<h2 class="text-2xl font-bold mb-4">Staff Dashboard</h2>
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5 flex flex-col gap-3 items-start">
					<div>
						<h3 class="font-bold text-lg">Full Name</h3>
						<p><?= $account_data["full_name"]; ?></p>
					</div>
					<div class="mt-4">
						<h3 class="font-bold text-lg">Email</h3>
						<p><?= $account_data["email"]; ?></p>
					</div>
					<div class="mt-4">
						<h3 class="font-bold text-lg">Role</h3>
						<p><?= $account_data["user_role"]; ?></p>
					</div>
				</div>
			</section>

			<section class="mb-6">
				<div class="flex flex-col sm:flex-row gap-4">
					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Pending Donations</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1">4</p>
					</div>

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Approved Today</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1">2</p>
					</div>

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Items In Stock</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1">37</p>
					</div>
				</div>
			</section>

			<section class="mb-6 min-w-0">
				<div class="flex flex-col lg:flex-row gap-6 items-start min-w-0">
					<div class="flex-1 min-w-0">
						<h3 class="font-bold text-lg mb-3">Pending donations</h3>

						<div class="bg-white rounded-xl shadow-md overflow-hidden">
							<div class="overflow-x-auto">
								<table class="w-full border-collapse text-sm">
									<thead class="bg-gray-100">
										<tr>
											<th class="px-3 py-2 text-left border-b border-gray-200">Donor</th>
											<th class="px-3 py-2 text-left border-b border-gray-200">Item</th>
											<th class="px-3 py-2 text-left border-b border-gray-200">Condition</th>
											<th class="px-3 py-2 text-left border-b border-gray-200">Actions</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="px-3 py-2 text-left border-b border-gray-200">Taylor Green</td>
											<td class="px-3 py-2 text-left border-b border-gray-200">Winter Coat (M)</td>
											<td class="px-3 py-2 text-left border-b border-gray-200">Good</td>
											<td class="px-3 py-2 text-left border-b border-gray-200">
												<div class="flex gap-2 items-center">
													<button class="w-8 h-8 rounded-full bg-green-500/20 text-green-600 font-bold text-base flex items-center justify-center hover:opacity-80 transition-opacity flex-shrink-0" title="Approve">✓</button>
													<button class="w-8 h-8 rounded-full bg-red-500/20 text-red-600 font-bold text-base flex items-center justify-center hover:opacity-80 transition-opacity flex-shrink-0" title="Decline">✕</button>
												</div>
											</td>
										</tr>
										<tr>
											<td class="px-3 py-2 text-left border-b border-gray-200">Sam Lee</td>
											<td class="px-3 py-2 text-left border-b border-gray-200">Jeans (32)</td>
											<td class="px-3 py-2 text-left border-b border-gray-200">Acceptable</td>
											<td class="px-3 py-2 text-left border-b border-gray-200">
												<div class="flex gap-2 items-center">
													<button class="w-8 h-8 rounded-full bg-green-500/20 text-green-600 font-bold text-base flex items-center justify-center hover:opacity-80 transition-opacity flex-shrink-0" title="Approve">✓</button>
													<button class="w-8 h-8 rounded-full bg-red-500/20 text-red-600 font-bold text-base flex items-center justify-center hover:opacity-80 transition-opacity flex-shrink-0" title="Decline">✕</button>
												</div>
											</td>
										</tr>
										<tr>
											<td class="px-3 py-2 text-left border-b border-gray-200">Jordan White</td>
											<td class="px-3 py-2 text-left border-b border-gray-200">T-Shirt (L)</td>
											<td class="px-3 py-2 text-left border-b border-gray-200">Excellent</td>
											<td class="px-3 py-2 text-left border-b border-gray-200">
												<div class="flex gap-2 items-center">
													<button class="w-8 h-8 rounded-full bg-green-500/20 text-green-600 font-bold text-base flex items-center justify-center hover:opacity-80 transition-opacity flex-shrink-0" title="Approve">✓</button>
													<button class="w-8 h-8 rounded-full bg-red-500/20 text-red-600 font-bold text-base flex items-center justify-center hover:opacity-80 transition-opacity flex-shrink-0" title="Decline">✕</button>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="p-4 sm:p-5">
								<p class="text-xs text-gray-500">Actual functionality for buttons is not yet implemented</p>
							</div>
						</div>
					</div>

					<div class="flex-1 min-w-0">
						<h3 class="font-bold text-lg mb-3">Inventory snapshot</h3>
						<div class="bg-white rounded-xl shadow-md overflow-hidden">
							<div class="overflow-x-auto">
								<table class="w-full border-collapse text-sm">
									<thead class="bg-gray-100">
										<tr>
											<th class="px-3 py-2 text-left border-b border-gray-200">Category</th>
											<th class="px-3 py-2 text-left border-b border-gray-200">Size</th>
											<th class="px-3 py-2 text-left border-b border-gray-200">Quantity</th>
											<th class="px-3 py-2 text-left border-b border-gray-200">Status</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="px-3 py-2 text-left border-b border-gray-200">Coats</td>
											<td class="px-3 py-2 text-left border-b border-gray-200">M-L</td>
											<td class="px-3 py-2 text-left border-b border-gray-200">12</td>
											<td class="px-3 py-2 text-left border-b border-gray-200"><span class="inline-block px-2.5 py-[0.15rem] rounded-full text-xs font-semibold bg-green-100 text-green-700">In stock</span></td>
										</tr>
										<tr>
											<td class="px-3 py-2 text-left border-b border-gray-200">Jeans</td>
											<td class="px-3 py-2 text-left border-b border-gray-200">30-34</td>
											<td class="px-3 py-2 text-left border-b border-gray-200">8</td>
											<td class="px-3 py-2 text-left border-b border-gray-200"><span class="inline-block px-2.5 py-[0.15rem] rounded-full text-xs font-semibold bg-red-100 text-red-700">Low</span></td>
										</tr>
										<tr>
											<td class="px-3 py-2 text-left border-b border-gray-200">T-Shirts</td>
											<td class="px-3 py-2 text-left border-b border-gray-200">All</td>
											<td class="px-3 py-2 text-left border-b border-gray-200">17</td>
											<td class="px-3 py-2 text-left border-b border-gray-200"><span class="inline-block px-2.5 py-[0.15rem] rounded-full text-xs font-semibold bg-green-100 text-green-700">In stock</span></td>
										</tr>
										<tr>
											<td class="px-3 py-2 text-left border-b border-gray-200">Shoes</td>
											<td class="px-3 py-2 text-left border-b border-gray-200">5-9</td>
											<td class="px-3 py-2 text-left border-b border-gray-200">0</td>
											<td class="px-3 py-2 text-left border-b border-gray-200"><span class="inline-block px-2.5 py-[0.15rem] rounded-full text-xs font-semibold bg-gray-200 text-gray-900">Out</span></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="p-4 sm:p-5">
								<p class="text-xs text-gray-500">DEMO DATA</p>
							</div>
						</div>
					</div>
				</div>
			</section>

		</main>
	</div>

	<script src="js/mobile-menu.js"></script>
</body>
</html>
