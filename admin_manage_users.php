<?php
	$thisPageOwner = ["email"     => "admin@example.com","full_name" => "Admin man","user_role" => "admin",];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>DonationStation: Manage Users</title>
	<link rel="stylesheet" href="styles/output.css" />
	<link rel="stylesheet" href="styles/style.css" />
</head>

<body class="page-background">
	<div class="page-layout">
	<!-- side bar options -->
		<aside class="sidebar">
			<h1 class="sidebar-logo">DonationStation</h1>
			<div class="sidebar-section"><p class="sidebar-section-title">Navigation</p>
				<div class="sidebar-nav-list">
					<button class="nav-button" onclick="location.href='admin_dashboard.php'">Overview</button>
					<button class="nav-button nav-button-active"> Manage Users</button>
					<button class="nav-button">Donations</button>
					<button class="nav-button">System Settings</button>
					<button class="nav-button">Notifications</button>
					<button class="nav-button">Help & Support</button>
				</div>
			</div>
			<div class="sidebar-logout">
				<button class="nav-button" onclick="location.href='logout.php'">Logout</button>
			</div>
		</aside>

		<!-- main manage users area -->
		<main class="admin-main-area">

			<section class="section-block">
				<h2 class="section-title">Manage Users</h2>
				<p style="margin-bottom: 0.75rem;"> You are signed in as <strong><?= $thisPageOwner["full_name"]; ?></strong> (<?= $thisPageOwner["user_role"]; ?>).</p>
			</section>
			<section class="section-block">
				<div class="filter-box">
					<p class="info-label filter-box-title">User filters</p>

					<div class="filter-row">
						<div class="filter-small-box">
							<label class="filter-label-text" for="filter-name">Search name / email</label>
							<input id="filter-name" class="filter-text-input" type="text" placeholder="Type to search..." />
						</div>

						<div class="filter-small-box">
							<label class="filter-label-text" for="filter-role">Role</label>
							<select id="filter-role" class="filter-select-box">
								<option>Any</option>
								<option>Admin</option>
								<option>Staff</option>
								<option>Donor</option>
							</select>
						</div>

						<div class="filter-small-box">
							<label class="filter-label-text" for="filter-status">Status</label>

							<select id="filter-status" class="filter-select-box">
								<option>Any</option>
								<option>Active</option>
								<option>Inactive</option>
							</select>
						</div>

					</div>

					<p class="filter-little-note">Filters are still fake for now – they don’t actually change the user list yet.</p>
				</div>
			</section>

			<!-- big user table -->
			<section class="section-block">
				<div class="big-user-table-box">
					<p class="info-label big-user-table-title">
						Users in the system
					</p>

					<table class="user-table-main">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Role</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<!-- one set of EXAMPLE data -->
						<tbody>
							<tr>
								<td class="users-name">Auser</td>
								<td class="users-email">sss@example.com</td>
								<td><span class="role-pill role-pill-blue">Staff</span></td>
								<td><span class="active-pill active-pill-yes">Active</span></td>
								<td>
									<button class="tiny-table-button">View</button>
									<button class="tiny-table-button tiny-table-button-soft">Deactivate</button>
								</td>
							</tr>
						</tbody>
					</table>
					<p class="table-hint">thi srow is fake data</p>
				</div>
			</section>


			<section class="section-block">
				<div class="role-change-box">
					<p class="info-label role-change-title">Change a user's role</p>
					<form method="POST" class="role-change-form">
						<div class="role-change-row">
							<div class="role-change-field">
								<label class="filter-label-text" for="role-change-email">User email</label>
								<input id="role-change-email" name="role_change_email" class="filter-text-input" type="email" placeholder="user@example.com"/>
							</div>
							<div class="role-change-field">
								<label class="filter-label-text" for="role-change-role">New role</label>
								<select id="role-change-role" name="role_change_role" class="filter-select-box">
									<option value="">Pick one…</option>
									<option value="admin">Admin</option>
									<option value="staff">Staff</option>
									<option value="donor">Donor</option>
								</select>
							</div>
							<div class="role-change-field role-change-button-wrap">
								<button type="submit" class="tiny-table-button">Change role</button>
							</div>
						</div>
					</form>
				</div>
			</section>
		</main>
	</div>
</body>
</html>