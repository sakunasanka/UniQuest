<?php require APPROOT . '/views/components/adm_header.php'; ?>

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
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Registered Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sakith</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>076 4834398</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view" data-tooltip="View Profile">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn edit" data-tooltip="Edit Profile">
                                edit_square
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate" data-tooltip="Deactivate User">
                                person_remove
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td>Sakith</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>076 4834398</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Deactive</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn edit">
                                edit_square
                            </span>
                            <span class="material-symbols-outlined action-btn activate">
                                person_add
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Sakith</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>076 4834398</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn edit">
                                edit_square
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                person_remove
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Sakith</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>076 4834398</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Deactive</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn edit">
                                edit_square
                            </span>
                            <span class="material-symbols-outlined action-btn activate">
                                person_add
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Sakith</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>076 4834398</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn edit">
                                edit_square
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                person_remove
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Sakith</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>076 4834398</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Deactive</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn edit">
                                edit_square
                            </span>
                            <span class="material-symbols-outlined action-btn activate">
                                person_add
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php require APPROOT . '/views/components/pagination.php'; ?>
        </div>
    </main>
</div>

<!-- Footer -->
<footer class="footer">

</footer>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSortTable.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminAddButton.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>