<nav class="navbar">
    <div class="navbar-container">
        <div class="logo">
            <img src="<?php echo URLROOT; ?>/images/UniQuest3.png" alt="UniQuest Logo">
        </div>
        <ul class="nav-links">
            <li><a href="/UniQuest/home" class="hov">Home</a></li>
            <li><a href="/UniQuest/verification_team/user_ver_pending" class="hov">Go to verify</a></li>
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
            <!-- <li><a href="/uniQuest/about" class="hov">About Us</a></li> -->
            <li><a href="/uniQuest/verification_team/messages_adm" class="hov" onclick="">Contact Us</a></li>
    
        </ul>
        <div class="nav-icons">
            <?php require APPROOT . '/views/components/notification_dropdown.php'; ?>           
        </div>
        
        <?php require APPROOT . '/views/components/navProfile.php'; ?>
    </div>
</nav>