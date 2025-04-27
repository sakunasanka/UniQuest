<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/application_table.css">

<div class="main-container">
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>

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
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/service_provider/new_applications/<?php echo $data['jobID']; ?>">Pending Applications</button>
            <button class="tab" data-path="/UniQuest/service_provider/offered_applications/<?php echo $data['jobID']; ?>">Offered Applications</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/service_provider/rejected_applications/<?php echo $data['jobID']; ?>">Rejected Applications</button>
        </div>
        <div class="job-details">
            <h2 class="job-title" onclick="goToJob(<?php echo $data['post']->JobID; ?>);">
                Job Title: <?php echo ($data['post']->Title); ?>
            </h2>
            <p>
                Location: <?php echo htmlspecialchars($data['post']->City); ?>
            </p>
            <p>
                Published On: <?php echo htmlspecialchars($data['posted']); ?>
            </p>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
            </div>
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
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="no-applications">No offered applications to show.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php require APPROOT . '/views/components/pagination.php'; ?>
        </div>
    </main>
</div>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>

<script>
    function goToJob(jobID) {
        window.location.href = '<?php echo URLROOT; ?>/jobs/jobsdescription/' + jobID;
    }
</script>