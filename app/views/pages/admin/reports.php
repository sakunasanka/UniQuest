<?php require APPROOT . '/views/components/ser_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/admin/reports.css">

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
        <!-- Report Filters -->
        <div class="report-filters">
            <h2>System Reports</h2>
            <div class="filters">
                <button class="filter-btn active" data-period="daily">Daily</button>
                <button class="filter-btn" data-period="weekly">Weekly</button>
                <button class="filter-btn" data-period="monthly">Monthly</button>
                <button class="filter-btn" data-period="yearly">Yearly</button>
                <button class="filter-btn" data-period="custom">Custom</button>
            </div>

            <!-- Date Filter Section -->
            <div class="date-filters">
                <label for="startDate">From:</label>
                <input type="date" id="startDate" />
                <label for="endDate">To:</label>
                <input type="date" id="endDate" />
                <button class="apply-btn" id="applyFiltersBtn">Apply</button>
            </div>

            <!-- Download Report Button -->
            <div class="download-btn-container">
                <button class="download-btn" id="downloadReportBtn">
                    <span class="material-symbols-outlined">file_download</span> Download Report
                </button>
            </div>
        </div>

        <!-- Report Cards -->
        <div class="reports">
            <div class="card report-card">
                <h3>New Students</h3>
                <p id="newStudentsCount">0</p>
            </div>
            <div class="card report-card">
                <h3>New Companies</h3>
                <p id="newCompaniesCount">0</p>
            </div>
            <div class="card report-card">
                <h3>Jobs Posted</h3>
                <p id="jobsPostedCount">0</p>
            </div>
            <div class="card report-card">
                <h3>Internships Posted</h3>
                <p id="internshipsPostedCount">0</p>
            </div>
            <div class="card report-card">
                <h3>Revenue Generated</h3>
                <p id="revenueGenerated">0</p>
            </div>
        </div>

        <!-- Report Charts -->
        <div class="charts">
            <div class="card chart-card">
                <canvas id="registrationsChart"></canvas>
            </div>
            <div class="card chart-card">
                <canvas id="jobListingsChart"></canvas>
            </div>
        </div>
    </main>
</div>

<script src="<?php echo URLROOT; ?>/js/admin/reports.js"></script>

<!-- Footer -->
<?php require APPROOT . '/views/components/footer.php'; ?>
