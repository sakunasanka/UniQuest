<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/application_dashboard.css">

<div class="main-container">
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>

    <div class="content-area">
        <div class="containera">
            <div class="headerb">
                <h1>Job Applications Dashboard</h1>
                <div class="header-buttons">
                    <button class="btn-primary" onclick="goToJobPost()">Add New Job</button>
                    <!-- <button class="btn-secondary">Filter</button> -->
                </div>
            </div>

            <div class="job-listings">
                <?php foreach ($jobs as $job): ?>
                    <div class="job-card">
                        <div class="job-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="job-details">
                            <h2><?php echo $job['title']; ?></h2>
                            <p>

                                <?php echo $job['location']; ?> •
                                Published On: <?php echo $job['posted']; ?>
                            </p>
                        </div>
                        <div class="job-stats">
                            <div class="stat-item">
                                <i class="fas fa-file-alt total-icon"></i>
                                <span><?php echo $job['stats']['total']; ?></span> Total
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-check-circle accepted-icon"></i>
                                <span><?php echo $job['stats']['accepted']; ?></span> Accepted
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-times-circle rejected-icon"></i>
                                <span><?php echo $job['stats']['rejected']; ?></span> Rejected
                            </div>
                            <div class="stat-item pending-stat">
                                <i class="fas fa-clock pending-icon"></i>
                                <span><?php echo $job['stats']['pending']; ?></span> Pending
                            </div>
                        </div>
                        <div class="job-actions">

                            <!-- Corrected onclick with proper quotes and PHP embedding -->
                            <span class="view-link" onclick="window.location.href='<?php echo URLROOT; ?>/service_provider/new_applications/<?php echo $job['jobID']; ?>'">
                                View Applications <i class="fas fa-chevron-right"></i>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php 
        // require APPROOT . '/views/components/pagination.php'; 
        ?>
    </div>
</div>
<?php require APPROOT . '/views/components/footer.php'; ?>

<script>
    function goToJobPost() {
        window.location.href = "<?php echo URLROOT; ?>/service_provider/jobpost";
    }
</script>