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
	<link rel="stylesheet" href="styles/style.css" />
</head>

<body class="page-background">
	<div class="page-layout">
		<aside class="sidebar">
			<h1 class="sidebar-logo">SustainWear</h1>
			<div class="sidebar-section">
				<p class="sidebar-section-title">Navigation</p>
				<div class="sidebar-nav-list">
					<button class="nav-button nav-button-active">Overview</button>
					<button class="nav-button">Pending Donations</button>
					<button class="nav-button">Inventory</button>
					<button class="nav-button">Reports</button>
					<button class="nav-button">Notifications</button>
					<button class="nav-button">Help & Support</button>
				</div>
			</div>
			<div class="sidebar-logout">
				<button class="nav-button" onclick="location.href='logout.php'">Logout</button>
			</div>
		</aside>
		<main class="user-details-panel">
			<section class="section-block">
				<h2 class="section-title">Staff Dashboard</h2>
				<div class="info-cards">
					<div>
						<h3 class="info-label">Full Name</h3>
						<p><?= $account_data["full_name"]; ?></p>
					</div>
					<div class="info-group">
						<h3 class="info-label">Email</h3>
						<p><?= $account_data["email"]; ?></p>
					</div>
					<div class="info-group">
						<h3 class="info-label">Role</h3>
						<p><?= $account_data["user_role"]; ?></p>
					</div>
				</div>
			</section>
			<section class="section-block">
				<div class="stats-row">
					<div class="stats-card">
						<p class="info-label">Pending Donations</p>
						<p class="stats-value">4</p>
					</div>

					<div class="stats-card">
						<p class="info-label">Approved Today</p>
						<p class="stats-value">2</p>
					</div>

					<div class="stats-card">
						<p class="info-label">Items In Stock</p>
						<p class="stats-value">37</p>
					</div>
				</div>
			</section>
			<section class="section-block staff-two-column">
				<div class="staff-column">
					<h3 class="info-label staff-subtitle">Pending donations</h3>

					<div class="table-card">
						<table class="table">
							<thead>
								<tr>
									<th>Donor</th>
									<th>Item</th>
									<th>Condition</th>
									<th>Status</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Taylor Green</td>
									<td>Winter Coat (M)</td>
									<td>Good</td>
									<td><span class="status-badge status-pending">Pending</span></td>
									<td>
										<div class="flex gap-2 items-center">
											<button class="w-8 h-8 rounded-full bg-green-500/20 text-green-600 font-bold text-base flex items-center justify-center hover:opacity-80 transition-opacity flex-shrink-0" title="Approve">✓</button>
											<button class="w-8 h-8 rounded-full bg-red-500/20 text-red-600 font-bold text-base flex items-center justify-center hover:opacity-80 transition-opacity flex-shrink-0" title="Decline">✕</button>
										</div>
									</td>
								</tr>
								<tr>
									<td>Sam Lee</td>
									<td>Jeans (32)</td>
									<td>Acceptable</td>
									<td><span class="status-badge status-pending">Pending</span></td>
									<td>
										<div class="flex gap-2 items-center">
											<button class="w-8 h-8 rounded-full bg-green-500/20 text-green-600 font-bold text-base flex items-center justify-center hover:opacity-80 transition-opacity flex-shrink-0" title="Approve">✓</button>
											<button class="w-8 h-8 rounded-full bg-red-500/20 text-red-600 font-bold text-base flex items-center justify-center hover:opacity-80 transition-opacity flex-shrink-0" title="Decline">✕</button>
										</div>
									</td>
								</tr>
								<tr>
									<td>Jordan White</td>
									<td>T-Shirt (L)</td>
									<td>Excellent</td>
									<td><span class="status-badge status-pending">Pending</span></td>
									<td>
										<div class="flex gap-2 items-center">
											<button class="w-8 h-8 rounded-full bg-green-500/20 text-green-600 font-bold text-base flex items-center justify-center hover:opacity-80 transition-opacity flex-shrink-0" title="Approve">✓</button>
											<button class="w-8 h-8 rounded-full bg-red-500/20 text-red-600 font-bold text-base flex items-center justify-center hover:opacity-80 transition-opacity flex-shrink-0" title="Decline">✕</button>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<p class="table-hint">Actual functionality for buttons is not yet implemented</p>
					</div>
				</div>

				<div class="staff-column">
					<h3 class="info-label staff-subtitle">Inventory snapshot</h3>
					<div class="table-card">
						<table class="table">
							<thead>
								<tr>
									<th>Category</th>
									<th>Size</th>
									<th>Quantity</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Coats</td>
									<td>M-L</td>
									<td>12</td>
									<td><span class="status-badge status-ok">In stock</span></td>
								</tr>
								<tr>
									<td>Jeans</td>
									<td>30-34</td>
									<td>8</td>
									<td><span class="status-badge status-low">Low</span></td>
								</tr>
								<tr>
									<td>T-Shirts</td>
									<td>All</td>
									<td>17</td>
									<td><span class="status-badge status-ok">In stock</span></td>
								</tr>
								<tr>
									<td>Shoes</td>
									<td>5-9</td>
									<td>0</td>
									<td><span class="status-badge status-out">Out</span></td>
								</tr>
							</tbody>
						</table>
						<p class="table-hint">DEMO DATA</p>
					</div>
				</div>
			</section>

		</main>
	</div>
</body>
</html>