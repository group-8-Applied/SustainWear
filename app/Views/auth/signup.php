<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear • Sign Up</title>
	<link rel="stylesheet" href="/styles/output.css" />
</head>

<body class="m-0 h-full bg-[#f5f7fb] text-gray-900 font-sans">
	<div class="min-h-screen grid place-items-center p-7">
		<div class="w-full max-w-[420px] bg-white rounded-[14px] shadow-[0_12px_30px_rgba(2,8,20,.06)] p-[22px] pb-[26px]">
			<h1 class="text-center text-green-700 my-[6px_0_14px] mb-[14px] mt-[6px] font-extrabold tracking-[0.3px] text-2xl">SustainWear</h1>

			<div class="grid grid-cols-2 gap-[6px] mb-[10px]">
				<button id="tab-login" class="bg-gray-200 border-0 rounded-[10px] p-[10px] font-bold text-center cursor-pointer" type="button" onclick="location.href='/login'">Log In</button>
				<button id="tab-signup" class="bg-green-500 text-white border-0 rounded-[10px] p-[10px] font-bold text-center cursor-pointer" type="button">Sign Up</button>
			</div>

			<form action="/signup" method="POST" class="grid gap-[10px] mt-[12px]">
				<div class="grid gap-[6px] mt-[2px]">
					<label for="su-name" class="font-semibold text-sm text-gray-700">Full name</label>
					<input id="su-name" name="full_name" type="text" placeholder="Taylor Green" class="w-full py-[10px] px-[12px] rounded-[10px] border border-gray-300 bg-white" required />
				</div>

				<div class="grid gap-[6px] mt-[2px]">
					<label for="su-email" class="font-semibold text-sm text-gray-700">Email</label>
					<input id="su-email" name="email" type="email" placeholder="you@example.com" class="w-full py-[10px] px-[12px] rounded-[10px] border border-gray-300 bg-white" required />
				</div>

				<div class="grid gap-[6px] mt-[2px]">
					<label for="su-password" class="font-semibold text-sm text-gray-700">Password</label>
					<input id="su-password" name="password" type="password" placeholder="Create password" class="w-full py-[10px] px-[12px] rounded-[10px] border border-gray-300 bg-white" required />
				</div>

				<div class="grid gap-[6px] mt-[2px]">
					<label for="su-confirm" class="font-semibold text-sm text-gray-700">Confirm password</label>
					<input id="su-confirm" name="password_confirmation" type="password" placeholder="Confirm password" class="w-full py-[10px] px-[12px] rounded-[10px] border border-gray-300 bg-white" required />
				</div>

				<button class="inline-block border-0 rounded-[10px] py-[12px] px-[14px] font-semibold cursor-pointer bg-blue-500 text-white hover:bg-blue-600 mt-2" type="submit">Create Account</button>
			</form>

			<?php if (!empty($statusMessage)): ?>
				<p class="text-red-500 text-center mt-4">
					<?= htmlspecialchars($statusMessage) ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
</body>
</html>
