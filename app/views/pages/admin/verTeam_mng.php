<?php require APPROOT . '/views/components/adm_header.php'; ?>
<?php require APPROOT . '/views/popups/admin/activateDeactivateAcc.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/admin/students_mng">Students</button>
            <button class="tab" data-path="/UniQuest/admin/company_mng">Companies</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/admin/verTeam_mng">Verification Team</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
                <button class="add-btn" data-path="/UniQuest/admin/add_member">
                    <span class="material-symbols-outlined">person_add</span>
                    <span class="add-btn-text">Add Member</span>
                </button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th onclick="sortTable(0, 'UserID')">User ID</th>
                        <th onclick="sortTable(1,'Email')">Email</th>
                        <th onclick="sortTable(2, 'ContactNo')">Mobile Number</th>
                        <th onclick="sortTable(3, 'RegisterDate')">Registered Date</th>
                        <th onclick="sortTable(4, 'Status')">Status</th>
                        <th class="no-sort">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['vtMembers'] as $user) : ?>
                        <tr>
                            <td><?php echo $user->UserID; ?></td>
                            <td><?php echo $user->Email; ?></td>
                            <td><?php echo $user->ContactNo; ?></td>
                            <td><?php echo substr($user->RegisterDate, 0, 10); ?></td>
                            <?php if ($user->Status == 'Active') : ?>
                                <td><span class="status active">Active</span></td>
                                <td class="action">
                                    <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/admin/user_detail/<?php echo $user->UserID; ?>'">
                                        account_box
                                    </span>
                                    <span class="material-symbols-outlined action-btn deactivate" onclick="deactivateUser(<?php echo $user->UserID; ?>, 'VT-Member')">
                                        person_remove
                                    </span>
                                </td>
                            <?php elseif ($user->Status == 'Deactive') : ?>
                                <td><span class="status inactive">Deactive</span></td>
                                <td class="action">
                                    <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/admin/user_detail/<?php echo $user->UserID; ?>'">
                                        account_box
                                    </span>
                                    <span class="material-symbols-outlined action-btn activate" onclick="activateUser(<?php echo $user->UserID; ?>, 'VT-Member')">
                                        person_add
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

<script>
    const totalPages = <?php echo $data['totalPages']; ?>;
</script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSortTable.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminAddButton.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>