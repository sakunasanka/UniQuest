<!-- app/views/admin/reports/pdf_template.php -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?= $reportName ?> Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; }
        .subtitle { font-size: 12px; color: #666; margin-top: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #f2f2f2; padding: 8px; text-align: left; font-weight: bold; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .footer { text-align: center; font-size: 10px; color: #999; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title"><?= $reportName ?> Report</div>
        <div class="subtitle">Generated on <?= date('F j, Y') ?></div>
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
                        <td><?= htmlspecialchars($value) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        UniQuest Admin Report | Page {PAGE_NUM} of {PAGE_COUNT}
    </div>
</body>
</html>