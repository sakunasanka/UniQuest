<?php require APPROOT . '/views/components/stu_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/noti_alert.css">

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/studentSidePanel.php'; ?> 
    
    <!-- Content Area -->
    <main class="content-area">
        <h2>Notification & Alerts</h2>
        <div class="content">
            <div class="notification-card">
                <h3>New Job Posting</h3>
                <p class="job-title">Software Engineer at Axme Inc.</p>
                <p>A new job opportunity has been posted that matches your profile. Click to apply now.</p>
                <button class="action-btn">Apply Now</button>
                <button class="bell-btn">&#128276;</button>
            </div>
            
            <div class="notification-card">
                <h3>Application Update</h3>
                <p class="job-title">Marketing Intern at XYZ Corp.</p>
                <p>Your application for the Marketing Intern has been accepted. Please check your dashboard for the next step.</p>
                <button class="action-btn">View Dashboard</button>
                <button class="bell-btn">&#128276;</button>
            </div>
            
            <div class="notification-card">
                <h3>Bookmark Reminder</h3>
                <p class="job-title">Software Engineer at Axme Inc.</p>
                <p>You bookmarked the Graphic Designer position at Branding Co. The application deadline is coming up soon.</p>
                <button class="action-btn">Apply Now</button>
                <button class="bell-btn">&#128276;</button>
            </div>
        </div>
    </main>
</div>

<!-- Footer -->

<?php require APPROOT . '/views/components/footer.php'; ?>