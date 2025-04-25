<?php
// This is the job_report_pdf.php template that will be used for PDF generation
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Job Performance Report - <?= $reportData['job']->Title ?></title>
    <style>
        @page {
            margin: 100px 50px 70px 50px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #2c3e50;
            line-height: 1.6;
            margin: 0;
        }

        /* Header */
        .pdf-header {
            position: fixed;
            top: -80px;
            left: 0;
            right: 0;
            height: 80px;
            background: #fff;
            border-bottom: 1px solid #dfe6e9;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            height: 50px;
            max-width: 180px;
        }

        .header-info {
            text-align: right;
        }

        .report-title {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
        }

        .report-subtitle {
            font-size: 12px;
            color: #636e72;
            margin: 2px 0;
        }

        /* Footer */
        .pdf-footer {
            position: fixed;
            bottom: -50px;
            left: 0;
            right: 0;
            height: 50px;
            background: #fff;
            border-top: 1px solid #dfe6e9;
            padding: 10px 20px;
            font-size: 10px;
            color: #95a5a6;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            text-align: center;
        }

        .page-number::after {
            content: "Page " counter(page) " of " counter(pages);
        }

        /* Content */
        .report-content {
            margin-top: 30px;
        }

        .content-header {
            border-bottom: 1px solid #dfe6e9;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .content-title {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }

        .content-subtitle {
            font-size: 12px;
            color: #636e72;
            margin-top: 5px;
        }

        /* Job Overview Cards */
        .grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }

        .card {
            flex: 1 1 200px;
            border: 1px solid #dfe6e9;
            border-radius: 4px;
            padding: 12px;
            background-color: #fff;
        }

        .card strong {
            display: block;
            margin-bottom: 4px;
            font-size: 13px;
            font-weight: bold;
            color: #2c3e50;
        }

        /* Sections */
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .section h2 {
            font-size: 16px;
            border-bottom: 1px solid #dfe6e9;
            padding-bottom: 8px;
            margin: 0 0 15px 0;
            font-weight: bold;
        }

        .section h3 {
            font-size: 14px;
            margin: 20px 0 10px 0;
            font-weight: 500;
            color: #34495e;
        }

        /* Charts */
        .chart-container {
            border: 1px solid #dfe6e9;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            background-color: #fff;
        }

        .chart-placeholder {
            height: 100px;
            background-color: #f8f9fa;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #636e72;
            text-align: center;
            font-style: italic;
            margin-bottom: 10px;
        }

        .chart-data {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .chart-data-item {
            padding: 6px 10px;
            border: 1px solid #dfe6e9;
            border-radius: 4px;
            font-size: 11px;
            display: flex;
            align-items: center;
        }

        .chart-data-item::before {
            content: "";
            display: inline-block;
            width: 10px;
            height: 10px;
            margin-right: 8px;
            border-radius: 2px;
        }

        .male::before {
            background-color: #36a2eb;
        }

        .female::before {
            background-color: #ff6384;
        }

        .unknown::before {
            background-color: #ffcd56;
        }

        .not-specified::before {
            background-color: #95a5a6;
        }

        /* Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12px;
        }

        .data-table th,
        .data-table td {
            padding: 8px 10px;
            border: 1px solid #dfe6e9;
            text-align: left;
        }

        .data-table th {
            background-color: #f1f2f6;
            font-weight: bold;
        }

        .data-table tr:nth-child(even) {
            background-color: #fafafa;
        }

        /* Summary and Recommendations */
        .summary-content,
        .recommendations-content {
            background-color: #f8f9fa;
            border: 1px solid #dfe6e9;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .recommendations-content ol {
            padding-left: 20px;
            margin: 0;
        }

        .recommendations-content li {
            margin-bottom: 10px;
        }

        /* Utilities */
        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #95a5a6;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="pdf-header">
        <div class="logo-container">
            <div class="logo-container">
                <img src="<?= URLROOT ?>/images/UniQuest3.jpg" class="logo" alt="UniQuest Logo">
            </div>
        </div>
        <div class="header-info">
            <div class="report-title">Job Performance Report</div>
            <div class="report-subtitle"><?= $reportData['job']->Title ?></div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="report-content">
        <div class="content-header">
            <h1 class="content-title">Job Performance Report</h1>
            <p class="content-subtitle">Detailed analysis of job posting performance</p>
            <div class="report-meta">
                <span>Generated on: <?= date('F j, Y \a\t H:i') ?></span>
                <span>Job ID: <?= $reportData['job']->JobID ?></span>
            </div>
        </div>

        <!-- Job Overview -->
        <div class="section">
            <h2>Job Overview</h2>
            <div class="grid">
                <div class="card"><strong>Job Title</strong><?= $reportData['job']->Title ?></div>
                <div class="card"><strong>Location</strong><?= $reportData['job']->City ?? $reportData['job']->Location ?? 'N/A' ?></div>
                <?php
                $postDate = isset($reportData['job']->PublishDate) ? $reportData['job']->PublishDate : (isset($reportData['job']->jobs_create_at) ? $reportData['job']->jobs_create_at : (isset($reportData['job']->create_at) ? $reportData['job']->create_at : null));
                ?>
                <?php if ($postDate): ?>
                    <div class="card"><strong>Posted Date</strong><?= date('M j, Y', strtotime($postDate)) ?></div>
                <?php endif; ?>
                <div class="card"><strong>Total Applicants</strong><?= $reportData['totalApplicants'] ?></div>
                <div class="card"><strong>Application Rate</strong><?= $reportData['applicationRate'] ?>%</div>
                <?php if (isset($reportData['job']->SalaryRange)): ?>
                    <div class="card"><strong>Salary</strong><?= $reportData['job']->SalaryRange ?> LKR (<?= $reportData['job']->SalaryType ?>)</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Company Information -->
        <div class="section">
            <h2>Company Information</h2>
            <div class="grid">
                <div class="card"><strong>Company</strong><?= $reportData['job']->CompanyName ?? 'N/A' ?></div>
                <?php if (isset($reportData['job']->Industry)): ?>
                    <div class="card"><strong>Industry</strong><?= $reportData['job']->Industry ?: 'N/A' ?></div>
                <?php endif; ?>
                <?php if (isset($reportData['job']->Website)): ?>
                    <div class="card"><strong>Website</strong><?= $reportData['job']->Website ?: 'N/A' ?></div>
                <?php endif; ?>
                <?php if (isset($reportData['job']->Email)): ?>
                    <div class="card"><strong>Email</strong><?= $reportData['job']->Email ?></div>
                <?php endif; ?>
                <?php if (isset($reportData['job']->ContactNo)): ?>
                    <div class="card"><strong>Contact No</strong><?= $reportData['job']->ContactNo ?></div>
                <?php endif; ?>
                <?php if (isset($reportData['job']->CompanyAddress)): ?>
                    <div class="card"><strong>Address</strong><?= $reportData['job']->CompanyAddress ?></div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Applicant Demographics -->
        <div class="section">
            <h2>Applicant Demographics</h2>

            <?php if ($reportData['totalApplicants'] > 0): ?>
                <h3>Gender Distribution</h3>
                <div class="chart-container">
                    <div class="chart-placeholder">
                        <div>
                            <div style="font-size: 14px; font-weight: bold; margin-bottom: 5px;">Gender Breakdown</div>
                        </div>
                    </div>
                    <div class="chart-data">
                        <?php foreach ($reportData['demographics']['gender'] as $gender => $percentage): ?>
                            <?php
                            $count = round(($percentage / 100) * $reportData['totalApplicants']);
                            $class = strtolower($gender);
                            ?>
                            <div class="chart-data-item <?= $class ?>"><?= $gender ?>: <?= $count ?> (<?= $percentage ?>%)</div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <h3>Age Groups</h3>
                <?php if (!empty($reportData['demographics']['age'])): ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Age Range</th>
                                <th>Applicants</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reportData['demographics']['age'] as $range => $percentage): ?>
                                <?php $count = round(($percentage / 100) * $reportData['totalApplicants']); ?>
                                <tr>
                                    <td><?= $range ?></td>
                                    <td><?= $count ?></td>
                                    <td><?= $percentage ?>%</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-muted">No age group data available.</p>
                <?php endif; ?>

                <h3>Top Locations</h3>
                <?php if (!empty($reportData['demographics']['location'])): ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>City</th>
                                <th>Applicants</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reportData['demographics']['location'] as $city => $percentage): ?>
                                <?php $count = round(($percentage / 100) * $reportData['totalApplicants']); ?>
                                <tr>
                                    <td><?= $city ?></td>
                                    <td><?= $count ?></td>
                                    <td><?= $percentage ?>%</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-muted">No location data available.</p>
                <?php endif; ?>

                <?php if (!empty($reportData['demographics']['university'])): ?>
                    <h3>University Distribution</h3>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>University</th>
                                <th>Applicants</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reportData['demographics']['university'] as $uni => $percentage): ?>
                                <?php $count = round(($percentage / 100) * $reportData['totalApplicants']); ?>
                                <tr>
                                    <td><?= $uni ?></td>
                                    <td><?= $count ?></td>
                                    <td><?= $percentage ?>%</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            <?php else: ?>
                <p class="text-muted">No applicants found for this job posting.</p>
            <?php endif; ?>
        </div>

        <!-- Summary Analysis Section -->
        <div class="section">
            <h2>Summary Analysis</h2>
            <div class="summary-content">
                <?php
                $postDate = isset($reportData['job']->create_at) ? date('F j, Y', strtotime($reportData['job']->create_at)) : (isset($reportData['job']->PublishDate) ? date('F j, Y', strtotime($reportData['job']->PublishDate)) : (isset($reportData['job']->jobs_create_at) ? date('F j, Y', strtotime($reportData['job']->jobs_create_at)) : 'the posting date'));
                $totalApplicants = $reportData['totalApplicants'];
                $appRate = $reportData['applicationRate'];

                if ($totalApplicants <= 1) {
                    echo "<p>This job posting has received minimal engagement with only {$totalApplicants} " .
                        ($totalApplicants == 1 ? "applicant" : "applicants") . " since being posted on {$postDate}.</p>";

                    // Gender summary
                    if (!empty($reportData['demographics']['gender'])) {
                        $genderKeys = array_keys($reportData['demographics']['gender']);
                        if (count($genderKeys) == 1) {
                            echo "<p>The single applicant is {$genderKeys[0]}";
                        }
                    }

                    // Age summary
                    if (!empty($reportData['demographics']['age'])) {
                        $ageKeys = array_keys($reportData['demographics']['age']);
                        if (count($ageKeys) == 1 && isset($genderKeys) && count($genderKeys) == 1) {
                            echo ", aged " . $ageKeys[0];
                        }
                    }

                    // Location summary
                    if (!empty($reportData['demographics']['location'])) {
                        $locationKeys = array_keys($reportData['demographics']['location']);
                        if (count($locationKeys) == 1 && ((isset($genderKeys) && count($genderKeys) == 1) ||
                            (isset($ageKeys) && count($ageKeys) == 1))) {
                            echo ", and located in {$locationKeys[0]}.</p>";
                        } else if (count($locationKeys) == 1) {
                            echo "<p>The applicant is from {$locationKeys[0]}.</p>";
                        }
                    } else if ((isset($genderKeys) && count($genderKeys) == 1) ||
                        (isset($ageKeys) && count($ageKeys) == 1)
                    ) {
                        echo ".</p>";
                    }

                    echo "<p>The {$appRate}% application rate suggests potential issues with the job posting's visibility, " .
                        "appeal, or targeting. Consider reviewing the job description, requirements, and distribution channels " .
                        "to improve performance.</p>";
                } else {
                    echo "<p>This job posting has received {$totalApplicants} applicants since being posted on {$postDate}, " .
                        "with an application rate of {$appRate}%.</p>";

                    // Add more detailed analysis for multiple applicants
                    if (!empty($reportData['demographics']['gender'])) {
                        $topGender = array_keys($reportData['demographics']['gender'])[0];
                        $topGenderPercentage = $reportData['demographics']['gender'][$topGender];
                        echo "<p>The applicant pool is predominantly {$topGender} ({$topGenderPercentage}%).</p>";
                    }

                    if (!empty($reportData['demographics']['age'])) {
                        $topAge = array_keys($reportData['demographics']['age'])[0];
                        $topAgePercentage = $reportData['demographics']['age'][$topAge];
                        echo "<p>Most applicants fall within the {$topAge} age range ({$topAgePercentage}%).</p>";
                    }

                    if (!empty($reportData['demographics']['location'])) {
                        $topLocation = array_keys($reportData['demographics']['location'])[0];
                        $topLocationPercentage = $reportData['demographics']['location'][$topLocation];
                        echo "<p>The majority of applicants are from {$topLocation} ({$topLocationPercentage}%).</p>";
                    }
                }
                ?>
            </div>
        </div>

        <!-- Recommendations Section -->
        <div class="section">
            <h2>Recommendations</h2>
            <div class="recommendations-content">
                <ol>
                    <li><strong>Review Job Title and Description:</strong>
                        Ensure the job title "<?= $reportData['job']->Title ?>" is clear and descriptive of the actual position.</li>
                    <li><strong>Expand Reach:</strong>
                        Consider promoting the job posting through additional channels to increase visibility.</li>
                    <li><strong>Target Diverse Candidates:</strong>
                        Implement strategies to attract a more diverse pool of applicants across gender, age, and location.</li>
                    <li><strong>Review Application Process:</strong>
                        Ensure the application process is straightforward and user-friendly.</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="pdf-footer">
        <div>Confidential - For internal use only</div>
        <div class="page-number"></div>
        <div>© <?= date('Y') ?> UniQuest</div>
    </div>
</body>

</html>