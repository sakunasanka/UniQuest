<nav class="navbar">
    <div class="navbar-container">
        <div class="logo">
            <img src="<?php echo URLROOT; ?>/images/UniQuest3.png" alt="UniQuest Logo">
        </div>
        <ul class="nav-links">
            <li><a href="/UniQuest/home" class="hov">Home</a></li>
            <li><a href="/UniQuest/service_provider/dashboard" class="hov">Dashboard</a></li>
            <li><a href="/UniQuest/jobs" class="hov">Part-time Jobs</a></li>
            <li><a href="/UniQuest/internships" class="hov">Internships</a></li>
            <li><a href="/UniQuest/companies" class="hov">Companies</a></li>
            <li><a href="/UniQuest/service_provider/contact_admin" class="hov">Contact Us</a></li>
        </ul>
        <div class="nav-icons">
            <?php require APPROOT . '/views/components/notification_dropdown.php'; ?>           
        </div>
        
        <?php require APPROOT . '/views/components/navProfile.php'; ?>
    </div>
</nav>