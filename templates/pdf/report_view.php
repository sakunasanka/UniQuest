<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $reportName ?> Report</title>
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
            background: #ffffff;
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
            margin-bottom: 3px;
        }

        .report-subtitle {
            font-size: 12px;
            color: #636e72;
        }

        /* Footer */
        .pdf-footer {
            position: fixed;
            bottom: -50px;
            left: 0;
            right: 0;
            height: 50px;
            background: #ffffff;
            border-top: 1px solid #dfe6e9;
            padding: 10px 20px;
            font-size: 10px;
            color: #95a5a6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-number:after {
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
            margin: 0 0 5px 0;
        }

        .content-subtitle {
            font-size: 12px;
            color: #636e72;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 12px;
        }

        thead th {
            background-color: #f1f2f6;
            padding: 10px 8px;
            text-align: left;
            border-bottom: 2px solid #dcdde1;
        }

        tbody td {
            padding: 8px;
            border-bottom: 1px solid #ecf0f1;
            vertical-align: top;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        /* Utilities */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="pdf-header">
        <div class="logo-container">
            <img src="<?= URLROOT ?>/images/UniQuest3.jpg" class="logo" alt="UniQuest Logo">
        </div>
        <div class="header-info">
            <div class="report-title">UniQuest Reports</div>
            <div class="report-subtitle">Administrative Dashboard</div>
            <div class="report-subtitle"><?= date('F j, Y') ?> | <?= date('H:i') ?></div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="report-content">
        <div class="content-header">
            <h1 class="content-title"><?= $reportName ?> Report</h1>
            <p class="content-subtitle">Generated on <?= date('F j, Y \a\t H:i') ?></p>
        </div>

        <table>
            <thead>
                <tr>
                    <?php if (!empty($reportData)): ?>
                        <?php foreach (array_keys((array)$reportData[0]) as $column): ?>
                            <th><?= ucwords(str_replace('_', ' ', $column)) ?></th>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reportData as $row): ?>
                    <tr>
                        <?php foreach ((array)$row as $value): ?>
                            <td><?= !empty($value) ? htmlspecialchars($value) : 'N/A' ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="pdf-footer">
        <div>Confidential - For internal use only</div>
        <div class="page-number"></div>
        <div>© <?= date('Y') ?> UniQuest</div>
    </div>
</body>
</html>