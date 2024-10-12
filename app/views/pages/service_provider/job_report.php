<?php require APPROOT . '/views/components/ser_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/job_report.css">

<?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>
<main class="content-area">
    <div class="report-header">
        <h1>Job Posting Performance Report</h1>
        <p>Insights on the performance of your job posting.</p>
        <button class="download-btn">
            <span class="material-symbols-outlined"> download </span> Download PDF
        </button>
    </div>

    <div class="report-date">
        <p>Job Post Date: Aug-08-2024</p>
    </div>

    <section class="job-details">
        <h2>Job Details</h2>
        <div class="job-detail-cards">
            <div class="card">
                <p>Referral ID: 100</p>
            </div>
            <div class="card">
                <p>Job Title: Delivery Rider</p>
            </div>
            <div class="card">
                <p>Job Location: Colombo, Sri Lanka</p>
            </div>
            <div class="card">
                <p>Total Applicants: 243</p>
            </div>
            <div class="card" id="card">
                <p>Application Rate: 18.7%</p>
            </div>
        </div>
    </section>

    <section class="applicant-demographics">
        <h2>Applicant Demographics</h2>
        <div class="demographic-grid">
            <div class="demographic-card">
                <h3>Gender</h3>
                <p>Male: 58%</p>
                <p>Female: 42%</p>
            </div>
            <div class="demographic-card">
                <h3>Age</h3>
                <p>21: 37.7%</p>
                <p>22: 22.3%</p>
                <p>23: 8.5%</p>
                <p>24: 31.3%</p>
            </div>
            <div class="demographic-card">
                <h3>Location</h3>
                <p>Galle: 38%</p>
                <p>Matara: 36%</p>
                <p>Colombo: 36%</p>
            </div>
        </div>
    </section>
</main>

<?php require APPROOT . '/views/components/footer.php'; ?>
