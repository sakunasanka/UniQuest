<?php require APPROOT . '/views/components/ser_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/admin/analytics.css">

<header class="header">
    <div class="logo-block"></div>
    <div class="nav-block"></div>
</header>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?> 
    
    <!-- Content Area -->
    <main class="content-area">
        <!-- Stats -->
        <div class="stats">
            <div class="card stat-card">
                <div>
                    <h3>Total Jobs</h3>
                    <p>50</p>
                </div>
                <div class="icon_">
                    <span class="material-symbols-outlined large-icon">work</span>
                </div>
            </div>
            <div class="card stat-card">
                <div>
                    <h3>Active Jobs</h3>
                    <p>08</p>
                </div>
                <div class="icon_">
                    <span class="material-symbols-outlined large-icon">work</span>
                </div>
            </div>
            <div class="card stat-card">
                <div>
                    <h3>Applicants</h3>
                    <p>26</p>
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

<script src="<?php echo URLROOT; ?>/js/service_provider/ser_analytics.js"></script>

<!-- Footer -->
<?php require APPROOT . '/views/components/footer.php'; ?>