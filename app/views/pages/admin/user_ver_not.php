<?php require APPROOT . '/views/components/ser_header.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/admin/user_ver_all">All</button>
            <button class="tab" data-path="/UniQuest/admin/user_ver_pending">Pending</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/admin/user_ver_not">Not Approved</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
            </div>
            <table>
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">User ID</th>
                        <th onclick="sortTable(1)">Email</th>
                        <th onclick="sortTable(2)">Account Type</th>
                        <th onclick="sortTable(3)">Requested Date</th>
                        <th onclick="sortTable(4)">Status</th>
                        <th class="no-sort">View</th>
                    </tr>
                </thead>
                <tbody>
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
                </tbody>
            </table>
            <?php require APPROOT . '/views/components/pagination.php'; ?>
        </div>
    </main>
</div>


<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSortTable.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>