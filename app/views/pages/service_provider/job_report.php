<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/job_report.css">

<?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>
<main class="content-area">
    <div id="loading-spinner" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1000;">
        <div style="background: rgba(0,0,0,0.7); color: white; padding: 20px; border-radius: 5px;">
            Generating PDF, please wait...

        </div>
    </div>
    </div>
    <div class="report-header">
        <h1>Job Posting Performance Report</h1>
        <p>Insights on the performance of your job posting.</p>
        <form id="generatePdfForm" method="POST" action="<?php echo URLROOT; ?>/report/generateJobReportPdf/<?php echo $data['job']->JobID; ?>">
            <input type="hidden" name="chart_gender" id="chart_gender">
            <input type="hidden" name="chart_age" id="chart_age">
            <input type="hidden" name="chart_university" id="chart_university">
            <button class="download-btn">
                <span class="material-symbols-outlined">download</span> Download PDF
            </button>
        </form>

    </div>
    <!-- Copy this part and above button for every report -->

    <!-- include the report -->
    <!-- Hidden content for PDF generation -->


    <div id="visible-content">
        <div class="report-date">
            <p>
                Job Post Date:
                <?php
                if (!empty($data['job']->jobs_create_at) && $data['job']->jobs_create_at !== '0000-00-00') {
                    echo date('M-d-Y', strtotime($data['job']->jobs_create_at));
                } else {
                    echo 'N/A';
                }
                ?>
            </p>

        </div>

        <section class="job-details">
            <h2>Job Details</h2>
            <div class="job-detail-cards">
                <div class="card">
                    <p>Referral ID: <?php echo $data['job']->JobID; ?></p>
                </div>
                <div class="card">
                    <p>Job Title: <?php echo $data['job']->Title; ?></p>
                </div>
                <div class="card">
                    <p>Job Location: <?php echo $data['job']->City; ?></p>
                </div>
                <div class="card">
                    <p>Total Applicants: <?php echo $data['totalApplicants']; ?></p>
                </div>
                <div class="card" id="card">
                    <p>Application Rate: <?php echo $data['applicationRate']; ?>%</p>
                </div>
            </div>
        </section>


        <?php if (!empty($data['totalApplicants'])): ?>
            <section class="applicant-demographics">
                <h2>Applicant Demographics</h2>
                <div class="demographic-grid">
                    <div class="demographic-card">
                        <canvas id="genderChart"></canvas>
                    </div>
                    <div class="demographic-card">
                        <canvas id="ageChart"></canvas>
                    </div>
                    <div class="demographic-card">
                        <canvas id="universityChart"></canvas>
                    </div>
                </div>
            </section>
        <?php else: ?>
            <section class="applicant-demographics">
                <h2>Applicant Demographics</h2>
                <p>No applicants found for this job posting.</p>
            </section>
        <?php endif; ?>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script src="<?php echo URLROOT; ?>/js/service_provider/report_charts.js"></script>
<script>
    const reportData = {
        gender: <?php echo json_encode($data['demographics']['gender']); ?>,
        age: <?php echo json_encode($data['demographics']['age']); ?>,
        location: <?php echo json_encode($data['demographics']['university']); ?>, // changed from `location`
        totalApplicants: <?php echo json_encode($data['totalApplicants']); ?>
    };
</script>
<script>
document.getElementById('generatePdfForm').addEventListener('submit', function (e) {
    const genderCanvas = document.getElementById('genderChart');
    const ageCanvas = document.getElementById('ageChart');
    const uniCanvas = document.getElementById('universityChart');

    if (genderCanvas) {
        document.getElementById('chart_gender').value = genderCanvas.toDataURL("image/png");
    }
    if (ageCanvas) {
        document.getElementById('chart_age').value = ageCanvas.toDataURL("image/png");
    }
    if (uniCanvas) {
        document.getElementById('chart_university').value = uniCanvas.toDataURL("image/png");
    }
});
</script>


<?php require APPROOT . '/views/components/footer.php'; ?>