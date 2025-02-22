<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/navbar.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Student'): ?>
        <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/footer.css">
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/home_footer.css">
    <?php endif; ?>   
    
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">
                <img src="<?php echo URLROOT; ?>/images/UniQuest3.png" alt="UniQuest Logo">
            </div>
            <ul class="nav-links">
                <li><a href="/UniQuest/home" class="hov">Home</a></li>
                <li><a href="/UniQuest/jobs" class="hov">Part-time Jobs</a></li>
                <li><a href="/UniQuest/internships" class="hov">Internships</a></li>
                <li><a href="/UniQuest/companies" class="hov">Companies</a></li>
                <!-- <li class="dropdown">
                    <a href="#" class="dropbtn">Explore<span class="material-symbols-outlined"> expand_more </span></a>
                    <div class="dropdown-content">
                        <a href="/UniQuest/jobs">Part-time Jobs</a>
                        <a href="/UniQuest/internships">Internships</a>
                        <a href="/UniQuest/companies">Companies</a>
                    </div>
                </li> -->
                <!-- <li><a href="/UniQuest/about" class="hov">About Us</a></li> -->
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Student'): ?>
                <li><a href="/UniQuest/student/contact_admin" class="hov">Contact Us</a></li>
            </ul>
            <?php require APPROOT . '/views/components/navProfile.php'; ?>
            <div class="nav-icons">
                <a href="/UniQuest/student/notifications"><span class="material-symbols-outlined">notifications</span></a>
                <span class="notification-badge">1</span>
            </div>
            <?php else: ?>    
                <?php endif; ?>    
        </div>
    </nav>