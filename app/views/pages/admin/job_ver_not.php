<?php require APPROOT . '/views/components/adm_header.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/admin/job_ver_pending">Pending</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/admin/job_ver_not">Not Approved</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
            </div>
            <table>
                <thead>
                    <tr>
                        <th onclick="sortTable(0, 'JobID')">Job ID</th>
                        <th onclick="sortTable(1, 'Title')">Title</th>
                        <th onclick="sortTable(2, 'Email')">Company Email</th>
                        <th onclick="sortTable(3, 'Category')">Job Type</th>
                        <th onclick="sortTable(4, 'jobs_create_at')">Requested Date</th>
                        <th onclick="sortTable(5, 'Status')">Status</th>
                        <th class="no-sort">View</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['jobs'] as $job) : ?>
                        <tr>
                            <td><?php echo $job->JobID; ?></td>
                            <td><?php echo $job->Title; ?></td>
                            <td><?php echo $job->Email; ?></td>
                            <td><?php echo $job->Category; ?></td>
                            <td><?php echo substr($job->jobs_create_at, 0, 10); ?></td>
                            <td><span class="status inactive">Not Approved</span></td>
                            <td class="action">
                                <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/admin/job_ver_detail/<?php echo $job->JobID; ?>'">
                                    preview
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php require APPROOT . '/views/components/pagination.php'; ?>
        </div>
    </main>
</div>

<script>
    const totalPages = <?php echo $data['totalPages']; ?>;
</script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSortTable.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>