<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/admin/reports.css">
<div class="main-container">
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <main class="content-area">

        <div class="report-container">
            <a href="/UniQuest/admin/viewReport/SystemHealth" class="report-card">
                <i class="fas fa-heartbeat icon-red"></i>
                <h3>System Health</h3>
                <p>Overview of platform metrics and performance</p>
                <div class="report-meta">
                    <span><i class="fas fa-history"></i> Updated hourly</span>
                    <span><i class="fas fa-chart-line"></i> 15 metrics</span>
                </div>
            </a>

            <a href="/UniQuest/admin/viewReport/UserGrowth" class="report-card">
                <i class="fas fa-users icon-blue"></i>
                <h3>User Growth</h3>
                <p>Registration trends and verification status</p>
                <div class="report-meta">
                    <span><i class="fas fa-calendar"></i> Monthly trends</span>
                    <span><i class="fas fa-user-tag"></i> By role</span>
                </div>
            </a>

            <a href="/UniQuest/admin/viewReport/JobPerformance" class="report-card">
                <i class="fas fa-briefcase icon-purple"></i>
                <h3>Job Performance</h3>
                <p>Posting activity and application rates</p>
                <div class="report-meta">
                    <span><i class="fas fa-filter"></i> By category</span>
                    <span><i class="fas fa-percentage"></i> Hire rates</span>
                </div>
            </a>

            <a href="/UniQuest/admin/viewReport/Revenue" class="report-card">
                <i class="fas fa-money-bill-wave icon-green"></i>
                <h3>Revenue Analytics</h3>
                <p>Subscription plans and payment status</p>
                <div class="report-meta">
                    <span><i class="fas fa-star"></i> Plan types</span>
                    <span><i class="fas fa-clock"></i> Retention</span>
                </div>
            </a>
            <a href="/UniQuest/admin/viewReport/StudentPlacement" class="report-card">
                <i class="fas fa-graduation-cap icon-indigo"></i>
                <h3>Student Placements</h3>
                <p>Hiring success by university</p>
                <div class="report-meta">
                    <span><i class="fas fa-university"></i> By school</span>
                    <span><i class="fas fa-percent"></i> Placement rate</span>
                </div>
            </a>
            <a href="/UniQuest/admin/viewReport/ExecutiveSummary" class="report-card">
                <i class="fas fa-chart-pie icon-yellow"></i>
                <h3>Executive Summary</h3>
                <p>Comprehensive overview of all reports</p>
                <div class="report-meta">
                    <span><i class="fas fa-file-alt"></i> All metrics</span>
                    <span><i class="fas fa-calendar-alt"></i> Quarterly</span>
                </div>
            </a>
        </div>
    </main>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>