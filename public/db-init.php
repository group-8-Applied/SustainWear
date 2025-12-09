<?php

if (file_exists(__DIR__ . "/../database.db")) {
	echo "Database already exists. Delete database.db first if you want to reinitialize.";
	exit();
}

$db = new SQLite3(__DIR__ . "/../database.db");

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
	status TEXT NOT NULL DEFAULT 'pending',
	submitted_date TEXT NOT NULL,
	reviewed_date TEXT,
	reviewer_id INTEGER,
	FOREIGN KEY (donor_id) REFERENCES accounts(user_id),
	FOREIGN KEY (reviewer_id) REFERENCES accounts(user_id)
)");

$passwordHash = password_hash("bigflemmer", PASSWORD_BCRYPT);
$db->exec("INSERT INTO accounts (full_name, email, password_hash, session_token, user_role) VALUES (
	'Jake Flemmings',
	'jake.flem@gmail.com',
	'$passwordHash',
	'',
	'donor'
)");

$passwordHash2 = password_hash("patrick", PASSWORD_BCRYPT);
$db->exec("INSERT INTO accounts (full_name, email, password_hash, session_token, user_role) VALUES (
	'Saint Montgomery',
	'saintmo@hotmail.com',
	'$passwordHash2',
	'',
	'staff'
)");

$passwordHash3 = password_hash("coolcola251", PASSWORD_BCRYPT);
$db->exec("INSERT INTO accounts (full_name, email, password_hash, session_token, user_role) VALUES (
	'Prawn Teacon',
	'pt123@live.com',
	'$passwordHash3',
	'',
	'admin'
)");

echo "Database initialised<br>";
echo "Test accounts:<br>";
echo "- Admin: pt123@live.com / coolcola251<br>";
echo "- Staff: saintmo@hotmail.com / patrick<br>";
echo "- Donor: jake.flem@gmail.com / bigflemmer<br>";

?>
