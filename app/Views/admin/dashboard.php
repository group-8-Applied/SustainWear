<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear • Admin Dashboard</title>
	<link rel="stylesheet" href="/styles/output.css" />
</head>

<body class="bg-gray-200 min-h-screen">
	<div class="flex flex-col lg:flex-row-reverse min-h-screen">
		<?php include __DIR__ . "/../components/sidebar.php"; ?>

		<main class="flex-1 p-4 sm:p-6 lg:p-8 pt-16 lg:pt-8">
			<section class="mb-6">
				<h2 class="text-2xl font-bold mb-4">Admin Dashboard</h2>

				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5 flex flex-col gap-3 items-start">
					<div>
						<h3 class="font-bold text-lg">Full Name</h3>
						<p><?= $user["full_name"]; ?></p>
					</div>

					<div class="mt-4">
						<h3 class="font-bold text-lg">Email</h3>
						<p><?= $user["email"]; ?></p>
					</div>
				</div>
			</section>

			<section class="mb-6">
				<div class="flex flex-col sm:flex-row gap-4">

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Total Donations</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1"><?= $stats["total"] ?></p>
					</div>

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Pending</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1 text-amber-600"><?= $stats["pending"] ?></p>
					</div>

					<div class="flex-1 min-w-full sm:min-w-[200px] bg-white rounded-xl shadow-md p-6 sm:p-8">
						<p class="font-bold text-lg">Approved</p>
						<p class="text-xl sm:text-2xl font-extrabold mt-1 text-green-600"><?= $stats["total_approved"] ?></p>
					</div>
				</div>
			</section>
		</main>
	</div>

	<script src="/js/mobile-menu.js"></script>
</body>
</html>
