<?php
	$user = Auth::getUser();

	// some fake FAQ items just for display
	$helpQuestionsFakeList = [
		["question" => "How do I donate clothes?", "answer" => "Go to the Donations page, fill in the item details, and submit the form. Staff will then review your donation."],
		["question" => "What happens after I submit a donation?", "answer" => "Your donation will appear with the status Pending. A staff member will approve or decline it and the status will update."],
		["question" => "Who can see my donations?", "answer" => "Only authorised charity staff and administrators can see detailed donation information."]
	];
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear • Help & Support</title>
	<link rel="stylesheet" href="/styles/output.css" />
</head>

<body class="bg-gray-200 min-h-screen">
	<div class="flex flex-col lg:flex-row-reverse min-h-screen">
		<?php include __DIR__ . "/../components/sidebar.php"; ?>

		<main class="flex-1 p-4 sm:p-6 lg:p-8 pt-16 lg:pt-8">
			<section class="mb-6">
				<h2 class="text-2xl font-bold mb-4">
					Help &amp; Support
				</h2>

				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p>
						You are logged in as
						<strong><?= htmlspecialchars($user["full_name"]); ?></strong><br />
						<?= htmlspecialchars($user["email"]); ?>
					</p>
					<p>
						This page is where you can find quick answers and send a short
						message to support. For now, everything here is demo-only and
						does not send real emails.
					</p>
				</div>
			</section>

			<section class="mb-6">
				<div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
					<p class="font-bold text-lg">
						Common questions
					</p>

					<ul class="list-none mt-3 p-0">
						<?php foreach ($helpQuestionsFakeList as $oneHelpRow): ?>
							<li class="border-b border-gray-200 py-[0.6rem]">
								<p class="font-semibold text-[0.95rem] mb-[0.15rem]">
									<?= htmlspecialchars($oneHelpRow["question"]); ?>
								</p>

								<p class="text-[0.85rem] mb-[0.15rem]">
									<?= htmlspecialchars($oneHelpRow["answer"]); ?>
								</p>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</section>
		</main>
	</div>

	<script src="/js/mobile-menu.js"></script>
</body>
</html>
