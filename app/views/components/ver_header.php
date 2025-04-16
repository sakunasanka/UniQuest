<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/navbar.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/footer.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?php echo URLROOT; ?>/js/components/flash.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

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
                        <a href="/UniQuest/jobs">Part-time Jobs</a>
                        <a href="/UniQuest/internships">Internships</a>
                        <a href="/UniQuest/companies">Companies</a>
                    </div>
                </li>
                <li><a href="/UniQuest/verification_team/user_ver_pending" class="hov">Go to verify</a></li>
                <!-- <li><a href="/uniQuest/about" class="hov">About Us</a></li> -->
                <li><a href="/uniQuest/verification_team/contact_admin" class="hov">Contact Us</a></li>
            </ul>
            <?php require APPROOT . '/views/components/navProfile.php'; ?>
            <div class="nav-icons">
                <a href="/UniQuest/verification_team/notifications"><span class="material-symbols-outlined">notifications</span></a>
                <span class="notification-badge">1</span>
            </div>
        </div>
    </nav>