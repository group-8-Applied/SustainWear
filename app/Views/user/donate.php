<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear • Donate Clothes</title>
	<link rel="stylesheet" href="/styles/output.css" />
</head>

<body class="bg-gray-200 min-h-screen">
	<div class="flex flex-col lg:flex-row-reverse min-h-screen">
		<?php include __DIR__ . "/../components/sidebar.php"; ?>

		<main class="flex-1 p-4 sm:p-6 lg:p-8 pt-16 lg:pt-8">
			<section class="mb-6">
				<h2 class="text-2xl font-bold mb-4">My Donations</h2>

				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5 flex flex-col gap-3 items-start">
					<p>You are logged in as <?=$user["full_name"]?> <br> <?=$user["email"] ?>.</p>
					<p>Use the form below to record a clothing donation. Staff will review it and later change the status to <strong class="text-green-600">Approved</strong> or <strong class="text-red-500">Declined</strong>.</p>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<h3 class="font-bold text-lg">New donation</h3>
					<form method="POST" class="mt-3">
						<div class="flex flex-wrap gap-4 mt-3">
							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="item_type">Item type</label>
								<select id="item_type" name="item_type" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
									<option value="">Pick an item…</option>
									<option value="Coat">Coat / Jacket</option>
									<option value="Jeans">Jeans</option>
									<option value="T-Shirt">T-Shirt</option>
									<option value="Shoes">Shoes</option>
									<option value="Other">Other clothing</option>
								</select>
							</div>

							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="size">Size</label>
								<input id="size" name="size" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="text" placeholder="example: M, 32, 8" />
							</div>

							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="condition">Condition</label>
								<select id="condition" name="condition" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
									<option value="">Select condition…</option>
									<option value="Excellent">Excellent</option>
									<option value="Good">Good</option>
									<option value="Acceptable">Acceptable</option>
								</select>
							</div>
						</div>

						<div class="flex flex-wrap gap-4 mt-3">
							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="notes">Notes (optional)</label>
								<textarea id="notes" name="notes" rows="3" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Anything else staff should know?"></textarea>
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

					<?php if (!empty($donationMessage)): ?>
						<p class="mt-3 text-[0.8rem] <?= $isError ? "text-red-600" : "text-green-600" ?>"><?= htmlspecialchars($donationMessage) ?></p>
					<?php endif ?>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">Donation history</p>
					<div class="overflow-x-auto -mx-4 sm:mx-0">
						<table class="w-full border-collapse text-sm">
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
								<?php if (empty($donations)): ?>
									<tr>
										<td colspan="5" class="px-3 py-4 text-center text-gray-500">No donations yet. Submit your first donation above!</td>
									</tr>
								<?php else: ?>
									<?php foreach ($donations as $donation): ?>
										<tr>
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
				</div>
			</section>

		</main>
	</div>

	<script src="/js/mobile-menu.js"></script>
</body>
</html>
