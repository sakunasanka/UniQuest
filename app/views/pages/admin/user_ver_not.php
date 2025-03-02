<?php require APPROOT . '/views/components/adm_header.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <?php
        $columns = [
            "UserID" => "UserID",
            "Email" => "Email",
            "Role" => "Account Type",
            "RegisterDate" => "Registered Date",
            "Status" => "Status",
            "Actions" => "Actions"
        ];
        ?>
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/admin/user_ver_pending">Pending</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/admin/user_ver_not">Not Approved</button>
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
                                <td><?php echo $user->UserID; ?></td>
                                <td><?php echo $user->Email; ?></td>
                                <td><?php echo $user->Role; ?></td>
                                <td><?php echo substr($user->RegisterDate, 0, 10); ?></td>
                                <td><span class="status inactive">Not Approved</span></td>
                                <td class="action">
                                    <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/admin/user_ver_detail/<?php echo $user->UserID; ?>'">
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