<?php require APPROOT . '/views/components/ser_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/new_applications.css">

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <!-- Tabs Header -->
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/uniquest/service_provider/new_applications">New Applications</button>
            <button class="tab" data-path="/uniquest/service_provider/offered_applications">Offered Applications</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/uniquest/service_provider/rejected_applications">Rejected Applications</button>
        </div>

        <!-- Table Block -->
        <div class="table-block">
            <!-- Content Header with Search Bar -->
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
            </div>

            <!-- Applications Table -->
            <table>
                <thead>
                    <tr>
                        <th onclick="sortTable(1)">Name</th>
                        <th onclick="sortTable(2)">Email</th>
                        <th onclick="sortTable(3)">Mobile Number</th>
                        <th onclick="sortTable(5)">Date</th>
                        <th class="no-sort">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['applications'])): ?>
                        <?php foreach ($data['applications'] as $application): ?>
                            <tr>
                                <td><?php echo $application->StudentName; ?></td>
                                <td><?php echo $application->StudentEmail; ?></td>
                                <td><?php echo $application->StudentContact; ?></td>
                                <td><?php echo $application->SubmissionDate; ?></td>
                                <td class="action">
                                    <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/service_provider/view_application/<?php echo $application->ApplicationID; ?>'">
                                        preview
                                    </span>
                                    <!-- <span class="material-symbols-outlined action-btn activate">
                                        check_circle
                                    </span>
                                    <span class="material-symbols-outlined action-btn deactivate">
                                        block
                                    </span> -->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="no-applications">No applications found for this job.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php
            //  require APPROOT . '/views/components/pagination.php';
              ?>
        </div>
    </main>
</div>

<!-- Scripts -->
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSortTable.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>