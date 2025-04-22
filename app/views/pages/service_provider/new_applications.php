<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/application_table.css">

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <?php
        $columns = [
            "StudentName" => "Name",
            "StudentEmail" => "Email",
            "StudentContact" => "Mobile Number",
            "SubmissionDate" => "Date",
            "Actions" => "Actions"
        ];
        ?>
        <!-- Tabs Header -->
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/service_provider/new_applications/<?php echo $data['jobID']; ?>">Pending Applications</button>
            <button class="tab" data-path="/UniQuest/service_provider/offered_applications/<?php echo $data['jobID']; ?>">Offered Applications</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/service_provider/rejected_applications/<?php echo $data['jobID']; ?>">Rejected Applications</button>
        </div>
        <div class="job-details">
            <h2 class="job-title" onclick="goToJob(<?php echo $data['post']->JobID; ?>);">
                Job Title: <?php echo htmlspecialchars($data['post']->Title); ?>
            </h2>
            <p>
                Location: <?php echo $data['post']->City; ?>
            </p>
            <p>
                Published On: <?php echo $data['posted']; ?>
            </p>
        </div>
        <!-- Table Block -->
        <div class="table-block">
            <!-- Content Header with Search Bar -->
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
            </div>

            <!-- Applications Table -->
            <table>
                <?php require APPROOT . '/views/components/adminTableheader.php'; ?>
                <tbody>
                    <?php if (!empty($data['applications'])): ?>
                        <?php foreach ($data['applications'] as $application): ?>
                            <tr>
                                <td><?php echo $application->StudentName; ?></td>
                                <td><?php echo $application->StudentEmail; ?></td>
                                <td><?php echo $application->StudentContact; ?></td>
                                <td><?php echo (date('Y/m/d', strtotime($application->SubmissionDate))); ?></td>
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
                            <td colspan="7" class="no-applications">No pending applications to show.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php require APPROOT . '/views/components/pagination.php'; ?>
        </div>
    </main>
</div>

<!-- Scripts -->
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>

<script>
    function goToJob(jobID) {
        window.location.href = '<?php echo URLROOT; ?>/jobs/jobsdescription/' + jobID;
    }
</script>