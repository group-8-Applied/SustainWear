<?php
	session_start();
	$login_msg = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$email = $_POST["email"];
		$password = $_POST["password"];

		$db = new SQLite3("database.db");

		$statement = $db->prepare("SELECT * FROM accounts WHERE email = :email");
		$statement->bindParam(":email", $email);
		$result = $statement->execute();
		$account_data = $result->fetchArray(SQLITE3_ASSOC);

		if (!$account_data) {
			$login_msg = "No account exists with that email address";
		} else if (password_verify($password, $account_data["password_hash"])) {
			$login_msg = "Login successful";

			// generate and set session token
			$session_token = bin2hex(random_bytes(32));
			$statement = $db->prepare("UPDATE accounts SET session_token = :session_token WHERE email = :email");
			$statement->bindParam(":session_token", $session_token);
			$statement->bindParam(":email", $email);
			$statement->execute();

			// store for authentication
			$_SESSION["session_token"] = $session_token;
			$_SESSION["user_id"] = $account_data["user_id"];

			header("Location: account.php");
		} else {
			$login_msg = "Incorrect password";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>SustainWear • Log In</title>
	<link rel="stylesheet" href="styles/output.css" />

</head>

<body class="flex justify-center items-center h-screen bg-[#e5e7eb] shadow-md">
	<div class="p-12 rounded-xl bg-white">

		<h1 class="font-extrabold text-4xl text-center text-[#15803d]">SustainWear</h1>

		<div class="flex justify-center items-center p-10">
			<button class="bg-[#22c55e] w-full border border-gray-300 rounded py-2 px-3 mb-4 " active type="button">Log In</button>
			<button class="bg-[#e5e7eb] w-full border border-gray-300 rounded py-2 px-3 mb-4" type="button" onclick="location.href='signup.php'">Sign Up</button>
		</div>

		<div class="w-full max-w-xs"></div>
			<form class="rounded px-8 pt-6 pb-8 mb-4" action="login.php" method="POST">
				<div class="mb-4">
					<label class="block" for="login-email">Email</label>
					<input class="appearance-none w-full" blockname="email" type="email" placeholder="you@example.com" required />
				</div>
				
				<div class="mb-4">
					<label class="block" for="login-password">Password</label>
					<input class="appearance-none w-full" name="password" type="password" placeholder="••••••••" required />
				</div>

				<button class="bg-[#3b82f6] w-full border border-gray-300 rounded py-2 px-3 mb-4" type="submit">Proceed</button>

			</form>
		</div>

		<p><?php echo $login_msg; ?></p>

	</div>
</body>
</html>
