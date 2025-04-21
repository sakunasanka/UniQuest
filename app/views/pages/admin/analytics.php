<?php require APPROOT . '/views/components/adm_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/admin/analytics.css">

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
        <!-- Stats -->
        <div class="stats">
            <div class="card stat-card">
                <div>
                    <h3>Total Active Students</h3>
                    <p><?php echo $data['activeCounts']['students'] ?? 0; ?></p>
                </div>
                <div class="icon_">
                    <span class="material-symbols-outlined large-icon">groups</span>
                </div>
            </div>
            <div class="card stat-card">
                <div>
                    <h3>Total Active Companies</h3>
                    <p><?php echo $data['activeCounts']['companies'] ?? 0; ?></p>
                </div>
                <div class="icon_">
                    <span class="material-symbols-outlined large-icon">store</span>
                </div>
            </div>
            <div class="card stat-card">
                <div>
                    <h3>Total Active Part Time Jobs</h3>
                    <p><?php echo $data['activeCounts']['part_time_jobs'] ?? 0; ?></p>
                </div>
                <div class="icon_">
                    <span class="material-symbols-outlined large-icon">work</span>
                </div>
            </div>
            <div class="card stat-card">
                <div>
                    <h3>Total Active Internships</h3>
                    <p><?php echo $data['activeCounts']['internships'] ?? 0; ?></p>
                </div>
                <div class="icon_">
                    <span class="material-symbols-outlined large-icon">school</span>
                </div>
            </div>
        </div>

        <!-- Charts -->
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
    // Pass PHP data to JavaScript
    const analyticsData = {
        registrationStats: <?php echo json_encode($data['registrationStats'] ?? []); ?>,
        jobStats: <?php echo json_encode($data['jobStats'] ?? []); ?>,
        revenueStats: <?php echo json_encode($data['revenueStats'] ?? []); ?>,
        loginStats: <?php echo json_encode($data['loginStats'] ?? []); ?>
    };
</script>

<script src="<?php echo URLROOT; ?>/js/admin/analytics.js"></script>

<!-- Footer -->
<?php require APPROOT . '/views/components/footer.php'; ?>