<?php require APPROOT . '/views/components/adm_header.php'; ?>
<?php require APPROOT . '/views/popups/admin/activateDeactivateJob.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/admin/ptjobs_mng">Part Time Jobs</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/admin/intern_mng">Interships</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
                <!-- <button class="add-btn">
                    <span class="material-symbols-outlined">add</span>
                    <span class="add-btn-text">Add Intern</span>
                </button> -->
            </div>
            <table>
                <thead>
                <tr>
                        <th onclick="sortTable(0)">Job ID</th>
                        <th onclick="sortTable(1)">Title</th>
                        <th onclick="sortTable(2)">Company Name</th>
                        <th onclick="sortTable(3)">Company Email</th>
                        <th onclick="sortTable(4)">Posted Date</th>
                        <th onclick="sortTable(5)">Status</th>
                        <th class="no-sort">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['interns'] as $job) : ?>
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
                                    <span class="material-symbols-outlined action-btn deactivate" onclick="deactivateJob(<?php echo $job->JobID; ?>, 'Internship')">
                                        block
                                    </span>
                                </td>
                            <?php elseif ($job->Status == 'Deactive') : ?>
                                <td><span class="status inactive">Deactive</span></td>
                                <td class="action">
                                    <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/admin/job_detail/<?php echo $job->JobID; ?>'">
                                        preview
                                    </span>
                                    <span class="material-symbols-outlined action-btn activate" onclick="activateJob(<?php echo $job->JobID; ?>, 'Internship')">
                                        check_circle
                                    </span>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php require APPROOT . '/views/components/pagination.php'; ?>
        </div>
    </main>
</div>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSortTable.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>