<?php require APPROOT . '/views/components/header.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <?php
        $columns = [
            "JobTitle" => "Title",
            "CompanyName" => "Company",
            "JobLocation" => "Location",
            "SubmissionDate" => "Date",
            "Status" => "Status",
            "Actions" => "Actions"
        ];
        ?>
        <div class="header-text">
            <h1>View Application Status</h1>
            <h3>Check the status of your job application</h3>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
            </div>
            <table>
                <?php require APPROOT . '/views/components/adminTableheader.php'; ?>
                <tbody>
                    <?php if ($data['applications']) : ?>
                        <?php foreach ($data['applications'] as $application) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($application->JobTitle); ?></td>
                                <td><?php echo htmlspecialchars($application->CompanyName); ?></td>
                                <td><?php echo htmlspecialchars($application->JobLocation); ?></td>
                                <td><?php echo date('Y/m/d', strtotime($application->SubmissionDate)); ?></td>
                                <td>
                                    <?php if ($application->status == 'Accepted') : ?>
                                        <span class="status active">Accepted</span>
                                    <?php elseif ($application->status == 'Rejected') : ?>
                                        <span class="status inactive">Rejected</span>
                                    <?php else : ?>
                                        <span class="status pending">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td class="action">
                                    <a href="<?php echo URLROOT; ?>/student/view_application/<?php echo $application->ApplicationID; ?>">
                                        <span class="material-symbols-outlined action-btn view">
                                            preview
                                        </span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center">You haven't applied to any jobs yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php require APPROOT . '/views/components/pagination.php'; ?>
        </div>
        <? print_r($data); ?>
    </main>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>