<?php require APPROOT . '/views/components/header.php'; ?>
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
            <i class="fas fa-users icon-blue"></i>
            <h3>Registered Students</h3>
            <p>The total number of students registered on UniQuest.</p>
            <h1><?php echo $data['studentCount']; ?></h1>
        </div>
        <div class="dashboard-card" onclick="goToComMng()">
            <i class="fas fa-building icon-orange"></i>
            <h3>Registered Companies</h3>
            <p>The total number of companies registered on UniQuest.</p>
            <h1><?php echo $data['companyCount']; ?></h1>
        </div>
        <div class="dashboard-card" onclick="goToJobMng()">
            <i class="fas fa-briefcase icon-purple"></i>
            <h3>Active Job Postings</h3>
            <p>The number of job postings currently active on UniQuest.</p>
            <h1><?php echo $data['activeJobCount']; ?></h1>
        </div>
        <div class="dashboard-card" onclick="goToPopularCom()">
            <i class="fas fa-star icon-yellow"></i>
            <h3>Most Popular Company</h3>
            <p>The most reviewed company by the students.</p>
            <h1><?php echo $data['mostPopularCompany']->CompanyName; ?></h1>
        </div>
        <div class="dashboard-card" onclick="goToPopularJob()">
            <i class="fas fa-fire icon-red"></i>
            <h3>Most Popular Job</h3>
            <p>The most applied job by the students.</p>
            <h1><?php echo $data['mostPopularJob']->Title; ?></h1>
        </div>
        <div class="dashboard-card" onclick="goToAnalytics()">
            <i class="fas fa-chart-line icon-green"></i>
            <h3>Revenue of the Month</h3>
            <p>The revenue gained by the premium users this month.</p>
            <h1>Rs. <?php echo $data['revenueOfMonth']; ?></h1>
        </div>
        <div class="dashboard-card" onclick="goToUserVer()">
            <i class="fas fa-user-check icon-teal"></i>
            <h3>Pending Users</h3>
            <p>The number of user verifications pending action.</p>
            <h1><?php echo $data['pendingUserCount']; ?></h1>
        </div>
        <div class="dashboard-card" onclick="goToJobsVer()">
            <i class="fas fa-clipboard-check icon-indigo"></i>
            <h3>Pending Jobs</h3>
            <p>The number of job verifications pending action.</p>
            <h1><?php echo $data['pendingJobCount']; ?></h1>
        </div>
        <div class="dashboard-card" onclick="goToComplaintMng()">
            <i class="fas fa-exclamation-triangle icon-pink"></i>
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

    function goToPopularCom() {
        window.location.href = "<?php echo URLROOT; ?>/jobs/companydescription/<?php echo $data['mostPopularCompany']->CompanyID; ?>";
    }

    function goToPopularJob() {
        window.location.href = "<?php echo URLROOT; ?>/jobs/jobsdescription/<?php echo $data['mostPopularJob']->JobID; ?>";
    }

    function goToAnalytics() {
        window.location.href = "<?php echo URLROOT; ?>/admin/analytics";
    }

    function goToComplaintMng() {
        window.location.href = "<?php echo URLROOT; ?>/admin/all_complaints?search=pending";
    }

    function goToUserVer() {
        window.location.href = "<?php echo URLROOT; ?>/admin/user_ver_pending";
    }

    function goToJobsVer() {
        window.location.href = "<?php echo URLROOT; ?>/admin/job_ver_pending";
    }

    function goToComMng() {
        window.location.href = "<?php echo URLROOT; ?>/admin/company_mng";
    }
    function goToJobMng() {
        window.location.href = "<?php echo URLROOT; ?>/admin/ptjobs_mng";
    }
</script>