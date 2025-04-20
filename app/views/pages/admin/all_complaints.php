<?php require APPROOT . '/views/components/header.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <?php
        $columns = [
            "JobTitle" => "Title",
            "CompanyEmail" => "Company Email",
            "Complaint" => "Complaint",
            "StudentName" => "Student Name",
            "ComplainedDate" => "Complained Date",
            "Status" => "Status",
            "Actions" => "Actions"
        ];
        ?>
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/admin/all_complaints">All Complaints</button>
            <button class="tab"  data-path="/UniQuest/admin/job_complaints">Complaints for Jobs</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/admin/company_complaints">Complaints for Companies</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
            </div>
            <table>
                <?php require APPROOT . '/views/components/adminTableheader.php'; ?>
                <tbody>
                    <?php if ($data['complaints_job']) : ?>
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
                                    <div class="tooltip">
                                        <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/admin/complaint_detail/<?php echo $complaints_job->ComplaintID; ?>'">
                                            preview
                                        </span>
                                        <span class="tooltiptext view">View Complaint</span>
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