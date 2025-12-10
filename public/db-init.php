<?php

if (file_exists(__DIR__ . "/../database.db")) {
	echo "Database already exists. Delete database.db first if you want to reinitialise.";
	exit();
}

$db = new SQLite3(__DIR__ . "/../database.db");

function createUser($db, $email, $password, $role) {
	$passwordHash = password_hash($password, PASSWORD_BCRYPT);

	$db->exec("INSERT INTO accounts (full_name, email, password_hash, session_token, user_role) VALUES (
		'$email',
		'$email',
		'$passwordHash',
		'',
		'$role'
	)");
}

$db->exec("CREATE TABLE IF NOT EXISTS accounts (
	user_id INTEGER PRIMARY KEY AUTOINCREMENT,
	full_name TEXT NOT NULL,
	email TEXT NOT NULL UNIQUE,
	password_hash TEXT NOT NULL,
	session_token TEXT NOT NULL,
	user_role TEXT NOT NULL
)");

$db->exec("CREATE TABLE IF NOT EXISTS donations (
	donation_id INTEGER PRIMARY KEY AUTOINCREMENT,
	donor_id INTEGER NOT NULL,
	donor_name TEXT NOT NULL,
	item_type TEXT NOT NULL,
	size TEXT NOT NULL,
	condition TEXT NOT NULL,
	notes TEXT,
	photo_path TEXT,
	status TEXT NOT NULL DEFAULT 'pending',
	submitted_date TEXT NOT NULL,
	reviewed_date TEXT,
	reviewer_id INTEGER,
	FOREIGN KEY (donor_id) REFERENCES accounts(user_id),
	FOREIGN KEY (reviewer_id) REFERENCES accounts(user_id)
)");

createUser($db, "jake.flem@gmail.com", "bigflemmer", "donor");
createUser($db, "saintmo@hotmail.com", "patrick", "staff");
createUser($db, "pt123@live.com", "coolcola251", "admin");

echo "Database initialised<br>";
echo "Test accounts:<br>";
echo "- Admin: pt123@live.com / coolcola251<br>";
echo "- Staff: saintmo@hotmail.com / patrick<br>";
echo "- Donor: jake.flem@gmail.com / bigflemmer<br>";

?>
