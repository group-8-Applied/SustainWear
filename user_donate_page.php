<?php
	include "session.php";

	$donationMessage = "";
	$pastDonationsExampleData = [
		["item" => "Winter Coat", "size" => "M", "condition" => "Good", "status" => "Approved", "date" => "2025-01-04"],
		["item" => "Jeans", "size" => "32", "condition" => "Acceptable", "status" => "Pending", "date" => "2025-01-06"],
		["item" => "T-Shirt", "size" => "L", "condition" => "Excellent", "status" => "Declined", "date" => "2025-01-02"]
	];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear • Donate Clothes</title>
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
					<button class="nav-button" onclick="location.href='account.php'">Dashboard</button>
					<button class="nav-button nav-button-active">Donations</button>
					<button class="nav-button" onclick="location.href='user_profile.php'">Profile</button>
					<button class="nav-button" onclick="location.href='user_notifications.php'">Notifications</button>
					<button class="nav-button" onclick="location.href='user_help_and_support.php'">Help & Support</button>
				</div>
			</div>
			<div class="sidebar-logout">
				<button class="nav-button" onclick="location.href='logout.php'">Logout</button>
			</div>
		</aside>

		<main class="main-panel">
			<section class="section-block">
				<h2 class="section-title">My Donations</h2>

				<div class="info-card">
					<p>You are logged in as <?=$account_data["full_name"]?> <br> <?=$account_data["email"] ?>.</p>
					<p>Use the form below to record a clothing donation. Staff will review it and later change the status to <strong class="text-green-600">Approved</strong> or <strong class="text-red-500">Declined</strong>.</p>
				</div>
			</section>

			<section class="section-block">
				<div class="info-card">
					<h3 class="info-label">New donation</h3>
					<form method="POST" class="donation-form-box">
						<div class="donation-form-row">
							<div class="donation-form-field">
								<label class="filter-label-text" for="donation_item">Item type</label>

								<select id="donation_item" name="donation_item" class="filter-select-box">
									<option value="">Pick an item…</option>
									<option value="Coat">Coat / Jacket</option>
									<option value="Jeans">Jeans</option>
									<option value="T-Shirt">T-Shirt</option>
									<option value="Shoes">Shoes</option>
									<option value="Other">Other clothing</option>
								</select>
							</div>

							<div class="donation-form-element">
								<label class="filter-label-text" for="donation_size">Size</label>
								<input id="donation_size" name="donation_size" class="filter-text-input" type="text" placeholder="example: M, 32, 8" />
							</div>

							<div class="donation-form-element">
								<label class="filter-label-text" for="donation_condition">Condition</label>

								<select id="donation_condition" name="donation_condition" class="filter-select-box">
									<option value="">Select condition…</option>
									<option value="Excellent">Excellent</option>
									<option value="Good">Good</option>
									<option value="Acceptable">Acceptable</option>
								</select>
							</div>
						</div>

						<div class="donation-form-row">
							<div class="donation-form-element">
								<label class="filter-label-text" for="donation_notes">Notes (optional)</label>
								<textarea id="donation_notes" name="donation_notes" rows="3" class="filter-text-input" placeholder="Anything else staf should know?"></textarea>
							</div>
						</div>

						<div class="donation-form-row">
							<div class="donation-form-field">
								<label class="filter-label-text">Photo (coming later)</label>
								<input type="file" class="filter-text-input" style="background-color:#f3f4f6; cursor:not-allowed" />
								<p class="filter-little-note">Photos don't work currently, this is just so where the field will be.</p>
							</div>
						</div>

						<div class="donation-form-row">
							<button type="submit" class="table-button">Submit donation</button>
						</div>
					</form>

					<?php if ($donationMessage !== ""): ?>
						<p class="message-text"><?= $donationMessage ?></p>
					<?php endif ?>
				</div>
			</section>

			<section class="section-block">
				<div class="big-user-table-box">
					<p class="info-label big-user-table-title">Donation history</p>
					<table class="user-table-main">
						<thead>
							<tr>
								<th>Item</th>
								<th>Size</th>
								<th>Condition</th>
								<th>Status</th>
								<th>Date</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach ($pastDonationsExampleData as $oneRow): ?>
								<tr>
									<td><?= htmlspecialchars($oneRow["item"]) ?></td>
									<td><?= htmlspecialchars($oneRow["size"]) ?></td>
									<td><?= htmlspecialchars($oneRow["condition"]) ?></td>
									<td>
										<?php
											$statusWord = $oneRow["status"];
											$statusClass = "status-badge";
											if ($statusWord === "Approved") {
												$statusClass .= " status-ok";
											} elseif ($statusWord === "Pending") {
												$statusClass .= " status-pending";
											} elseif ($statusWord === "Declined") {
												$statusClass .= " status-low";
											}
										?>
										<span class="<?= $statusClass?>">
											<?= htmlspecialchars($statusWord) ?>
										</span>
									</td>
									<td><?= htmlspecialchars($oneRow["date"]) ?></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>

					<p class="table-hint">DEMO DATA</p>
				</div>
			</section>

		</main>
	</div>
</body>
</html>