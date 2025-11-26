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
	<title>SustainWear • Sign Up</title>
	<link rel="stylesheet" href="styles/output.css" />
	<link rel="stylesheet" href="styles/style.css" />
</head>

<body class="">
	<div class="">
		<div class="flex flex-col justify-center  items-center h-screen bg-white container mx-auto max-w-screen-sm max-h-screen-sm rounded-3xl">
			<h1 class="font-extrabold text-4xl text-green-700">SustainWear</h1>

			<div class="w-full flex flex-row gap-4">
				
				<button type="submit"class="flex-1 bg-gray-200 hover:bg-gray-300 rounded py-2"onclick="location.href='login.php'">Login</button>
				<button type="submit"class="flex-1 bg-green-500 hover:bg-green-700 rounded py-2">Sign Up</button>
				
			</div>

			<form action="signup.php" method="POST" class="">
				<div class="flex-auto">

						<label for="su-name">Full name</label>
						<input id = "su-name" name= "full_name"type="text" placeholder="Taylor Green" class="flex-1 bg-transparent outline-none" required />
						
						
				</div>

				<div class="flex-auto">
					<label for="su-email">Email</label>
					<input id = "su-email" name= "email"type="email" placeholder="you@example.com" class="flex-1 bg-transparent outline-none" required />
				</div>

				<div class="flex-auto">
					<label for="su-password">Password</label>
					<input id = "su-password" name= "password"type="password" placeholder="Create password" class="flex-1 bg-transparent outline-none" required />
				</div>

				<div class="flex-auto">
					<label for="su-confirm">Confirm password</label>
					<input id = "su-confirm" name= "password-confirmation"type="password" placeholder="Confirm password" class="flex-1 bg-transparent outline-none" required />
				</div>
				<div class= "w-full flex flex-row gap-4">

					<button type="submit"class="flex-1 btn btn-primary mt-2 bg-blue-200 hover:bg-blue-300 rounded py-2">Create Account</button>
				</div>
			</form>

			<p class="text-red-500 text-center mt-4">
				<?php echo $signup_msg; ?>
			</p>
		</div>
	</div>
</body>
</html>
