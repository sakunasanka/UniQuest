<?php require APPROOT . '/views/components/ver_header.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/verificationTeamSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/verification_team/user_verified">Users</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/verification_team/job_verified">Jobs</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
            </div>
            <table>
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Title</th>
                        <th onclick="sortTable(1)">Company Email</th>
                        <th onclick="sortTable(2)">Job Type</th>
                        <th onclick="sortTable(3)">Verified Date</th>
                        <th onclick="sortTable(4)">Status</th>
                        <th class="no-sort">View</th>
                    </tr>
                </thead>
                <?php foreach ($data['jobs'] as $job) : ?>
                    <tr>
                        <td><?php echo $job->Title; ?></td>
                        <td><?php echo $job->Email; ?></td>
                        <td><?php echo $job->Category; ?></td>
                        <td><?php echo substr($job->ActionDate, 0, 10); ?></td>
                        <?php if ($job->Status == 'Active') : ?>
                            <td><span class="status active">Active</span></td>
                        <?php elseif ($job->Status == 'Deactive') : ?>
                            <td><span class="status inactive">Deactive</span></td>
                        <?php endif; ?>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/verification_team/job_detail/<?php echo $job->JobID; ?>'">
                                preview
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php require APPROOT . '/views/components/pagination.php'; ?>
        </div>
    </main>
</div>

<!-- Footer -->


<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSortTable.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>