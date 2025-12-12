<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<meta name="description" content="View or update your profile information" />
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

					<?php if (!empty($updateStatusMessage)): ?>
						<div class="mt-3 p-3 rounded <?= $update_isError ? "bg-red-100 text-red-700" : "bg-green-100 text-green-700" ?>">
							<?= htmlspecialchars($updateStatusMessage) ?>
						</div>
					<?php endif; ?>

					<form method="post" action="/user/profile" class="mt-3">
						<div class="flex flex-col sm:flex-row gap-4 sm:gap-8 mt-3">
							<div class="flex-1 flex flex-col">
								<label class="block text-sm mb-1" for="Name"><strong>Full Name</strong></label>
								<input id="full_name" type="text" name="full_name" placeholder="Enter your full name" value="<?= $user["full_name"]?>" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
							</div>

							<div class="flex-1 flex flex-col">
								<label class="block text-sm mb-1" for="Email"><strong>Email Address</strong></label>
								<input id="email" type="email" name="email" placeholder="Enter your email address" value="<?= $user["email"]?>" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
							</div>
						</div>

						<div class="flex flex-col sm:flex-row gap-4 sm:gap-8 mt-3">
							<div class="flex-1 flex flex-col">
								<label class="block text-sm mb-1" for="new_password"><strong>New Password</strong></label>
								<input id="new_password" type="password" name="new_password" placeholder="Leave blank to keep current password" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
							</div>

							<div class="flex-1 flex flex-col">
								<label class="block text-sm mb-1" for="confirm_pass"><strong>Confirm New Password</strong></label>
								<input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm your new password" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
							</div>
						</div>

						<div class="flex flex-wrap gap-4 mt-3">
							<button class="border border-gray-300 rounded bg-[#0A6CFF] text-white text-xs cursor-pointer mr-1 px-2 py-1 hover:bg-[#0A6CFF] transition-colors" type="submit">Save Changes</button>
						</div>
					</form>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<h3 class="font-bold text-lg text-[#EB000C]">Delete Account</h3>
					<p class="text-sm text-gray-600 mt-2">You will not be able to recover your account once you delete it. This action will remove all information tied to your account.</p>

					<?php if (!empty($deleteStatusMessage)): ?>
						<div class="mt-3 p-3 rounded <?= $delete_isError ? "bg-red-100 text-red-700" : "bg-green-100 text-green-700" ?>">
							<?= htmlspecialchars($deleteStatusMessage) ?>
						</div>
					<?php endif; ?>

					<form method="post" action="/user/delete-profile" class="mt-4" onsubmit="return confirmDelete()">
						<div class="flex flex-col max-w-md">
							<label class="block text-sm mb-1" for="delete_password"><strong>Confirm your password to proceed</strong></label>
							<input id="delete_password" type="password" name="delete_password" placeholder="Enter your password" required class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-red-500"/>
						</div>

						<div class="flex flex-wrap gap-4 mt-3">
							<button class="border border-[#EB000C] rounded bg-[#EB000C] text-white text-xs cursor-pointer px-2 py-1 hover:bg-red-700 transition-colors" type="submit">Delete My Account</button>
						</div>
					</form>
				</div>
			</section>
		</main>
	</div>

	<script src="/js/mobile-menu.js"></script>
	<script>
		// return value of this controls whether the form will be submitted or not
		function confirmDelete() {
			return confirm("Are you sure you want to delete your account?");
		}
	</script>
</body>
</html>
