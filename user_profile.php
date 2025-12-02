<?php
	include "session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>  
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>DonationStation: Notifications</title>
	<link rel="stylesheet" href="styles/output.css" />
	<link rel="stylesheet" href="styles/style.css" />
</head>

<body class="page-background">
	<div class="page-layout">
		<aside class="sidebar">
			<h1 class="sidebar-logo">DonationStation</h1>
			<div class="sidebar-section">
				<p class="sidebar-section-title">Navigation</p>
				<div class="sidebar-nav-list">
					<button class="nav-button" onclick="location.href='account.php'">Dashboard</button>
					<button class="nav-button" onclick="location.href='user_donate.php'">Donations</button>
					<button class="nav-button nav-button-active" onclick="location.href='user_profile.php'">Profile</button>
					<button class="nav-button" onclick="location.href='user_notifications.php'">Notifications</button>
					<button class="nav-button" onclick="location.href='user_help_and_support.php'">Help & Support</button>
				</div>
			</div>
			<div class="sidebar-logout">
				<button class="nav-button" onclick="location.href='logout.php'">Logout</button>
			</div>
		</aside>

        <main class="main-panel">
            <section class="section-block">
			    <h2 class="section-title">Profile</h2>
				    <div class="info-card">
				    	<p>You are logged in as X></p>
				    </div>
		    </section>

            <section class="section-block">
                <div class="profile-form-box">
                    <h3 class="info-label">Edit profile details</h3>
                    <form class="profile-form" method="post">
                        <div class="profile-form-row">
                            <div class="profile-form-input">
                                <label class="filter-label-text" for="Name">Full Name</label>
                                <input id="Name" type="text" name="Name" placeholder="Enter your full name"/>
                            </div>

                            <div class="profile-form-input">
                                <label class="filter-label-text" for="Email">Email Address</label>
                                <input id="Email" type="email" name="Email" placeholder="Enter your email address"/>
                            </div>
                        </div>

                        <div class="profile-form-row">
                            <div class="profile-form-input">
                                <label class="filter-label-text" for="Password">New Password</label>
                                <input id="Password" type="password" name="Password" placeholder="Leave blank to keep current password"/>
                            </div>

                            <div class="profile-form-input">
                                <label id="profile_picture"class="filter-label-text" for="confirm_pass">Confirm New Password</label>
                                <input id="confirm_pass" type="password" name="confirm_pass" placeholder="Confirm your new password"/>
                            </div>
                        </div>

                        <div class="profile-form-row">
                            <div class="profile-form-input">
                                <label class="filter-label-text" for="profile_picture" type="file" disabled>profile picture</label>
                                <textarea id="Bio" name="Bio" rows="4" placeholder="Write a short bio about yourself"></textarea>
                            </div>

                        <div class="profile-form-row">
                            <button class="table-button" type="submit">Save Changes</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>     
</body>
</html>