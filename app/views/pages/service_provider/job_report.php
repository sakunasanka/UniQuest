<?php require APPROOT . '/views/components/ser_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/job_report.css">

<?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>
<main class="content-area">
    <div class="report-header">
        <h1>Job Posting Performance Report</h1>
        <p>Insights on the performance of your job posting.</p>
        <a href="<?php echo URLROOT; ?>/report/generatePdf/<?php echo $data['job']->JobID; ?>" class="download-btn">
            <span class="material-symbols-outlined">download</span> Download PDF
        </a>
    </div>

    <div class="report-date">
        <p>Job Post Date: <?php echo isset($data['job']->JobCreatedAt) ? date('M-d-Y', strtotime($data['job']->JobCreatedAt)) : 'N/A'; ?></p>
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
                <p>Job Location: <?php echo $data['job']->Location; ?></p>
            </div>
            <div class="card">
                <p>Total Applicants: <?php echo $data['totalApplicants']; ?></p>
            </div>
            <div class="card" id="card">
                <p>Application Rate: <?php echo $data['applicationRate']; ?>%</p>
            </div>
        </div>
    </section>
 


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
                <canvas id="locationChart"></canvas>
            </div>
        </div>

    </section>
    

</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script src="<?php echo URLROOT; ?>/js/service_provider/report_charts.js"></script>
<script>
    // Pass PHP data to JavaScript
    const reportData = {
        gender: <?php echo json_encode($data['demographics']['gender']); ?>,
        age: <?php echo json_encode($data['demographics']['age']); ?>,
        location: <?php echo json_encode($data['demographics']['location']); ?>
    };
      
// const reportData = {
//     gender: {"Male":58, "Female":42},
//     age: {"21":11.4, "22":11.6, "23":35.2, "24":31.7},
//     location: {"Colombo":50, "Kandy":30, "Galle":20}
// };

</script>
<?php require APPROOT . '/views/components/footer.php'; ?>