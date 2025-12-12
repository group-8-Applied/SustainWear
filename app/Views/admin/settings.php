<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<meta name="description" content="Manage system settings" />
	<title>SustainWear • System Settings</title>
	<link rel="stylesheet" href="/styles/output.css" />
</head>

<body class="bg-gray-200 min-h-screen">
	<div class="flex flex-col lg:flex-row-reverse min-h-screen">
		<?php include __DIR__ . "/../components/sidebar.php"; ?>

		<main class="flex-1 p-4 sm:p-6 lg:p-8 pt-16 lg:pt-8">
			<section class="mb-6">
				<h2 class="text-2xl font-bold mb-4">System Settings</h2>
			</section>

			<?php if (isset($statusMessage)): ?>
				<div class="mb-6 p-4 rounded <?= $isError ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' ?>">
					<?= htmlspecialchars($statusMessage) ?>
				</div>
			<?php endif; ?>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-6">
					<h3 class="font-bold text-lg mb-4">Donation Settings</h3>

					<form method="POST" action="/admin/settings">
						<input type="hidden" name="action" value="save_donation_settings" />

						<div class="flex flex-col gap-4">
							<div>
								<label class="flex items-center gap-2">
									<input type="checkbox" name="allow_donations" <?= ($settings['allow_donations'] ?? '1') === '1' ? 'checked' : '' ?> class="w-4 h-4" />
									<span>Allow new donations</span>
								</label>
							</div>
						</div>

						<button type="submit" class="mt-6 bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 transition-colors">Save Donation Settings</button>
					</form>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-6">
					<h3 class="font-bold text-lg mb-4">User Settings</h3>

					<form method="POST" action="/admin/settings">
						<input type="hidden" name="action" value="save_user_settings" />

						<div class="flex flex-col gap-4">
							<div>
								<label class="flex items-center gap-2">
									<input type="checkbox" name="allow_registrations" <?= ($settings['allow_registrations'] ?? '1') === '1' ? 'checked' : '' ?> class="w-4 h-4" />
									<span>Allow new user registrations</span>
								</label>
							</div>

							<div>
								<label class="block font-bold mb-2" for="session_timeout">Session timeout (hours)</label>
								<input type="number" id="session_timeout" name="session_timeout" value="<?= htmlspecialchars($settings['session_timeout'] ?? '24') ?>" class="w-full border border-gray-300 rounded px-3 py-2" />
							</div>
						</div>

						<button type="submit" class="mt-6 bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 transition-colors">Save User Settings</button>
					</form>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-6">
					<h3 class="font-bold text-lg mb-4">Emergency Settings</h3>

					<form method="POST" action="/admin/reset-database">
						<div class="flex flex-col gap-4">
							<div class="border border-red-300 rounded p-4 bg-red-50">
								<p class="font-bold mb-2">Reset database</p>
								<p class="text-sm text-gray-700 mb-3">This will delete all data and reset the system to defaults.</p>
								<button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors">Reset Database</button>
							</div>
						</div>
					</form>
				</div>
			</section>

		</main>
	</div>

	<script src="/js/mobile-menu.js"></script>
</body>
</html>
