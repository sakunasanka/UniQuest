<?php require APPROOT . '/views/components/header.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="header-text">
            <h1>View Application Status</h1>
            <h3>Check the status of your job application</h3>
        </div>
        <div class="table-block">
            
            <table>
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Title</th>
                        <th onclick="sortTable(1)">Company</th>
                        <th onclick="sortTable(2)">Location</th>
                        <th onclick="sortTable(3)">Date</th>
                        <th onclick="sortTable(4)">Status</th>
                        <th class="no-sort">Actions</th>
                    </tr>
                </thead>
                <tbody>
    <?php if(empty($data['applications'])) : ?>
        <tr>
            <td colspan="6" class="text-center">You haven't applied to any jobs yet.</td>
        </tr>
    <?php else : ?>
        <?php foreach($data['applications'] as $application) : ?>
            <tr>
                <td><?php echo htmlspecialchars($application->JobTitle); ?></td>
                <td><?php echo htmlspecialchars($application->CompanyName); ?></td>
                <td><?php echo htmlspecialchars($application->JobLocation); ?></td>
                <td><?php echo date('Y/m/d', strtotime($application->SubmissionDate)); ?></td>
                <td>
                    <?php if($application->ApplicationStatus == 'Accepted') : ?>
                        <span class="status active">Accepted</span>
                    <?php elseif($application->ApplicationStatus == 'Rejected') : ?>
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
    <?php endif; ?>
</tbody>
            </table>
            <?php require APPROOT . '/views/components/pagination.php'; ?>
        </div>
    </main>
</div>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSortTable.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>