<?php require APPROOT . '/views/components/header.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <?php
        $columns = [
            "CompanyID" => "CompanyID",
            "CompanyName" => "Company Name",
            "Email" => "Company Email",
            "ComplaintCount" => "No of complaints",
            "LastComplainedDate" => "Most recent complaint date",
            "Actions" => "Actions"
        ];
        ?>
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/admin/job_complaint">Jobs</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/admin/company_complaint">Companies</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
            </div>
            <table>
                <?php require APPROOT . '/views/components/adminTableheader.php'; ?>
                <tbody>
                    <?php if ($data['complaints_com']) : ?>
                        <?php foreach ($data['complaints_com'] as $complaint) : ?>
                            <tr>
                                <td><?php echo $complaint->CompanyID; ?></td>
                                <td><?php echo $complaint->CompanyName; ?></td>
                                <td><?php echo $complaint->CompanyEmail; ?></td>
                                <td><?php echo $complaint->ComplaintCount; ?></td>
                                <td><?php echo substr($complaint->LastComplainedDate, 0, 10); ?></td>
                                <td class="action">
                                    <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/admin/complaint_company/<?php echo $complaint->CompanyID; ?>'">
                                        preview
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td class="no-data" colspan="6">No data available</td>
                        </tr>
                    <?php endif; ?>
            </table>
            <?php require APPROOT . '/views/components/pagination.php'; ?>
        </div>
    </main>
</div>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>