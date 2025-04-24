
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/job_report.css">


<main class="content-area">
    <div class="report-header">
        <h1>Job Posting Performance Report</h1>
        <p>Insights on the performance of your job posting.</p>
        
    </div>

    <div class="report-date">
        <p><strong>Job Post Date:</strong> <?php echo isset($data['job']->create_at) ? date('M-d-Y', strtotime($data['job']->create_at)) : 'N/A'; ?></p>
    </div>

    <section class="job-details">
        <h2>Job Details</h2>
        <div class="job-detail-cards">
            <div class="card">
                <p><strong>Referral ID:</strong> <?php echo $data['job']->JobID; ?></p>
            </div>
            <div class="card">
                <p><strong>Job Title:</strong> <?php echo $data['job']->Title; ?></p>
            </div>
            <div class="card">
                <p><strong>Job Location:</strong> <?php echo $data['job']->Location; ?></p>
            </div>
            <div class="card">
                <p><strong>Total Applicants:</strong> <?php echo $data['totalApplicants']; ?></p>
            </div>
            <div class="card">
                <p><strong>Application Rate:</strong> <?php echo $data['applicationRate']; ?>%</p>
            </div>
        </div>
    </section>

    <section class="applicant-demographics">
        <h2>Applicant Demographics</h2>
        <div class="demographic-grid">
            <div class="demographic-card">
                <h3>Gender Distribution</h3>
                <div class="chart-container">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
            <div class="demographic-card">
                <h3>Age Distribution</h3>
                <div class="chart-container">
                    <canvas id="ageChart"></canvas>
                </div>
            </div>
            <div class="demographic-card">
                <h3>Location Distribution</h3>
                <div class="chart-container">
                    <canvas id="locationChart"></canvas>
                </div>
            </div>
        </div>
    </section>

    <!-- Summary Analysis Section -->
    <section class="summary-analysis">
        <h2>Summary Analysis</h2>
        <div class="summary-content">
            <?php 
            $postDate = isset($data['job']->create_at) ? date('F j, Y', strtotime($data['job']->create_at)) : 'the posting date';
            $totalApplicants = $data['totalApplicants'];
            $appRate = $data['applicationRate'];
            
            if ($totalApplicants <= 1) {
                echo "<p>This job posting has received minimal engagement with only {$totalApplicants} " . 
                     ($totalApplicants == 1 ? "applicant" : "applicants") . " since being posted on {$postDate}.</p>";
                
                // Gender summary
                if (!empty($data['demographics']['gender'])) {
                    $genderKeys = array_keys($data['demographics']['gender']);
                    if (count($genderKeys) == 1) {
                        echo "<p>The single applicant is {$genderKeys[0]}";
                    }
                }
                
                // Age summary
                if (!empty($data['demographics']['age'])) {
                    $ageKeys = array_keys($data['demographics']['age']);
                    if (count($ageKeys) == 1 && isset($genderKeys) && count($genderKeys) == 1) {
                        echo ", aged " . $ageKeys[0];
                    }
                }
                
                // Location summary
                if (!empty($data['demographics']['location'])) {
                    $locationKeys = array_keys($data['demographics']['location']);
                    if (count($locationKeys) == 1 && ((isset($genderKeys) && count($genderKeys) == 1) || 
                                                     (isset($ageKeys) && count($ageKeys) == 1))) {
                        echo ", and located in {$locationKeys[0]}.</p>";
                    } else if (count($locationKeys) == 1) {
                        echo "<p>The applicant is from {$locationKeys[0]}.</p>";
                    }
                } else if ((isset($genderKeys) && count($genderKeys) == 1) || 
                          (isset($ageKeys) && count($ageKeys) == 1)) {
                    echo ".</p>";
                }
                
                echo "<p>The {$appRate}% application rate suggests potential issues with the job posting's visibility, " .
                     "appeal, or targeting. Consider reviewing the job description, requirements, and distribution channels " .
                     "to improve performance.</p>";
            } else {
                echo "<p>This job posting has received {$totalApplicants} applicants since being posted on {$postDate}, " .
                     "with an application rate of {$appRate}%.</p>";
                
                // Add more detailed analysis for multiple applicants
                echo "<p>Review the demographic charts to understand the characteristics of your applicant pool " .
                     "and consider adjusting your job posting strategy to improve reach and engagement.</p>";
            }
            ?>
        </div>
    </section>

    <!-- Recommendations Section -->
    <section class="recommendations">
        <h2>Recommendations</h2>
        <div class="recommendations-content">
            <ol>
                <li><strong>Review Job Title and Description:</strong> 
                    Ensure the job title "<?php echo $data['job']->Title; ?>" is clear and descriptive of the actual position.</li>
                <li><strong>Expand Reach:</strong> 
                    Consider promoting the job posting through additional channels to increase visibility.</li>
                <li><strong>Target Diverse Candidates:</strong> 
                    Implement strategies to attract a more diverse pool of applicants across gender, age, and location.</li>
                <li><strong>Review Application Process:</strong> 
                    Ensure the application process is straightforward and user-friendly.</li>
            </ol>
        </div>
    </section>

    <div class="report-footer">
        <p>Report generated on <?php echo date('F j, Y'); ?></p>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Pass PHP data to JavaScript
    const reportData = {
        gender: <?php echo json_encode($data['demographics']['gender'] ?? []); ?>,
        age: <?php echo json_encode($data['demographics']['age'] ?? []); ?>,
        location: <?php echo json_encode($data['demographics']['location'] ?? []); ?>,
        totalApplicants: <?php echo json_encode($data['totalApplicants'] ?? 0); ?>
    };
</script>
<script src="<?php echo URLROOT; ?>/js/service_provider/report_charts.js"></script>

