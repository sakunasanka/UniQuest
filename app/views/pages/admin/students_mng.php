<?php require APPROOT . '/views/components/adm_header.php'; ?>
<?php require APPROOT . '/views/popups/admin/deactivateAcc.php'; ?>

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
                <!-- <button class="add-btn" data-path="/uniquest/admin/add_student">
                    <span class="material-symbols-outlined">person_add</span>
                    <span class="add-btn-text">Add Student</span>
                </button> -->
            </div>
            <table>
                <thead>
                <tr>
                        <th onclick="sortTable(0)">User ID</th>
                        <th onclick="sortTable(1)">Email</th>
                        <th onclick="sortTable(2)">Mobile Number</th>
                        <th onclick="sortTable(3)">Registered Date</th>
                        <th onclick="sortTable(4)">Status</th>
                        <th class="no-sort">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['students'] as $student) : ?>
                        <tr>
                            <td><?php echo $student->UserID; ?></td>
                            <td><?php echo $student->Email; ?></td>
                            <td><?php echo $student->ContactNo; ?></td>
                            <td><?php echo substr($student->RegisterDate, 0, 10); ?></td>
                            <?php if ($student->Status == 'Active') : ?>
                                <td><span class="status active">Active</span></td>
                                <td class="action">
                                    <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/admin/user_detail/<?php echo $student->UserID; ?>'">
                                        account_box
                                    </span>
                                    <span class="material-symbols-outlined action-btn deactivate" onclick="togglePopup1()">
                                        person_remove
                                    </span>
                                </td>
                            <?php elseif($student->Status == 'Deactive') : ?>
                                <td><span class="status inactive">Deactive</span></td>
                                <td class="action">
                                    <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/admin/user_detail/<?php echo $student->UserID; ?>'">
                                        account_box
                                    </span>
                                    <span class="material-symbols-outlined action-btn activate" onclick="togglePopup2()">
                                        person_add
                                    </span>
                            <?php endif; ?>
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
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminAddButton.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>