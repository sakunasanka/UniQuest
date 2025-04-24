<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Job Report - <?php echo $reportData['job']->Title; ?></title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #111;
            margin: 0;
            padding: 20px;
            background-color: #fff;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ccc;
        }

        .header h1 {
            font-size: 24px;
            margin: 0 0 5px 0;
            font-weight: bold;
        }

        .header p {
            font-size: 14px;
            color: #666;
            margin: 0;
        }

        .report-meta {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 11px;
            color: #888;
        }

        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .section h2 {
            font-size: 18px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 6px;
            margin: 0 0 15px 0;
            font-weight: bold;
        }

        .section h3 {
            font-size: 15px;
            margin: 20px 0 10px 0;
            font-weight: 500;
        }

        .grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .card {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            flex: 1 1 200px;
        }

        .card strong {
            display: block;
            margin-bottom: 4px;
            font-size: 13px;
            color: #000;
        }

        .chart-container {
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .chart-data {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .chart-data-item {
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 11px;
            display: flex;
            align-items: center;
            background: none;
        }

        .chart-data-item::before {
            content: "";
            display: inline-block;
            width: 10px;
            height: 10px;
            margin-right: 8px;
            border-radius: 2px;
            background-color: #aaa;
        }

        .male::before {
            background-color: #444;
        }

        .female::before {
            background-color: #777;
        }

        .unknown::before {
            background-color: #bbb;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 11px;
        }

        .data-table th,
        .data-table td {
            padding: 8px 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .data-table th {
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ccc;
            text-align: center;
            font-size: 10px;
            color: #888;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #888;
        }

        .mb-20 {
            margin-bottom: 20px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="container">

        <?php if (!empty($reportData['job']->CompanyLogo)): ?>
            <div class="text-center mb-20">
                <img src="<?php echo UPLOADROOT . '/company_logo/' . $reportData['job']->CompanyLogo; ?>" alt="Company Logo" height="60">
            </div>
        <?php endif; ?>

        <div class="header">
            <h1>Job Performance Report</h1>
            <p>Detailed analysis of job posting performance</p>
            <div class="report-meta">
                <span>Generated on: <?php echo date('F j, Y \a\t H:i'); ?></span>
                <span>Job ID: <?php echo $reportData['job']->JobID; ?></span>
            </div>
        </div>

        <div class="section">
            <h2>Job Overview</h2>
            <div class="grid">
                <div class="card"><strong>Job Title</strong><?php echo $reportData['job']->Title; ?></div>
                <div class="card"><strong>Job Location</strong><?php echo $reportData['job']->City; ?></div>
                <div class="card"><strong>Posted Date</strong><?php echo date('M j, Y', strtotime($reportData['job']->PublishDate)); ?></div>
                <div class="card"><strong>Total Applicants</strong><?php echo $reportData['totalApplicants']; ?></div>
                <div class="card"><strong>Application Rate</strong><?php echo $reportData['applicationRate']; ?>%</div>
                <div class="card"><strong>Salary</strong><?php echo $reportData['job']->SalaryRange . ' LKR (' . $reportData['job']->SalaryType . ')'; ?></div>
            </div>
        </div>

        <div class="section">
            <h2>Company Information</h2>
            <div class="grid">
                <div class="card"><strong>Company</strong><?php echo $reportData['job']->CompanyName; ?></div>
                <div class="card"><strong>Industry</strong><?php echo $reportData['job']->Industry ?: 'N/A'; ?></div>
                <div class="card"><strong>Website</strong><?php echo $reportData['job']->Website ?: 'N/A'; ?></div>
                <div class="card"><strong>Email</strong><?php echo $reportData['job']->Email; ?></div>
                <div class="card"><strong>Contact No</strong><?php echo $reportData['job']->ContactNo; ?></div>
                <div class="card"><strong>Address</strong><?php echo $reportData['job']->CompanyAddress; ?></div>
            </div>
        </div>

        <div class="section">
            <h2>Applicant Demographics</h2>

            <h3>Gender Distribution</h3>
            <div class="chart-container">
                <div class="text-center" style="height: 200px; display: flex; align-items: center; justify-content: center; background: #f1f5f9; border-radius: 4px;">
                    <div>
                        <div style="font-size: 14px; font-weight: bold; margin-bottom: 5px;">Gender Breakdown</div>
                        <div style="font-size: 12px; color: #7f8c8d;">Visual representation in web version</div>
                    </div>
                </div>
                <div class="chart-data">
                    <?php 
                    $maleCount = round(($reportData['demographics']['gender']['Male'] / 100) * $reportData['totalApplicants']);
                    $femaleCount = round(($reportData['demographics']['gender']['Female'] / 100) * $reportData['totalApplicants']);
                    $unknownCount = round(($reportData['demographics']['gender']['Unknown'] / 100) * $reportData['totalApplicants']);
                    ?>
                    <div class="chart-data-item male">Male: <?php echo $maleCount; ?> (<?php echo $reportData['demographics']['gender']['Male']; ?>%)</div>
                    <div class="chart-data-item female">Female: <?php echo $femaleCount; ?> (<?php echo $reportData['demographics']['gender']['Female']; ?>%)</div>
                    <div class="chart-data-item unknown">Unknown: <?php echo $unknownCount; ?> (<?php echo $reportData['demographics']['gender']['Unknown']; ?>%)</div>
                </div>
            </div>

            <h3>Age Groups</h3>
            <?php if (!empty($reportData['demographics']['age'])): ?>
                <table class="data-table">
                    <thead>
                        <tr><th>Age Range</th><th>Applicants</th><th>Percentage</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reportData['demographics']['age'] as $range => $percentage): ?>
                            <?php $count = round(($percentage / 100) * $reportData['totalApplicants']); ?>
                            <tr><td><?php echo $range; ?></td><td><?php echo $count; ?></td><td><?php echo $percentage; ?>%</td></tr>
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
                        <tr><th>City</th><th>Applicants</th><th>Percentage</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reportData['demographics']['location'] as $city => $percentage): ?>
                            <?php $count = round(($percentage / 100) * $reportData['totalApplicants']); ?>
                            <tr><td><?php echo $city; ?></td><td><?php echo $count; ?></td><td><?php echo $percentage; ?>%</td></tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted">No location data available.</p>
            <?php endif; ?>

            <h3>University Distribution</h3>
            <?php if (!empty($reportData['demographics']['university'])): ?>
                <table class="data-table">
                    <thead>
                        <tr><th>University</th><th>Applicants</th><th>Percentage</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reportData['demographics']['university'] as $uni => $percentage): ?>
                            <?php $count = round(($percentage / 100) * $reportData['totalApplicants']); ?>
                            <tr><td><?php echo $uni; ?></td><td><?php echo $count; ?></td><td><?php echo $percentage; ?>%</td></tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted">No university data available.</p>
            <?php endif; ?>
        </div>

        <div class="footer">
            <p>Confidential Report - &copy; <?php echo date('Y'); ?> UniQuest - Page {PAGENO}</p>
        </div>

    </div>
</body>

</html>
