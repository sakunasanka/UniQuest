<?php require APPROOT . '/views/components/adm_header.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/admin/job_complaint">Jobs</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/admin/company_complaint">Companies</button>
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
                        <th onclick="sortTable(2)">Complaint</th>
                        <th onclick="sortTable(3)">Student Name</th>
                        <th onclick="sortTable(4)">Complained Date</th>
                        <th onclick="sortTable(5)">Status</th>
                        <th class="no-sort">View</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['complaints_job'] as $complaints_job): ?>
                        <tr>
                            <td><?php echo $complaints_job->JobTitle ?></td>
                            <td><?php echo $complaints_job->CompanyEmail ?></td>
                            <td><?php echo $complaints_job->Complaint ?></td>
                            <td><?php echo $complaints_job->StudentName ?></td>
                            <td><?php echo substr($complaints_job->ComplainedDate, 0, 10) ?></td>
                            <?php if ($complaints_job->Status == 'Pending') : ?>
                                <td><span class="status pending"><?php echo $complaints_job->Status ?></span></td>
                            <?php elseif ($complaints_job->Status == 'Resolved') : ?>
                                <td><span class="status active"><?php echo $complaints_job->Status ?></span></td>
                            <?php elseif ($complaints_job->Status == 'Rejected') : ?>
                                <td><span class="status inactive"><?php echo $complaints_job->Status ?></span></td>
                            <?php endif; ?>
                            <td class="action">
                                <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/admin/complaint_detail/<?php echo $complaints_job->ComplaintID; ?>'">
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


<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSortTable.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>