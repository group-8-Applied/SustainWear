<?php
	session_start();
	$signup_msg = "";
	$db = new SQLite3("database.db");

	function user_exists($email) {
		global $db;
		$statement = $db->prepare("SELECT * FROM accounts WHERE email = :email");
		$statement->bindParam(":email", $email);
		$result = $statement->execute();
		$account_data = $result->fetchArray(SQLITE3_ASSOC);
		return boolval($account_data);
	}

	function create_user($full_name, $email, $raw_password) {
		// hash password
		$password_hash = password_hash($raw_password, PASSWORD_BCRYPT);

		// generate token
		$session_token = bin2hex(random_bytes(32));

		global $db;
		$statement = $db->prepare("INSERT INTO accounts (full_name, email, password_hash, session_token, user_role) VALUES (:fname, :email, :pw_hash, :token, 'donor')");
		$statement->bindParam(":fname", $full_name);
		$statement->bindParam(":email", $email);
		$statement->bindParam(":pw_hash", $password_hash);
		$statement->bindParam(":token", $session_token);
		$statement->execute();
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$email = $_POST["email"];
		$full_name = $_POST["full_name"];
		$password = $_POST["password"];
		$password_confirmation = $_POST["password-confirmation"];

		// check pw match
		if ($password !== $password_confirmation) { 
			$signup_msg = "Passwords do not match";
		}
		// ensure pw at least 8 long
		else if (strlen($password) < 8) {
			$signup_msg = "Password is too short";
		}
		// require 2 names & at least 4 letters
		else if (substr_count($full_name, " ") < 1 || count(count_chars($full_name, 1)) < 4) {
			$signup_msg = "Name invalid";
		}
		// email validity
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$signup_msg = "Email address is invalid";
		}
		// ensure email doesnt exist
		else if (user_exists($email)) {
			$signup_msg = "Email address is already registered";
		}
		// all checks passed, create user and sign in
		else {
			$signup_msg = "Sign up success";

			// create database entry for user
			create_user($full_name, $email, $password);

			// fetch session token and user id
			$statement = $db->prepare("SELECT * FROM accounts WHERE email = :email");
			$statement->bindParam(":email", $email);
			$result = $statement->execute();
			$account_data = $result->fetchArray(SQLITE3_ASSOC);

			// set session & redirect to account page
			$_SESSION["session_token"] = $account_data["session_token"];
			$_SESSION["user_id"] = $account_data["user_id"];
			header("Location: account.php");
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>DonationStation: Sign Up</title>
	<link rel="stylesheet" href="styles/output.css" />
</head>

<body class="flex justify-center items-center h-screen bg-[#e5e7eb] shadow-md">
	<div class="p-12 rounded-xl bg-white">

		<h1 class="font-extrabold text-4xl text-center text-green-700">Donation Station</h1>

		<div class="flex justify-center items-center p-10">
			<!-- grey Login, green Sign Up (opposite of login.php) -->
			<button
				class="bg-[#e5e7eb] w-full border border-gray-300 rounded py-2 px-3 mb-4"
				type="button"
				onclick="location.href='login.php'">
				Log In
			</button>
			<button
				class="bg-[#22c55e] w-full border border-gray-300 rounded py-2 px-3 mb-4"
				type="button">
				Sign Up
			</button>
		</div>

		<form class="rounded px-8 pt-6 pb-8 mb-4" action="signup.php" method="POST">
			<div class="mb-4">
				<label class="block" for="su-name">Full name</label>
				<input
					class="appearance-none w-full"
					id="su-name"
					name="full_name"
					type="text"
					placeholder="Taylor Green"
					required
				/>
			</div>

			<div class="mb-4">
				<label class="block" for="su-email">Email</label>
				<input
					class="appearance-none w-full"
					id="su-email"
					name="email"
					type="email"
					placeholder="you@example.com"
					required
				/>
			</div>

			<div class="mb-4">
				<label class="block" for="su-password">Password</label>
				<input
					class="appearance-none w-full"
					id="su-password"
					name="password"
					type="password"
					placeholder="Create password"
					required
				/>
			</div>

			<div class="mb-4">
				<label class="block" for="su-confirm">Confirm password</label>
				<input
					class="appearance-none w-full"
					id="su-confirm"
					name="password-confirmation"
					type="password"
					placeholder="Confirm password"
					required
				/>
			</div>

			<button
				class="bg-[#3b82f6] w-full border border-gray-300 rounded py-2 px-3 mb-4"
				type="submit">
				Create Account
			</button>
		</form>

		<p class="text-red-500 text-center mt-4">
			<?php echo $signup_msg; ?>
		</p>
	</div>
</body>
</html>