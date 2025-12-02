<?php
	session_start();
	$login_msg = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$email = strtolower(trim($_POST["email"]));
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

<body class="m-0 h-full bg-[#f5f7fb] text-gray-900 font-sans">
	<div class="min-h-screen grid place-items-center p-7">
		<div class="w-full max-w-[420px] bg-white rounded-[14px] shadow-[0_12px_30px_rgba(2,8,20,.06)] p-[22px] pb-[26px]">
			<h1 class="text-center text-green-700 my-[6px_0_14px] mb-[14px] mt-[6px] font-extrabold tracking-[0.3px] text-2xl">SustainWear</h1>

			<div class="grid grid-cols-2 gap-[6px] mb-[10px]">
				<button id="tab-login" class="bg-green-500 text-white border-0 rounded-[10px] p-[10px] font-bold text-center cursor-pointer" type="button">Log In</button>
				<button id="tab-signup" class="bg-gray-200 border-0 rounded-[10px] p-[10px] font-bold text-center cursor-pointer" type="button" onclick="location.href='signup.php'">Sign Up</button>
			</div>

			<form action="login.php" method="POST" class="grid gap-[10px] mt-[12px]">
				<div class="grid gap-[6px] mt-[2px]">
					<label for="login-email" class="font-semibold text-sm text-gray-700">Email</label>
					<input id="login-email" name="email" type="email" placeholder="you@example.com" class="w-full py-[10px] px-[12px] rounded-[10px] border border-gray-300 bg-white" required />
				</div>
				<div class="grid gap-[6px] mt-[2px]">
					<label for="login-password" class="font-semibold text-sm text-gray-700">Password</label>
					<input id="login-password" name="password" type="password" placeholder="••••••••" class="w-full py-[10px] px-[12px] rounded-[10px] border border-gray-300 bg-white" required />
				</div>

				<button class="inline-block border-0 rounded-[10px] py-[12px] px-[14px] font-semibold cursor-pointer bg-blue-500 text-white hover:bg-blue-600 mt-2" type="submit">Proceed</button>
			</form>

			<p class="text-red-500 text-center mt-4">
				<?php echo $login_msg; ?>
			</p>
		</div>
	</div>
</body>
</html>
