<?php
	$user = Auth::getUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear • Profile</title>
	<link rel="stylesheet" href="/styles/output.css" />
</head>

<body class="bg-gray-200 min-h-screen">
	<div class="flex flex-col lg:flex-row-reverse min-h-screen">
		<?php include __DIR__ . "/../components/sidebar.php"; ?>

		<main class="flex-1 p-4 sm:p-6 lg:p-8 pt-16 lg:pt-8">
			<section class="mb-6">
				<h2 class="text-2xl font-bold mb-4">Profile</h2>
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p>You are logged in as <?= $user["full_name"]?> (<?= $user["email"]?>)</p>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<h3 class="font-bold text-lg">Edit profile details</h3>
					<form method="post" class="mt-3">
						<div class="flex flex-col sm:flex-row gap-4 sm:gap-8 mt-3">
							<div class="flex-1 flex flex-col">
								<label class="block text-sm mb-1" for="Name"><strong>Full Name</strong></label>
								<input id="Name" type="text" name="Name" placeholder="Enter your full name" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
							</div>

							<div class="flex-1 flex flex-col">
								<label class="block text-sm mb-1" for="Email"><strong>Email Address</strong></label>
								<input id="Email" type="email" name="Email" placeholder="Enter your email address" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
							</div>
						</div>

						<div class="flex flex-col sm:flex-row gap-4 sm:gap-8 mt-3">
							<div class="flex-1 flex flex-col">
								<label class="block text-sm mb-1" for="Password"><strong>New Password</strong></label>
								<input id="Password" type="password" name="Password" placeholder="Leave blank to keep current password" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
							</div>

							<div class="flex-1 flex flex-col">
								<label class="block text-sm mb-1" for="confirm_pass"><strong>Confirm New Password</strong></label>
								<input id="confirm_pass" type="password" name="confirm_pass" placeholder="Confirm your new password" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
							</div>
						</div>

						<div class="flex flex-wrap gap-4 mt-3">
							<button class="border border-gray-300 rounded bg-blue-500 text-white text-xs cursor-pointer mr-1 px-2 py-1 hover:bg-blue-600 transition-colors" type="submit">Save Changes</button>
						</div>
					</form>
				</div>
			</section>
		</main>
	</div>

	<script src="/js/mobile-menu.js"></script>
</body>
</html>
