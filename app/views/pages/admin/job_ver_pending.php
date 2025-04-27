<?php require APPROOT . '/views/components/header.php'; ?>

<div class="main-container">
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <main class="content-area">
        <?php
        $columns = [
            "Title" => "Title",
            "Email" => "Company Email",
            "Category" => "Job Type",
            "jobs_create_at" => "Requested Date",
            "Status" => "Status",
            "Actions" => "Actions"
        ];
        ?>
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/admin/job_ver_pending">Pending</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/admin/job_ver_not">Not Approved</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
            </div>
            <table>
                <?php require APPROOT . '/views/components/adminTableheader.php'; ?>
                <tbody>
                    <?php if ($data['jobs']) : ?>
                        <?php foreach ($data['jobs'] as $job) : ?>
                            <tr>
                                <td><?php echo $job->Title; ?></td>
                                <td><?php echo $job->Email; ?></td>
                                <td><?php echo $job->Category; ?></td>
                                <td><?php echo substr($job->jobs_create_at, 0, 10); ?></td>
                                <td><span class="status pending"><?php echo $job->Status; ?></span></td>
                                <td class="action">
                                        <div class="tooltip">
                                            <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/admin/job_ver_detail/<?php echo $job->JobID; ?>'">
                                            preview
                                            </span>
                                            <span class="tooltiptext view">View</span>
                                        </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td class="no-data" colspan="6">No data available</td>
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