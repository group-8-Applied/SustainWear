<?php

// register autoload handler
// adapted from https://stackoverflow.com/a/56726949
spl_autoload_register(function ($className) {
	$paths = [
		__DIR__ . "/../app/Controllers/" . $className . ".php",
		__DIR__ . "/../app/Core/" . $className . ".php",
		__DIR__ . "/../app/Models/" . $className . ".php"
	];

	foreach ($paths as $path) {
		if (file_exists($path)) {
			require_once $path;
			return;
		}
	}
});

// init session/router
Auth::initSession();
$router = new Router();


// redirect base url to /login
$router->add("GET", "/", "")->useMiddleware(function() {
	header("Location: /login");
	exit();
});


// Logout route
$router->add("GET", "/logout", "AuthController@logout");


// Login page routes
$router->add("GET", "/login", "AuthController@showLogin")->useMiddleware(function() {
	Auth::requireGuest();
});

$router->add("POST", "/login", "AuthController@attemptLogin")->useMiddleware(function() {
	Auth::requireGuest();
});


// Signup page routes
$router->add("GET", "/signup", "AuthController@showSignup")->useMiddleware(function() {
	Auth::requireGuest();
});

$router->add("POST", "/signup", "AuthController@signup")->useMiddleware(function() {
	Auth::requireGuest();
});


// User routes
$router->add("GET", "/user/dashboard", "UserController@dashboard")->useMiddleware(function() {
	Auth::requireRole("donor");
});

$router->add("GET", "/user/donate", "UserController@donate")->useMiddleware(function() {
	Auth::requireRole("donor");
});

$router->add("POST", "/user/donate", "UserController@submitDonation")->useMiddleware(function() {
	Auth::requireRole("donor");
});

$router->add("GET", "/user/profile", "UserController@profile")->useMiddleware(function() {
	Auth::requireRole("donor");
});

$router->add("POST", "/user/profile", "UserController@updateProfile")->useMiddleware(function() {
	Auth::requireRole("donor");
});

$router->add("GET", "/user/notifications", "UserController@notifications")->useMiddleware(function() {
	Auth::requireRole("donor");
});

$router->add("GET", "/user/help", "UserController@help")->useMiddleware(function() {
	Auth::requireRole("donor");
});


// Staff routes
$router->add("GET", "/staff/dashboard", "StaffController@dashboard")->useMiddleware(function() {
	Auth::requireRole("staff");
});

$router->add("GET", "/staff/pending-donations", "StaffController@pendingDonations")->useMiddleware(function() {
	Auth::requireRole("staff");
});

$router->add("GET", "/staff/inventory", "StaffController@inventory")->useMiddleware(function() {
	Auth::requireRole("staff");
});

$router->add("GET", "/staff/reports", "StaffController@reports")->useMiddleware(function() {
	Auth::requireRole("staff");
});

$router->add("POST", "/staff/approve-donation", "StaffController@approveDonation")->useMiddleware(function() {
	Auth::requireRole("staff");
});

$router->add("POST", "/staff/decline-donation", "StaffController@declineDonation")->useMiddleware(function() {
	Auth::requireRole("staff");
});


// Admin routes
$router->add("GET", "/admin/dashboard", "AdminController@dashboard")->useMiddleware(function() {
	Auth::requireRole("admin");
});

$router->add("GET", "/admin/users", "AdminController@manageUsers")->useMiddleware(function() {
	Auth::requireRole("admin");
});

$router->add("GET", "/admin/donations", "AdminController@donations")->useMiddleware(function() {
	Auth::requireRole("admin");
});

$router->add("GET", "/admin/settings", "AdminController@settings")->useMiddleware(function() {
	Auth::requireRole("admin");
});

$router->add("POST", "/admin/update-donation", "AdminController@updateDonation")->useMiddleware(function() {
	Auth::requireRole("admin");
});


// handle current incoming request
$router->handleRequest();
