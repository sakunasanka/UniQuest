<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/navbar2.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">
                <img src="<?php echo URLROOT; ?>/images/UniQuest3.png" alt="UniQuest Logo">
            </div>
            <ul class="nav-links">
                <li><a href="#" class="hov">Home</a></li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Explore<span class="material-symbols-outlined"> expand_more </span></a>
                    <div class="dropdown-content">
                        <a href="#">Part-time Jobs</a>
                        <a href="#">Internships</a>
                    </div>
                </li>
                <li><a href="#" class="hov">About Us</a></li>
                <li><a href="#" class="hov">Contact Us</a></li>
            </ul>
            <div class="nav-icons">
                <a href="#"><span class="material-symbols-outlined">account_circle</span></a>
                <a href="#"><span class="material-symbols-outlined">notifications</span></a>
                <span class="notification-badge">1</span>
            </div>
        </div>
    </nav>

