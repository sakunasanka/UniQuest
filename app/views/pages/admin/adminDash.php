<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/adminDash.css">

<header class="header">
    <div class="logo-block"></div>
    <div class="nav-block"></div>
</header>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?> 
    
    <!-- Content Area -->
    <main class="content-area">
    <div class="dashboard-container">
        <!-- Dashboard stats -->
        
        <div class="dashboard-card">
            <h3>Registered Students</h3>
            <p>The total number of students registered on UniQuest.</p>
            <h1><?php echo 2500; ?></h1>
        </div>
        <div class="dashboard-card">
            <h3>Registered Companies</h3>
            <p>The total number of companies registered on UniQuest.</p>
            <h1><?php echo 1500; ?></h1>
        </div>
        <div class="dashboard-card">
            <h3>Active Job Postings</h3>
            <p>The number of job postings currently active on UniQuest.</p>
            <h1><?php echo 2000; ?></h1>
        </div>
        <div class="dashboard-card">
            <h3>Most Popular Company</h3>
            <p>The most viewed company by the students.</p>
            <h1><?php echo "Company 1"; ?></h1>
        </div>
        <div class="dashboard-card">
            <h3>Most Popular Job</h3>
            <p>The most applied job by the students.</p>
            <h1><?php echo "Job Title 1"; ?></h1>
        </div>
        <div class="dashboard-card">
            <h3>Revenue of the Month</h3>
            <p>The revenue gained by the premium users this month.</p>
            <h1><?php echo 25000; ?></h1>
        </div>
        <div class="dashboard-card">
            <h3>Pending User Verification</h3>
            <p>The number of user verifications pending action.</p>
            <h1><?php echo 20; ?></h1>
        </div>
        <div class="dashboard-card">
            <h3>Pending Job Verification</h3>
            <p>The number of job verifications pending action.</p>
            <h1><?php echo 50; ?></h1>
        </div>
        <div class="dashboard-card">
            <h3>Pending Complaints</h3>
            <p>The number of complaints pending action.</p>
            <h1><?php echo 15; ?></h1>
        </div>
    </div>
    </main>
</div>

<!-- Footer -->

<?php require APPROOT . '/views/components/footer.php'; ?>