<?php require APPROOT . '/views/components/adm_header.php'; ?>

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
        <div class="content-header">
            <button class="back-btn" onclick="window.location.href='<?php echo URLROOT; ?>/admin/company_complaint'">
                <span class="material-symbols-outlined">arrow_back_ios</span>
                <h1>Complaint Management</h1>
            </button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
            </div>
            <table>
                <?php require APPROOT . '/views/components/adminTableheader.php'; ?>
                <tbody>
                    <?php if ($data['complaints']) : ?>
                        <?php foreach ($data['complaints'] as $complaint): ?>
                            <tr>
                                <td><?php echo $complaint->JobTitle ?></td>
                                <td><?php echo $complaint->CompanyEmail ?></td>
                                <td><?php echo $complaint->Complaint ?></td>
                                <td><?php echo $complaint->StudentName ?></td>
                                <td><?php echo substr($complaint->ComplainedDate, 0, 10); ?></td>
                                <?php if ($complaint->Status == 'Pending') : ?>
                                    <td><span class="status pending"><?php echo $complaint->Status ?></span></td>
                                <?php elseif ($complaint->Status == 'Resolved') : ?>
                                    <td><span class="status active"><?php echo $complaint->Status ?></span></td>
                                <?php elseif ($complaint->Status == 'Rejected') : ?>
                                    <td><span class="status inactive"><?php echo $complaint->Status ?></span></td>
                                <?php endif; ?>
                                <td class="action">
                                    <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/admin/complaint_detail/<?php echo $complaint->ComplaintID; ?>'">
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
                </tbody>
            </table>
            <?php require APPROOT . '/views/components/pagination.php'; ?>
        </div>
    </main>
</div>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>