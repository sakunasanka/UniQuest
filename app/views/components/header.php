<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/navbar1.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/navbar2.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/styles.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/home_footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">
                <img src="<?php echo URLROOT; ?>/images/UniQuest3.png" alt="UniQuest Logo">
            </div>
            <ul class="nav-links">
                <li><a href="/UniQuest/home" class="hov">Home</a></li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Explore<span class="material-symbols-outlined"> expand_more </span></a>
                    <div class="dropdown-content">
                        <a href="/UniQuest/student/jobs">Part-time Jobs</a>
                        <a href="/UniQuest/student/internships">Internships</a>
                        <a href="/UniQuest/student/company">Companies</a>
                    </div>
                </li>
                <li><a href="/UniQuest/about" class="hov">About Us</a></li>
                <li><a href="/UniQuest/contact" class="hov">Contact Us</a></li>
            </ul>
            <div class="nav-button">
                <a href="/uniquest/user/login" class="get-started">Get Started</a>
            </div>
        </div>
    </nav>