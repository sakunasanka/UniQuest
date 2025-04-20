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
        <div class="nav-icons">
            
                <button class="notification-btn" id="notificationDropdown">
                    <span class="material-symbols-outlined">notifications</span>
                    <?php if (isset($unreadCount) && $unreadCount > 0): ?>
                        <span class="notification-badge"><?= $unreadCount ?></span>
                    <?php endif; ?>
                    <span class="notification-badge">1</span>
                </button>
                <div class="notification-dropdown" id="notificationDropdownContent">
                    <div class="notification-header">
                        <h4>Notifications</h4>
                        <a href="<?= URLROOT ?>/student/notifications/mark-all-read" class="mark-all-read">Mark all as read</a>
                    </div>
                    <div class="notification-items">
                        <div class="text-center py-3">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="notification-footer">
                        <a href="<?= URLROOT ?>/student/notifications">View all notifications</a>
                    </div>
                </div>
            </div>
            
        <?php require APPROOT . '/views/components/navProfile.php'; ?>
    <?php else: ?>
    <?php endif; ?>
    </div>
</nav>