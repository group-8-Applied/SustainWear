<?php
$user = Auth::getUser();
$donationModel = new Donation();
$stats = $donationModel->getStats();

$approvedToday = $donationModel->getResults(["status" => "approved"]);
$approvedTodayCount = count(array_filter($approvedToday, function($d) {
	return date("Y-m-d", strtotime($d["reviewed_date"])) === date("Y-m-d");
}));

$declinedToday = $donationModel->getResults(["status" => "declined"]);
$declinedTodayCount = count(array_filter($declinedToday, function($d) {
	return date("Y-m-d", strtotime($d["reviewed_date"])) === date("Y-m-d");
}));
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear: Pending Donations</title>
	<link rel="stylesheet" href="/styles/output.css" />
</head>

<body class="bg-gray-200 min-h-screen">
	<div class="flex flex-col lg:flex-row-reverse min-h-screen">
		<?php include __DIR__ . "/../components/sidebar.php"; ?>

		<main class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8 pt-16 lg:pt-8">
			<section class="mb-6">
				<h2 class="text-2xl font-bold mb-4">Pending Donations</h2>
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p>You are signed in as <strong><?= $user["full_name"]; ?></strong> (<?= $user["user_role"]; ?>).</p>
					<p class="mt-2 text-sm text-gray-700">Review and approve or decline pending donation submissions from donors.</p>
				</div>
			</section>

			<section class="mb-6">
				<div class="flex flex-col sm:flex-row gap-4">
					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Pending Review</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1 text-amber-600"><?= $stats["pending"] ?></p>
					</div>

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Approved Today</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1 text-green-600"><?= $approvedTodayCount ?></p>
					</div>

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Declined Today</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1 text-red-600"><?= $declinedTodayCount ?></p>
					</div>
				</div>
			</section>
			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">Review Donations</p>
					<div class="space-y-4">
						<?php if (empty($donations)): ?>
							<p class="text-center text-gray-500 py-4">No pending donations to review</p>
						<?php else: ?>
							<?php foreach ($donations as $donation): ?>
								<div class="border border-gray-200 rounded p-4">
									<div class="flex flex-col sm:flex-row justify-between items-start gap-3">
										<div class="flex flex-col sm:flex-row gap-3 flex-1 min-w-0">
											<div style="flex: 1;">
												<h4 class="font-bold text-base">
													<?= htmlspecialchars($donation["item_type"]) ?> (<?= htmlspecialchars($donation["size"]) ?>)
												</h4>
												<p class="text-sm text-gray-600 mt-1">
													<strong>Donation ID:</strong> #<?= htmlspecialchars($donation["donation_id"]) ?><br>
													<strong>Donor:</strong> <?= htmlspecialchars($donation["donor_name"]) ?><br>
													<strong>Condition:</strong> <?= htmlspecialchars($donation["condition"]) ?><br>
													<strong>Submitted:</strong> <?= htmlspecialchars(date("Y-m-d H:i", strtotime($donation["submitted_date"]))) ?>
												</p>
												<?php if (!empty($donation["notes"])): ?>
													<p class="text-sm text-gray-700 mt-2">
														<strong>Notes:</strong> <?= htmlspecialchars($donation["notes"]) ?>
													</p>
												<?php endif ?>
											</div>
											<?php if (!empty($donation["photo_path"])): ?>
												<div class="flex-shrink-0">
													<a href="<?= htmlspecialchars($donation["photo_path"]) ?>" target="_blank" class="inline-block">
														<img src="<?= htmlspecialchars($donation["photo_path"]) ?>" alt="Donation photo" class="w-20 h-20 object-cover rounded cursor-pointer hover:opacity-75 transition-opacity" />
													</a>
												</div>
											<?php endif ?>
										</div>
										<div class="flex gap-2 flex-shrink-0">
											<form method="POST" action="/staff/approve-donation" style="display: inline;">
												<input type="hidden" name="donation_id" value="<?= htmlspecialchars($donation["donation_id"]) ?>">
												<button type="submit" title="Approve" class="w-8 h-8 rounded-full bg-green-500/20 text-green-600 font-bold text-base flex items-center justify-center hover:opacity-80 transition-opacity flex-shrink-0">✓</button>
											</form>
											<form method="POST" action="/staff/decline-donation" style="display: inline;">
												<input type="hidden" name="donation_id" value="<?= htmlspecialchars($donation["donation_id"]) ?>">
												<button type="submit" title="Decline" class="w-8 h-8 rounded-full bg-red-500/20 text-red-600 font-bold text-base flex items-center justify-center hover:opacity-80 transition-opacity flex-shrink-0">✕</button>
											</form>
										</div>
									</div>
								</div>
							<?php endforeach ?>
						<?php endif ?>
					</div>
				</div>
			</section>
		</main>
	</div>
	<script src="/js/mobile-menu.js"></script>
</body>
</html>
