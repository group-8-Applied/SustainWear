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
		$email = strtolower(trim($_POST["email"]));
		$full_name = ucwords(strtolower(trim($_POST["full_name"])));
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
	<title>SustainWear • Sign Up</title>
	<link rel="stylesheet" href="styles/output.css" />
</head>

<body class="m-0 h-full bg-[#f5f7fb] text-gray-900 font-sans">
	<div class="min-h-screen grid place-items-center p-7">
		<div class="w-full max-w-[420px] bg-white rounded-[14px] shadow-[0_12px_30px_rgba(2,8,20,.06)] p-[22px] pb-[26px]">
			<h1 class="text-center text-green-700 my-[6px_0_14px] mb-[14px] mt-[6px] font-extrabold tracking-[0.3px] text-2xl">SustainWear</h1>

			<div class="grid grid-cols-2 gap-[6px] mb-[10px]">
				<button id="tab-login" class="bg-gray-200 border-0 rounded-[10px] p-[10px] font-bold text-center cursor-pointer" type="button" onclick="location.href='login.php'">Log In</button>
				<button id="tab-signup" class="bg-green-500 text-white border-0 rounded-[10px] p-[10px] font-bold text-center cursor-pointer" type="button">Sign Up</button>
			</div>

			<form action="signup.php" method="POST" class="grid gap-[10px] mt-[12px]">
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
					<input id="su-confirm" name="password-confirmation" type="password" placeholder="Confirm password" class="w-full py-[10px] px-[12px] rounded-[10px] border border-gray-300 bg-white" required />
				</div>

				<button class="inline-block border-0 rounded-[10px] py-[12px] px-[14px] font-semibold cursor-pointer bg-blue-500 text-white hover:bg-blue-600 mt-2" type="submit">Create Account</button>
			</form>

			<p class="text-red-500 text-center mt-4">
				<?php echo $signup_msg; ?>
			</p>
		</div>
	</div>
</body>
</html>
