<?php
	include "session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear • Manage Users</title>
	<link rel="stylesheet" href="styles/output.css" />
</head>

<body class="bg-gray-200 min-h-screen">
	<div class="flex flex-col lg:flex-row-reverse min-h-screen">
		<?php include "components/sidebar.php"; ?>

		<main class="flex-1 p-4 sm:p-6 lg:p-8 pt-16 lg:pt-8">

			<section class="mb-6">
				<h2 class="text-2xl font-bold mb-4">Manage Users</h2>
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p>You are signed in as <strong><?= $account_data["full_name"]; ?></strong> (<?= $account_data["user_role"]; ?>).</p>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">User filters</p>

					<div class="flex flex-wrap gap-4">
						<div class="flex-1 min-w-full sm:min-w-[10rem]">
							<label class="block text-sm mb-1" for="filter-name">Search name / email</label>
							<input id="filter-name" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="text" placeholder="Type to search..." />
						</div>

						<div class="flex-1 min-w-full sm:min-w-[10rem]">
							<label class="block text-sm mb-1" for="filter-role">Role</label>
							<select id="filter-role" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
								<option>Any</option>
								<option>Admin</option>
								<option>Staff</option>
								<option>Donor</option>
							</select>
						</div>

						<div class="flex-1 min-w-full sm:min-w-[10rem]">
							<label class="block text-sm mb-1" for="filter-status">Status</label>
							<select id="filter-status" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
								<option>Any</option>
								<option>Active</option>
								<option>Inactive</option>
							</select>
						</div>
					</div>

					<p class="mt-2 text-xs text-gray-500">DEMO</p>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">
						Users in the system
					</p>

					<div class="overflow-x-auto -mx-4 sm:mx-0">
						<table class="w-full min-w-[600px] border-collapse text-sm">
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
								<tr>
									<td class="px-3 py-2 text-left border-b border-gray-200">User Name</td>
									<td class="px-3 py-2 text-left border-b border-gray-200">sss@example.com</td>
									<td class="px-3 py-2 text-left border-b border-gray-200"><span class="inline-block px-2.5 py-[0.15rem] rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Staff</span></td>
									<td class="px-3 py-2 text-left border-b border-gray-200"><span class="inline-block px-2.5 py-[0.15rem] rounded-full text-xs font-semibold bg-green-100 text-green-700">Active</span></td>
									<td class="px-3 py-2 text-left border-b border-gray-200">
										<button class="border border-gray-300 rounded bg-blue-500 text-white text-xs cursor-pointer mr-1 px-2 py-1 hover:bg-blue-600 transition-colors">View</button>
										<button class="border border-gray-300 rounded bg-gray-200 text-gray-900 text-xs cursor-pointer mr-1 px-2 py-1 hover:bg-gray-300 transition-colors">Deactivate</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>

					<p class="mt-2 text-xs text-gray-500">DEMO DATA</p>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg mb-3">Change a user's role</p>
					<form method="POST">
						<div class="flex flex-wrap gap-4 items-end">
							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="role-change-email">User email</label>
								<input id="role-change-email" name="role_change_email" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="email" placeholder="user@example.com"/>
							</div>
							<div class="flex-1 min-w-full sm:min-w-[10rem]">
								<label class="block text-sm mb-1" for="role-change-role">New role</label>
								<select id="role-change-role" name="role_change_role" class="w-full px-2 py-[0.4rem] border border-gray-300 rounded text-[0.9rem] bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
									<option value="">Pick one…</option>
									<option value="admin">Admin</option>
									<option value="staff">Staff</option>
									<option value="donor">Donor</option>
								</select>
							</div>
							<div class="flex-none">
								<button type="submit" class="border border-gray-300 rounded bg-blue-500 text-white text-xs cursor-pointer px-2 py-1 hover:bg-blue-600 transition-colors">Change role</button>
							</div>
						</div>
					</form>
				</div>
			</section>
		</main>
	</div>

	<script src="js/mobile-menu.js"></script>
</body>
</html>