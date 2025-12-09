<?php
	$user = Auth::getUser();

	// fake notifications list just for display
	$notificationsExampleData = [
		["title" => "Donation approved", "text" => "Your donation \"Winter Coat\" has been approved by staff.", "time" => "Today · 10:15", "kind" => "good"],
		["title" => "Donation pending review", "text" => "Your donation \"Jeans\" is waiting for a staff member to review it.", "time" => "Yesterday · 16:02", "kind" => "middle"],
		["title" => "Account details updated", "text" => "You changed your email address last week. If this wasn't you, contact support.", "time" => "2025-01-02 · 09:30", "kind" => "info"]
	];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear • Notifications</title>
	<link rel="stylesheet" href="/styles/output.css" />
</head>

<body class="bg-gray-200 min-h-screen">
	<div class="flex flex-col lg:flex-row-reverse min-h-screen">
		<?php include __DIR__ . "/../components/sidebar.php"; ?>

		<main class="flex-1 p-4 sm:p-6 lg:p-8 pt-16 lg:pt-8">
			<section class="mb-6">
				<h2 class="text-2xl font-bold mb-4"><strong>Notifications</strong></h2>

				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p>You are logged in as <?=$user["full_name"]?> <?=$user["email"] ?></p>
					<p>This page shows a simple list of recent activity such as donations, status changes for the user, and account updates.</p>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg">
						Recent activity
					</p>
					<ul class="list-none mt-3 p-0">
						<?php foreach ($notificationsExampleData as $oneNote): ?>
							<?php
								$dotClass = "w-2 h-2 rounded-full flex-shrink-0 mt-1";
								if ($oneNote["kind"] === "good") {
									$dotClass .= " bg-green-500";
								} elseif ($oneNote["kind"] === "middle") {
									$dotClass .= " bg-amber-500";
								} elseif ($oneNote["kind"] === "info") {
									$dotClass .= " bg-blue-500";
								}
							?>
							<li class="border-b border-gray-200 py-[0.6rem]">
								<div class="flex items-start gap-2">
									<span class="<?= $dotClass; ?>"></span>

									<div class="flex-1">
										<p class="font-semibold text-[0.95rem] mb-[0.15rem]">
											<?= htmlspecialchars($oneNote["title"]); ?>
										</p>

										<p class="text-[0.85rem] mb-[0.15rem]">
											<?= htmlspecialchars($oneNote["text"]); ?>
										</p>

										<p class="text-xs text-gray-500">
											<?= htmlspecialchars($oneNote["time"]); ?>
										</p>
									</div>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>

					<p class="mt-2 text-xs text-gray-500">DEMO DATA</p>
				</div>
			</section>
		</main>
	</div>

	<script src="/js/mobile-menu.js"></script>
</body>
</html>
