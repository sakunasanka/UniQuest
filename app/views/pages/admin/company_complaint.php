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
                        <th onclick="sortTable(0)">Company</th>
                        <th onclick="sortTable(1)">Company Email</th>
                        <th onclick="sortTable(2)">No of complaints</th>
                        <th onclick="sortTable(3)">Most recent complaint date</th>
                        <th class="no-sort">View</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['complaints_com'] as $complaint) : ?>
                        <tr>
                            <td><?php echo $complaint->CompanyName; ?></td>
                            <td><?php echo $complaint->CompanyEmail; ?></td>
                            <td><?php echo $complaint->ComplaintCount; ?></td>
                            <td><?php echo $complaint->LastComplainedDate; ?></td>
                            <td class="action">
                                <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/admin/complaint_company/<?php echo $complaint->CompanyID; ?>'">
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

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSortTable.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>