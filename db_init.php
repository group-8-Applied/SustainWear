<?php
	header("Location: index.html");
	exit(); // this file should only run if a new database is required

    $db = new SQLite3("database.db");

	$db->exec("CREATE TABLE IF NOT EXISTS accounts (
		user_id INTEGER PRIMARY KEY AUTOINCREMENT,
		full_name TEXT NOT NULL,
		email TEXT NOT NULL UNIQUE,
		password_hash TEXT NOT NULL,
		session_token TEXT NOT NULL,
		user_role TEXT NOT NULL
	)");
  
	$password_hash = password_hash("bigflemmer", PASSWORD_BCRYPT);
	$db->exec("INSERT INTO accounts (full_name, email, password_hash, session_token, user_role) VALUES (
		'Jake Flemmings',
		'jake.flem@gmail.com',
		'$password_hash',
		'',
		'donor'
	)");

	$password_hash2 = password_hash("patrick", PASSWORD_BCRYPT);
	$db->exec("INSERT INTO accounts (full_name, email, password_hash, session_token, user_role) VALUES (
		'Saint Montgomery',
		'saintmo@hotmail.com',
		'$password_hash2',
		'',
		'staff'
	)");

	$password_hash3 = password_hash("coolcola251", PASSWORD_BCRYPT);
	$db->exec("INSERT INTO accounts (full_name, email, password_hash, session_token, user_role) VALUES (
		'Prawn Teacon',
		'pt123@live.com',
		'$password_hash3',
		'',
		'admin'
	)");
?>