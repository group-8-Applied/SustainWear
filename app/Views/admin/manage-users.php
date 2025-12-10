<?php
	$user = Auth::getUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear • Manage Users</title>
	<link rel="stylesheet" href="/styles/output.css" />
</head>

<body class="bg-gray-200 min-h-screen">
	<div class="flex flex-col lg:flex-row-reverse min-h-screen">
		<?php include __DIR__ . "/../components/sidebar.php"; ?>

		<main class="flex-1 p-4 sm:p-6 lg:p-8 pt-16 lg:pt-8">

			<section class="mb-6">
				<h2 class="text-2xl font-bold mb-4">Manage Users</h2>
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p>You are signed in as <strong><?= $user["full_name"]; ?></strong> (<?= $user["user_role"]; ?>).</p>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">User filters</p>

					<form method="GET" action="/admin/users">
						<div class="flex flex-wrap gap-4">
							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="search">Search name / email</label>
								<input id="search" name="search" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="text" placeholder="Type to search..." value="<?= htmlspecialchars($filters["search"] ?? "") ?>" />
							</div>

							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="role">Role</label>
								<select id="role" name="role" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
									<option value="">Any</option>
									<option value="Admin" <?= ($filters["role"] ?? "") === "Admin" ? "selected" : "" ?>>Admin</option>
									<option value="Staff" <?= ($filters["role"] ?? "") === "Staff" ? "selected" : "" ?>>Staff</option>
									<option value="Donor" <?= ($filters["role"] ?? "") === "Donor" ? "selected" : "" ?>>Donor</option>
								</select>
							</div>

							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="status">Status</label>
								<select id="status" name="status" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
									<option value="">Any</option>
									<option value="Active" <?= ($filters["status"] ?? "") === "Active" ? "selected" : "" ?>>Active</option>
									<option value="Inactive" <?= ($filters["status"] ?? "") === "Inactive" ? "selected" : "" ?>>Inactive</option>
								</select>
							</div>
						</div>

						<div class="flex gap-2 mt-4">
							<button type="submit" class="border border-gray-300 rounded bg-blue-500 text-white text-sm cursor-pointer px-4 py-2 hover:bg-blue-600 transition-colors">Apply Filters</button>
							<a href="/admin/users" class="border border-gray-300 rounded bg-gray-200 text-gray-700 text-sm cursor-pointer px-4 py-2 hover:bg-gray-300 transition-colors inline-block">Clear Filters</a>
						</div>
					</form>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">
						Users in the system
					</p>

					<?php if (empty($users)): ?>
						<p class="text-gray-500 text-center py-8">No users found matching your filters.</p>
					<?php else: ?>
						<div class="overflow-x-auto -mx-4 sm:mx-0">
							<table class="w-full border-collapse text-sm">
								<thead class="bg-gray-100">
									<tr>
										<th class="px-3 py-2 text-left border-b border-gray-200">Name</th>
										<th class="px-3 py-2 text-left border-b border-gray-200">Email</th>
										<th class="px-3 py-2 text-left border-b border-gray-200">Role</th>
										<th class="px-3 py-2 text-left border-b border-gray-200">Status</th>
										<th class="px-3 py-2 text-left border-b border-gray-200">Actions</th>
									</tr>
								</thead>

								<tbody>
									<?php foreach ($users as $userEntry): ?>
										<?php
											$isActive = boolval($userEntry["is_active"]);
										?>
										<tr>
											<td class="px-3 py-2 text-left border-b border-gray-200">
												<?= htmlspecialchars($userEntry["full_name"]) ?>
											</td>
											<td class="px-3 py-2 text-left border-b border-gray-200"><?= htmlspecialchars($userEntry["email"]) ?></td>
											<td class="px-3 py-2 text-left border-b border-gray-200">
												<span class="inline-block px-2.5 py-[0.15rem] rounded-full text-xs font-semibold bg-gray-200 text-gray-600">
													<?= ucfirst(htmlspecialchars($userEntry["user_role"])) ?>
												</span>
											</td>
											<td class="px-3 py-2 text-left border-b border-gray-200">
												<span class="inline-block px-2.5 py-[0.15rem] rounded-full text-xs font-semibold <?= $isActive ? "bg-green-100 text-green-700" : "bg-red-100 text-red-700" ?>">
													<?= $isActive ? "Active" : "Inactive" ?>
												</span>
											</td>
											<td class="px-3 py-2 text-left border-b border-gray-200">
												<?php if ($user["user_id"] !== $userEntry["user_id"]): ?>
													<form method="POST" action="/admin/toggle-account-state" style="display: inline;">
														<input type="hidden" name="user_id" value="<?= $userEntry["user_id"] ?>" />
														<input type="hidden" name="action" value="<?= $isActive ? 'deactivate' : 'activate' ?>" />
														<button type="submit" class="rounded <?= $isActive ? 'bg-red-500 text-white hover:bg-red-600' : 'bg-green-500 text-white hover:bg-green-600' ?> text-xs cursor-pointer px-2 py-1 transition-colors">
															<?= $isActive ? 'Deactivate' : 'Activate' ?>
														</button>
													</form>
												<?php else: ?>
													 <button type="submit" class="border border-gray-300 rounded bg-gray-300 text-black opacity-40 hover:bg-gray-600 text-xs cursor-not-allowed px-2 py-1 transition-colors" disabled>Deactivate</button>
												<?php endif; ?>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					<?php endif; ?>

					<?php
						// pagination component for the table
						$totalCount = $userCount;
						$tableLabel = "users";
						include __DIR__ . "/../components/pagination.php";
					?>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">Change a user's role or password</p>

					<?php if (isset($statusMessage)): ?>
						<div class="mb-4 p-3 rounded border <?= $isError ? 'bg-red-100 border-red-400 text-red-700' : 'bg-green-100 border-green-400 text-green-700'; ?>">
							<?= htmlspecialchars($statusMessage); ?>
						</div>
					<?php endif; ?>

					<form method="POST" action="/admin/users">
						<div class="flex flex-wrap gap-4 items-end">
							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="user_email">User email</label>
								<input id="user_email" name="user_email" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="email" placeholder="user@example.com" required/>
							</div>
							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="new_role">New role</label>
								<select id="new_role" name="new_role" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
									<option value="">Pick one...</option>
									<option value="admin">Admin</option>
									<option value="staff">Staff</option>
									<option value="donor">Donor</option>
								</select>
							</div>
							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="new_password">New password</label>
								<input id="new_password" name="new_password" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="password" placeholder="Password (if needed)"/>
							</div>
							<div class="flex-none">
								<button type="submit" class="border border-gray-300 rounded bg-blue-500 text-white text-xs cursor-pointer px-2 py-1 hover:bg-blue-600 transition-colors">Update</button>
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
