<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/admin/analytics.css">

<header class="header">
    <div class="logo-block"></div>
    <div class="nav-block"></div>
</header>

<div class="main-container">
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?> 
    
    <main class="content-area">
        <div class="stats">
            <div class="card stat-card">
                <div>
                    <h3>Total Active Students</h3>
                    <p><?php echo $data['activeCounts']['students'] ?? 0; ?></p>
                </div>
                <div class="icon_">
                    <span class="material-symbols-outlined large-icon blue-icon">groups</span>
                </div>
            </div>
            <div class="card stat-card">
                <div>
                    <h3>Total Active Companies</h3>
                    <p><?php echo $data['activeCounts']['companies'] ?? 0; ?></p>
                </div>
                <div class="icon_">
                    <span class="material-symbols-outlined large-icon green-icon">store</span>
                </div>
            </div>
            <div class="card stat-card">
                <div>
                    <h3>Total Active Part Time Jobs</h3>
                    <p><?php echo $data['activeCounts']['part_time_jobs'] ?? 0; ?></p>
                </div>
                <div class="icon_">
                    <span class="material-symbols-outlined large-icon orange-icon">work</span>
                </div>
            </div>
            <div class="card stat-card">
                <div>
                    <h3>Total Active Internships</h3>
                    <p><?php echo $data['activeCounts']['internships'] ?? 0; ?></p>
                </div>
                <div class="icon_">
                    <span class="material-symbols-outlined large-icon purple-icon">school</span>
                </div>
            </div>
        </div>
        <div class="charts">
            <div class="card chart-card">
                <canvas id="registrationsChart"></canvas>
            </div>
            <div class="card chart-card">
                <canvas id="jobListingsChart"></canvas>
            </div>
            <div class="card chart-card">
                <canvas id="revenueChart"></canvas>
            </div>
            <div class="card chart-card">
                <canvas id="loginsChart"></canvas>
            </div>
        </div>
    </main>
</div>

<script>
    const analyticsData = {
        registrationStats: <?php echo json_encode($data['registrationStats'] ?? []); ?>,
        jobStats: <?php echo json_encode($data['jobStats'] ?? []); ?>,
        revenueStats: <?php echo json_encode($data['revenueStats'] ?? []); ?>,
        loginStats: <?php echo json_encode($data['loginStats'] ?? []); ?>
    };
</script>

<script src="<?php echo URLROOT; ?>/js/admin/analytics.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>