<?php require APPROOT . '/views/components/adm_header.php'; ?>
<?php require APPROOT . '/views/popups/admin/activateDeactivateJob.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <?php
        $columns = [
            "JobID" => "Job ID",
            "Title" => "Title",
            "CompanyName" => "Company Name",
            "Email" => "Company Email",
            "jobs_create_at" => "Posted Date",
            "Status" => "Status",
            "Actions" => "Actions"
        ];
        ?>
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/admin/ptjobs_mng">Part Time Jobs</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/admin/intern_mng">Interships</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
                <!-- <button class="add-btn">
                    <span class="material-symbols-outlined">add</span>
                    <span class="add-btn-text">Add Job</span>
                </button> -->
            </div>
            <table>
                <?php require APPROOT . '/views/components/adminTableheader.php'; ?>
                <tbody>
                    <?php if ($data['ptjobs']) : ?>
                        <?php foreach ($data['ptjobs'] as $job) : ?>
                            <tr>
                                <td><?php echo $job->JobID; ?></td>
                                <td><?php echo $job->Title; ?></td>
                                <td><?php echo $job->CompanyName; ?></td>
                                <td><?php echo $job->Email; ?></td>
                                <td><?php echo substr($job->jobs_create_at, 0, 10);; ?></td>
                                <?php if ($job->Status == 'Active') : ?>
                                    <td><span class="status active">Active</span></td>
                                    <td class="action">
                                        <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/admin/job_detail/<?php echo $job->JobID; ?>'">
                                            preview
                                        </span>
                                        <span class="material-symbols-outlined action-btn deactivate" onclick="deactivateJob(<?php echo $job->JobID; ?>, 'Part-time')">
                                            block
                                        </span>
                                    </td>
                                <?php elseif ($job->Status == 'Deactive') : ?>
                                    <td><span class="status inactive">Deactive</span></td>
                                    <td class="action">
                                        <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/admin/job_detail/<?php echo $job->JobID; ?>'">
                                            preview
                                        </span>
                                        <span class="material-symbols-outlined action-btn activate" onclick="activateJob(<?php echo $job->JobID; ?>, 'Part-time')">
                                            check_circle
                                        </span>
                                    </td>
                                <?php endif; ?>
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