<?php require APPROOT . '/views/components/adm_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/adminDash.css">

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?> 
    
    <!-- Content Area -->
    <main class="content-area">
    <div class="dashboard-container">
        <!-- Dashboard stats -->
        
        <div class="dashboard-card" onclick="goToStuMng()">
            <h3>Registered Students</h3>
            <p>The total number of students registered on UniQuest.</p>
            <h1><?php echo $data['studentCount']; ?></h1>
        </div>
        <div class="dashboard-card" onclick="goToComMng()">
            <h3>Registered Companies</h3>
            <p>The total number of companies registered on UniQuest.</p>
            <h1><?php echo $data['companyCount']; ?></h1>
        </div>
        <div class="dashboard-card" onclick="goToJobMng()">
            <h3>Active Job Postings</h3>
            <p>The number of job postings currently active on UniQuest.</p>
            <h1><?php echo $data['activeJobCount']; ?></h1>
        </div>
        <div class="dashboard-card" onclick="goToComMng()">
            <h3>Most Popular Company</h3>
            <p>The most viewed company by the students.</p>
            <h1><?php echo "Company 1"; ?></h1>
        </div>
        <div class="dashboard-card" onclick="goToJobMng()">
            <h3>Most Popular Job</h3>
            <p>The most applied job by the students.</p>
            <h1><?php echo "Job Title 1"; ?></h1>
        </div>
        <div class="dashboard-card" onclick="goToAnalytics()">
            <h3>Revenue of the Month</h3>
            <p>The revenue gained by the premium users this month.</p>
            <h1><?php echo 25000; ?></h1>
        </div>
        <div class="dashboard-card" onclick="goToStuMng()">
            <h3>Pending User Verification</h3>
            <p>The number of user verifications pending action.</p>
            <h1><?php echo $data['pendingUserCount']; ?></h1>
        </div>
        <div class="dashboard-card" onclick="goToJobMng()">
            <h3>Pending Job Verification</h3>
            <p>The number of job verifications pending action.</p>
            <h1><?php echo $data['pendingJobCount']; ?></h1>
        </div>
        <div class="dashboard-card" onclick="goToComplaintMng()">
            <h3>Pending Complaints</h3>
            <p>The number of complaints pending action.</p>
            <h1><?php echo $data['pendingComplaintCount']; ?></h1>
        </div>
    </div>
    </main>
</div>

<!-- Footer -->

<?php require APPROOT . '/views/components/footer.php'; ?>

<script>
    function goToStuMng() {
        window.location.href = "<?php echo URLROOT; ?>/admin/students_mng";
    }

    function goToComMng() {
        window.location.href = "<?php echo URLROOT; ?>/admin/company_mng";
    }

    function goToJobMng() {
        window.location.href = "<?php echo URLROOT; ?>/admin/ptjobs_mng";
    }

    function goToAnalytics() {
        window.location.href = "<?php echo URLROOT; ?>/admin/analytics";
    }

    function goToComplaintMng() {
        window.location.href = "<?php echo URLROOT; ?>/admin/job_complaint";
    }
</script>