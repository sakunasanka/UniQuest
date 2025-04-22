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
        <button onclick="generatePDF('report',<?php echo $data['job']->JobID; ?>)" class="download-btn">
            <span class="material-symbols-outlined">download</span> Download PDF
            
        </button>
    </div>
    <!-- Copy this part and above button for every report -->
    
<!-- include the report -->
  <!-- Hidden content for PDF generation -->
   

<div id="visible-content">
    <div class="report-date">
        <p>Job Post Date: <?php echo isset($data['job']->jobs_create_at) ? date('M-d-Y', strtotime($data['job']->jobs_create_at)) : 'N/A'; ?></p>
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
    
    </div>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script src="<?php echo URLROOT; ?>/js/service_provider/report_charts.js"></script>
<script>
    // Pass PHP data to JavaScript
    const reportData = {
        gender: <?php echo json_encode($data['demographics']['gender']); ?>,
        age: <?php echo json_encode($data['demographics']['age']); ?>,
        location: <?php echo json_encode($data['demographics']['location']); ?>,
        totalApplicants: <?php echo json_encode($data['totalApplicants']); ?>
    };
      
// const reportData = {
//     gender: {"Male":58, "Female":42},
//     age: {"21":11.4, "22":11.6, "23":35.2, "24":31.7},
//     location: {"Colombo":50, "Kandy":30, "Galle":20}
// };
function generatePDF(report_name , reportID) {
    var element = document.getElementById('visible-content');

    // Show the loading spinner
    document.getElementById('loading-spinner').style.display = 'block';

    var options = {
        margin: 0, // Adjust margin size
        filename: report_name + '_' + reportID, // Set PDF filename
        image: {
            type: 'jpeg',
            quality: 0.95
        }, // Optionally adjust image quality
        html2canvas: {
            scale: 4,
            logging: true,
            letterRendering: true
        }, // Set scale and logging for debugging
        jsPDF: {
            unit: 'mm',
            format: 'a4',
            orientation: 'portrait',
            compress: true
        } // A4 size in portrait
    };

    // Generate the PDF
    html2pdf(element, options).then(function () {
    // Hide the loading spinner when PDF generation is complete
    document.getElementById('loading-spinner').style.display = 'none';
    });
}

</script>
<?php require APPROOT . '/views/components/footer.php'; ?>