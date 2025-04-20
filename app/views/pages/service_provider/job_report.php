<?php require APPROOT . '/views/components/ser_header.php'; ?>
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
  <div id="pdf-content" style="display: none;">
        <?php require_once APPROOT . '/reports/job_report.php'; ?>
    </div>  

<div id="visible-content">
    <div class="report-date">
        <p>Job Post Date: <?php echo isset($data['job']->create_at) ? date('M-d-Y', strtotime($data['job']->create_at)) : 'N/A'; ?></p>
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
function generatePDF(report_name, reportID) {
        // Create a clone of the report content for the PDF
        var element = document.getElementById('report-content');
        
        // Show the loading spinner
        document.getElementById('loading-spinner').style.display = 'block';
        
        // Add charts to the PDF content
        setTimeout(function() {
            // We need to render charts in the hidden PDF element
            const pdfGenderChart = new Chart(
                element.querySelector('#genderChart').getContext('2d'), 
                createChartConfig('gender', 'Gender Distribution')
            );
            
            const pdfAgeChart = new Chart(
                element.querySelector('#ageChart').getContext('2d'), 
                createChartConfig('age', 'Age Distribution')
            );
            
            const pdfLocationChart = new Chart(
                element.querySelector('#locationChart').getContext('2d'), 
                createChartConfig('location', 'Location Distribution')
            );
            
            // Generate PDF after charts are rendered
            setTimeout(function() {
                var options = {
                    margin: 10,
                    filename: report_name + '_' + reportID + '.pdf',
                    image: { type: 'jpeg', quality: 0.95 },
                    html2canvas: { scale: 2, logging: false, letterRendering: true },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait', compress: true }
                };
                
                // Generate the PDF
                html2pdf().from(element).set(options).save().then(function() {
                    // Hide the loading spinner when PDF generation is complete
                    document.getElementById('loading-spinner').style.display = 'none';
                    
                    // Destroy the temporary charts
                    pdfGenderChart.destroy();
                    pdfAgeChart.destroy();
                    pdfLocationChart.destroy();
                });
            }, 500);
        }, 500);
    }
    
    // Helper function to create chart configuration
    function createChartConfig(type, title) {
        const data = processChartData(type);
        
        return {
            type: 'pie',
            data: {
                labels: data.labels,
                datasets: [{
                    data: data.values,
                    backgroundColor: getColors(type),
                    borderColor: '#ffffff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'bottom' },
                    title: { 
                        display: true,
                        text: title,
                        font: { size: 16 }
                    },
                    datalabels: {
                        formatter: (value, ctx) => {
                            const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                            return total > 0 ? `${((value / total) * 100).toFixed(1)}%` : '0%';
                        },
                        color: '#fff',
                        font: { size: 11, weight: 'bold' }
                    }
                }
            }
        };
    }
    
    // Process data based on type
    function processChartData(type) {
        const rawData = reportData[type];
        let labels = [];
        let values = [];
        
        if (type === 'gender') {
            labels = Object.keys(rawData);
            values = Object.values(rawData);
        } else if (type === 'age') {
            const ranges = {
                '18-21': 0, '22-25': 0, '26-30': 0, 
                '31-35': 0, '36+': 0
            };
            
            Object.entries(rawData).forEach(([age, percent]) => {
                const ageNum = parseInt(age);
                if (ageNum <= 21) ranges['18-21'] += percent;
                else if (ageNum <= 25) ranges['22-25'] += percent;
                else if (ageNum <= 30) ranges['26-30'] += percent;
                else if (ageNum <= 35) ranges['31-35'] += percent;
                else ranges['36+'] += percent;
            });
            
            Object.entries(ranges).forEach(([range, percent]) => {
                if (percent > 0) {
                    labels.push(range);
                    values.push(percent);
                }
            });
        } else if (type === 'location') {
            const sorted = Object.entries(rawData)
                .map(([city, percent]) => ({ city, percent }))
                .sort((a, b) => b.percent - a.percent);
            
            const top3 = sorted.slice(0, 3);
            const other = sorted.slice(3).reduce((sum, loc) => sum + loc.percent, 0);
            
            labels = top3.map(loc => loc.city);
            values = top3.map(loc => loc.percent);
            
            if (other > 0) {
                labels.push('Other');
                values.push(other);
            }
        }
        
        return { labels, values };
    }
    
    // Get color schemes for charts
    function getColors(type) {
        const colorSets = {
            gender: ['#2f2d92', '#e89611', '#17616e'],
            age: ['#2f2d92', '#e89611', '#17616e', '#e36c14', '#666667'],
            location: ['#2f2d92', '#e89611', '#17616e', '#e36c14', '#666667']
        };
        
        return colorSets[type] || colorSets.gender;
    }

</script>
<?php require APPROOT . '/views/components/footer.php'; ?>