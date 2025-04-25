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
            size: A4 portrait;
            margin: 120px 30px 80px 30px;

            /* top, right, bottom, left */
            @bottom-right {
                content: "Page " counter(page) " of " counter(pages);
                font-size: 8pt;
                color: #999;
            }
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            background-color: #ffffff;
            color: #2c3e50;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        /* Header */
        .pdf-header {
            position: fixed;
            top: -100px;
            left: 0;
            right: 0;
            height: 80px;
            background: #ffffff;
            border-bottom: 1px solid #ecf0f1;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            height: 45px;
            max-width: 160px;
        }

        .header-info {
            text-align: right;
        }

        .report-title {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            color: #2c3e50;
        }

        .report-subtitle {
            font-size: 11px;
            color: #7f8c8d;
            margin: 2px 0;
        }

        /* Footer */
        .pdf-footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            height: 50px;
            background: #ffffff;
            border-top: 1px solid #ecf0f1;
            padding: 10px 20px;
            font-size: 9.5px;
            color: #95a5a6;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            text-align: center;
        }

        /* Content */
        .report-content {
            padding: 0 10px;
        }

        .content-header {
            border-bottom: 1px solid #ecf0f1;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .content-title {
            font-size: 20px;
            font-weight: bold;
            margin: 0 0 4px 0;
            color: #2c3e50;
            text-align: center;
        }

        .content-subtitle {
            font-size: 10px;
            color: #7f8c8d;
            margin: 0;
            text-align: center;
        }

        /* Overview Cards */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 8px;
            margin-bottom: 20px;
        }

        .card {
            background-color: #fcfcfc;
            border-radius: 8px;
            box-shadow: none;
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 10.5px;
            word-break: break-word;
        }

        .card strong {
            display: block;
            margin-bottom: 4px;
            font-size: 11px;
            font-weight: bold;
            color: #2c3e50;
        }

        /* Sections */
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .section h2 {
            font-size: 15px;
            border-bottom: 1px solid #ecf0f1;
            padding-bottom: 6px;
            margin: 0 0 16px 0;
            font-weight: 600;
            color: #2c3e50;
            page-break-after: avoid;
        }

        .section h3 {
            font-size: 13px;
            margin: 20px 0 10px 0;
            font-weight: 500;
            color: #34495e;
        }

        /* Charts */
        .chart-container {
            background-color: #fcfcfc;
            border-radius: 8px;
            box-shadow: none;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            font-size: 10.5px;
        }

        .chart-data {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 10px;
        }

        .chart-data-item {
            padding: 5px 8px;
            border-radius: 4px;
            font-size: 10px;
            display: flex;
            align-items: center;
            background-color: #f8f9fa;
            border: 1px solid #ecf0f1;
        }

        .chart-data-item::before {
            content: "";
            display: inline-block;
            width: 9px;
            height: 9px;
            margin-right: 6px;
            border-radius: 2px;
        }

        .male::before {
            background-color: #3498db;
        }

        .female::before {
            background-color: #e74c3c;
        }

        .unknown::before {
            background-color: #f39c12;
        }

        /* Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10.5px;
            border-radius: 6px;
            overflow: hidden;
        }

        .data-table th,
        .data-table td {
            padding: 7px 10px;
            border: 1px solid #ecf0f1;
            text-align: left;
        }

        .data-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
        }

        .data-table tr:nth-child(even) {
            background-color: #fafafa;
        }

        /* Summary and Recommendations */
        .summary-content,
        .recommendations-content {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            font-size: 10.5px;
        }

        .recommendations-content ol {
            padding-left: 18px;
            margin: 0;
        }

        .recommendations-content li {
            margin-bottom: 8px;
        }

        /* Report Meta */
        .report-meta {
            display: flex;
            justify-content: space-between;
            font-size: 9.5px;
            color: #95a5a6;
            border-top: 1px solid #ecf0f1;
            padding-top: 10px;
            margin-top: 10px;
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

        .break-before {
            page-break-before: always;
        }
    </style>

</head>

<body>
    <!-- Header -->
    <div class="pdf-header">
        <div class="logo-container">
            <img src="<?= URLROOT ?>/images/UniQuest3.jpg" class="logo" alt="UniQuest Logo">
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
                <div class="card">
                    <strong>Job Title</strong>
                    <?= $reportData['job']->Title ?>
                </div>
                <div class="card">
                    <strong>Location</strong>
                    <?= $reportData['job']->City ?>, <?= $reportData['job']->District ?>
                </div>
                <div class="card">
                    <strong>Posted Date</strong>
                    <?= date('M j, Y', strtotime($reportData['job']->PublishDate)) ?>
                </div>
                <div class="card">
                    <strong>Total Applicants</strong>
                    <?= $reportData['totalApplicants'] ?>
                </div>
                <div class="card">
                    <strong>Application Rate</strong>
                    <?= $reportData['applicationRate'] ?>%
                </div>
                <div class="card">
                    <strong>Salary</strong>
                    <?= number_format($reportData['job']->SalaryRange, 2) ?> LKR (<?= $reportData['job']->SalaryType ?>)
                </div>
                <div class="card">
                    <strong>Job Type</strong>
                    <?= $reportData['job']->Category ?>
                </div>
                <div class="card">
                    <strong>Status</strong>
                    <?= $reportData['job']->Status ?>
                </div>
            </div>
        </div>

        <!-- Company Information -->
        <div class="section">
            <h2>Company Information</h2>
            <div class="grid">
                <div class="card">
                    <strong>Company</strong>
                    <?= $reportData['job']->CompanyName ?>
                </div>
                <div class="card">
                    <strong>Industry</strong>
                    <?= $reportData['job']->Industry ?>
                </div>
                <div class="card">
                    <strong>Website</strong>
                    <?= $reportData['job']->Website ?>
                </div>
                <div class="card">
                    <strong>Email</strong>
                    <?= $reportData['job']->Email ?>
                </div>
                <div class="card">
                    <strong>Contact No</strong>
                    <?= $reportData['job']->ContactNo ?>
                </div>
                <div class="card">
                    <strong>Address</strong>
                    <?= $reportData['job']->CompanyAddress ?>
                </div>
                <?php if ($reportData['job']->Facebook): ?>
                    <div class="card">
                        <strong>Facebook</strong>
                        <?= $reportData['job']->Facebook ?>
                    </div>
                <?php endif; ?>
                <?php if ($reportData['job']->LinkedIn): ?>
                    <div class="card">
                        <strong>LinkedIn</strong>
                        <?= $reportData['job']->LinkedIn ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Job Details -->
        <div class="section">
            <h2>Job Details</h2>
            <div class="grid">
                <?php if ($reportData['job']->RequiredQualifications): ?>
                    <div class="card" style="grid-column: 1 / -1;">
                        <strong>Required Qualifications</strong>
                        <?= $reportData['job']->RequiredQualifications ?>
                    </div>
                <?php endif; ?>
                <?php if ($reportData['job']->JobBenefits): ?>
                    <div class="card" style="grid-column: 1 / -1;">
                        <strong>Job Benefits</strong>
                        <?= $reportData['job']->JobBenefits ?>
                    </div>
                <?php endif; ?>
                <?php if ($reportData['job']->Description): ?>
                    <div class="card" style="grid-column: 1 / -1;">
                        <strong>Description</strong>
                        <?= $reportData['job']->Description ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Applicant Demographics -->
        <div class="section">
            <h2>Applicant Demographics</h2>

            <?php if ($reportData['totalApplicants'] > 0): ?>
                <!-- Gender Distribution -->
                <h3>Gender Distribution</h3>
                <div class="chart-container">
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

                <!-- Age Distribution -->
                <h3>Age Distribution</h3>
                <div class="chart-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Age</th>
                                <th>Applicants</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reportData['demographics']['age'] as $age => $percentage): ?>
                                <?php $count = round(($percentage / 100) * $reportData['totalApplicants']); ?>
                                <tr>
                                    <td><?= $age ?></td>
                                    <td><?= $count ?></td>
                                    <td><?= $percentage ?>%</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- University Distribution -->
                <h3>University Distribution</h3>
                <div class="chart-container">
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
                </div>
            <?php else: ?>
                <div class="chart-container">
                    <p class="text-muted">No applicants found for this job posting.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Summary Analysis Section -->
        <div class="section">
            <h2>Summary Analysis</h2>
            <div class="summary-content">
                <?php
                $postDate = date('F j, Y', strtotime($reportData['job']->PublishDate));
                $totalApplicants = $reportData['totalApplicants'];
                $appRate = $reportData['applicationRate'];

                echo "<p>The job posting for <strong>{$reportData['job']->Title}</strong> at <strong>{$reportData['job']->CompanyName}</strong> ";
                echo "has received <strong>{$totalApplicants}</strong> " . ($totalApplicants == 1 ? "applicant" : "applicants") . " ";
                echo "since being posted on <strong>{$postDate}</strong>, with an application rate of <strong>{$appRate}%</strong>.</p>";

                // Gender analysis
                if (!empty($reportData['demographics']['gender'])) {
                    $genderData = $reportData['demographics']['gender'];
                    echo "<p>The applicant pool shows a balanced gender distribution with ";
                    $genderParts = [];
                    foreach ($genderData as $gender => $percentage) {
                        if ($percentage > 0) {
                            $genderParts[] = "{$percentage}% {$gender}";
                        }
                    }
                    echo implode(" and ", $genderParts) . " applicants.</p>";
                }

                // Age analysis
                if (!empty($reportData['demographics']['age'])) {
                    $ages = array_keys($reportData['demographics']['age']);
                    if (count($ages) > 0) {
                        echo "<p>Applicants are primarily in the age range of " . implode(" and ", $ages) . " years old.</p>";
                    }
                }

                // University analysis
                if (!empty($reportData['demographics']['university'])) {
                    $universities = array_keys($reportData['demographics']['university']);
                    if (count($universities) > 0) {
                        echo "<p>The applicants come from top universities including " . implode(" and ", $universities) . ".</p>";
                    }
                }

                // Final assessment
                if ($totalApplicants > 0) {
                    if ($appRate < 5) {
                        echo "<p>The relatively low application rate suggests there may be opportunities to improve the job posting's visibility or attractiveness to potential candidates.</p>";
                    } else {
                        echo "<p>The application rate indicates healthy interest in this position.</p>";
                    }
                } else {
                    echo "<p>Consider reviewing the job requirements, salary, or promotion strategy as the posting hasn't attracted applicants yet.</p>";
                }
                ?>
            </div>
        </div>

        <!-- Recommendations Section -->
        <div class="section">
            <h2>Recommendations</h2>
            <div class="recommendations-content">
                <ol>
                    <li><strong>Optimize Job Title:</strong>
                        Consider adding keywords to the title "<?= $reportData['job']->Title ?>" to improve search visibility while keeping it clear and concise.</li>

                    <li><strong>Enhance Job Description:</strong>
                        <?php if (empty($reportData['job']->Description)): ?>
                            Add a detailed job description highlighting responsibilities, required skills, and growth opportunities.
                        <?php else: ?>
                            Review the description to ensure it clearly communicates expectations and appeals to the target candidates.
                        <?php endif; ?>
                    </li>

                    <li><strong>Promote on Additional Channels:</strong>
                        Share the posting on professional networks, university career centers, and relevant online communities.</li>

                    <li><strong>Targeted Outreach:</strong>
                        Based on the demographic data, focus outreach efforts on platforms popular with the current applicant demographic.</li>

                    <li><strong>Review Application Process:</strong>
                        Ensure the application process is mobile-friendly and doesn't have unnecessary barriers.</li>

                    <?php if ($reportData['totalApplicants'] > 0): ?>
                        <li><strong>Leverage Successful Channels:</strong>
                            Analyze which channels brought the current applicants and double down on those.</li>
                    <?php endif; ?>
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