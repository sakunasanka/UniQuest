<?php require APPROOT . '/views/components/header.php'; ?>

<div class="main-container">

    <?php require APPROOT . '/views/components/verificationTeamSidePanel.php'; ?>

    <main class="content-area">
        <?php
        $columns = [
            "Name" => "Name",
            "Email" => "Email",
            "Role" => "Account Type",
            "ActionDate" => "Verified Date",
            "Status" => "Status",
            "Actions" => "Actions"
        ];
        ?>
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/verification_team/user_verified">Users</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/verification_team/job_verified">Jobs</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
            </div>
            <table>
                <?php require APPROOT . '/views/components/adminTableheader.php'; ?>
                <tbody>
                    <?php if ($data['users']) : ?>
                        <?php foreach ($data['users'] as $user) : ?>
                            <tr>
                                <td><?php echo $user->Name; ?></td>
                                <td><?php echo $user->Email; ?></td>
                                <td><?php echo $user->Role; ?></td>
                                <td><?php echo substr($user->ActionDate, 0, 10); ?></td>
                                <?php if ($user->Status == 'Active') : ?>
                                    <td><span class="status active">Active</span></td>
                                <?php elseif ($user->Status == 'Deactive' || $user->Status == 'Pending Deletion') : ?>
                                    <td><span class="status inactive">Deactive</span></td>
                                <?php endif; ?>
                                <td class="action">
                                    <div class="tooltip">
                                        <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/verification_team/user_detail/<?php echo $user->UserID; ?>'">
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