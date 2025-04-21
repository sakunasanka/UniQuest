<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/admin/reports.css">

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <!-- <h1 class="report-title">System Reports</h1>
        <p class="report-subtitle">Select a report to view detailed analytics</p> -->

        <div class="report-container">
            <!-- System Reports -->
            <a href="/UniQuest/admin/viewReport/SystemHealth" class="report-card">
                <i class="fas fa-heartbeat icon-red"></i>
                <h3>System Health</h3>
                <p>Overview of platform metrics and performance</p>
                <div class="report-meta">
                    <span><i class="fas fa-history"></i> Updated hourly</span>
                    <span><i class="fas fa-chart-line"></i> 15 metrics</span>
                </div>
            </a>

            <!-- User Reports -->
            <a href="/UniQuest/admin/viewReport/UserGrowth" class="report-card">
                <i class="fas fa-users icon-blue"></i>
                <h3>User Growth</h3>
                <p>Registration trends and verification status</p>
                <div class="report-meta">
                    <span><i class="fas fa-calendar"></i> Monthly trends</span>
                    <span><i class="fas fa-user-tag"></i> By role</span>
                </div>
            </a>

            <!-- Job Reports -->
            <a href="/UniQuest/admin/viewReport/JobPerformance" class="report-card">
                <i class="fas fa-briefcase icon-purple"></i>
                <h3>Job Performance</h3>
                <p>Posting activity and application rates</p>
                <div class="report-meta">
                    <span><i class="fas fa-filter"></i> By category</span>
                    <span><i class="fas fa-percentage"></i> Hire rates</span>
                </div>
            </a>

            <!-- Financial Reports -->
            <a href="/UniQuest/admin/viewReport/Revenue" class="report-card">
                <i class="fas fa-money-bill-wave icon-green"></i>
                <h3>Revenue Analytics</h3>
                <p>Subscription plans and payment status</p>
                <div class="report-meta">
                    <span><i class="fas fa-star"></i> Plan types</span>
                    <span><i class="fas fa-clock"></i> Retention</span>
                </div>
            </a>

            <!-- Complaint Reports -->
            <a href="/UniQuest/admin/viewReport/Complaint" class="report-card">
                <i class="fas fa-exclamation-triangle icon-orange"></i>
                <h3>Complaint Analysis</h3>
                <p>Resolution times and frequent issues</p>
                <div class="report-meta">
                    <span><i class="fas fa-stopwatch"></i> Resolution time</span>
                    <span><i class="fas fa-building"></i> By company</span>
                </div>
            </a>

            <!-- Verification Reports -->
            <a href="/UniQuest/admin/viewReport/VerificationPerformance" class="report-card">
                <i class="fas fa-user-check icon-teal"></i>
                <h3>Verification Activity</h3>
                <p>Team performance and processing times</p>
                <div class="report-meta">
                    <span><i class="fas fa-users-cog"></i> By staff</span>
                    <span><i class="fas fa-hourglass-half"></i> Speed</span>
                </div>
            </a>

            <!-- Placement Reports -->
            <a href="/UniQuest/admin/viewReport/StudentPlacement" class="report-card">
                <i class="fas fa-graduation-cap icon-indigo"></i>
                <h3>Student Placements</h3>
                <p>Hiring success by university</p>
                <div class="report-meta">
                    <span><i class="fas fa-university"></i> By school</span>
                    <span><i class="fas fa-percent"></i> Placement rate</span>
                </div>
            </a>

            <!-- Engagement Reports -->
            <a href="/UniQuest/admin/viewReport/BookmarkAnalysis" class="report-card">
                <i class="fas fa-bookmark icon-pink"></i>
                <h3>User Engagement</h3>
                <p>Bookmarking behavior and favorites</p>
                <div class="report-meta">
                    <span><i class="fas fa-bookmark"></i> Bookmarks</span>
                    <span><i class="fas fa-eye"></i> Popular items</span>
                </div>
            </a>
        </div>
    </main>
</div>

<!-- Footer -->
<?php require APPROOT . '/views/components/footer.php'; ?>