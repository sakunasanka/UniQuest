<?php require APPROOT . '/views/components/ser_header.php'; ?>

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
                <!-- <button class="add-btn" data-path="/uniquest/admin/add_company">
                    <span class="material-symbols-outlined">person_add</span>
                    <span class="add-btn-text">Add Company</span>
                </button> -->
            </div>
            <table>
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">User Name</th>
                        <th onclick="sortTable(1)">Email</th>
                        <th onclick="sortTable(2)">Contact Number</th>
                        <th onclick="sortTable(3)">Registered Date</th>
                        <th onclick="sortTable(4)">Status</th>
                        <th class="no-sort">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Acme Inc</td>
                        <td>info@academic.com</td>
                        <td>0113452660</td>
                        <td>2024-05-16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/admin/com_detail'">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                person_remove
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company 2</td>
                        <td>uniquest@gmail.com</td>
                        <td>075 9851785</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Deactive</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn activate">
                                person_add
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company 3</td>
                        <td>uniquest@gmail.com</td>
                        <td>075 9851785</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                person_remove
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company 3</td>
                        <td>uniquest@gmail.com</td>
                        <td>075 9851785</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                person_remove
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company 4</td>
                        <td>uniquest@gmail.com</td>
                        <td>075 9851785</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Deactive</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn activate">
                                person_add
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company 5</td>
                        <td>uniquest@gmail.com</td>
                        <td>075 9851785</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                person_remove
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company 4</td>
                        <td>uniquest@gmail.com</td>
                        <td>075 9851785</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Deactive</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn activate">
                                person_add
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Compnay 5</td>
                        <td>uniquest@gmail.com</td>
                        <td>075 9851785</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                person_remove
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company 4</td>
                        <td>uniquest@gmail.com</td>
                        <td>075 9851785</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Deactive</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn activate">
                                person_add
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company 5</td>
                        <td>uniquest@gmail.com</td>
                        <td>075 9851785</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                person_remove
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company 1</td>
                        <td>uniquest@gmail.com</td>
                        <td>075 9851785</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                person_remove
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company 2</td>
                        <td>uniquest@gmail.com</td>
                        <td>075 9851785</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                person_remove
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company 4</td>
                        <td>uniquest@gmail.com</td>
                        <td>075 9851785</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Deactive</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn activate">
                                person_add
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company 5</td>
                        <td>uniquest@gmail.com</td>
                        <td>075 9851785</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                person_remove
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company 1</td>
                        <td>uniquest@gmail.com</td>
                        <td>075 9851785</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                person_remove
                            </span>
                        </td>
                    </tr>
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