<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/admin/students_mng.css">
<!-- header -->

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
        <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/uniquest/admin/students_mng">Students</button>
            <button class="tab" data-path="/uniquest/admin/company_mng">Companies</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/uniquest/admin/verTeam_mng">Verification Team</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <div class="input-container">
                    <span class="material-symbols-outlined icon">search</span>
                    <input type="text" class="search" placeholder="Search for User Names...">
                </div>
                <button class="add-btn">
                    <span class="material-symbols-outlined">person_add</span>
                    <span class="add-btn-text">Add Student</span>
                </button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">User Name</th>
                        <th onclick="sortTable(1)">Email</th>
                        <th onclick="sortTable(2)">Mobile Number</th>
                        <th onclick="sortTable(3)">Registered Date</th>
                        <th onclick="sortTable(4)">Status</th>
                        <th class="no-sort">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sakith</td>
                        <td>uniquest@gmail.com</td>
                        <td>071 2519865</td>
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
                        <td>Pamali</td>
                        <td>uniquest@gmail.com</td>
                        <td>071 2519865</td>
                        <td>2024/06/16</td>
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
                        <td>Sakuna</td>
                        <td>uniquest@gmail.com</td>
                        <td>071 2519865</td>
                        <td>2024/06/16</td>
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
                        <td>Sakuna</td>
                        <td>uniquest@gmail.com</td>
                        <td>071 2519865</td>
                        <td>2024/06/16</td>
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
                        <td>Sehara</td>
                        <td>uniquest@gmail.com</td>
                        <td>071 2519865</td>
                        <td>2024/06/16</td>
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
                        <td>Damsara</td>
                        <td>uniquest@gmail.com</td>
                        <td>071 2519865</td>
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
                        <td>Wameesha</td>
                        <td>uniquest@gmail.com</td>
                        <td>071 2519865</td>
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
                        <td>Gayeshan</td>
                        <td>uniquest@gmail.com</td>
                        <td>071 2519865</td>
                        <td>2024/07/16</td>
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
                        <td>Sehara</td>
                        <td>uniquest@gmail.com</td>
                        <td>071 2519865</td>
                        <td>2024/07/16</td>
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
                        <td>uniquest@gmail.com</td>
                        <td>071 2519865</td>
                        <td>2024/07/16</td>
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
                        <td>Pamali</td>
                        <td>uniquest@gmail.com</td>
                        <td>071 2519865</td>
                        <td>2024/07/16</td>
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
                        <td>Damsara</td>
                        <td>uniquest@gmail.com</td>
                        <td>071 2519865</td>
                        <td>2024/06/16</td>
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
                        <td>Sachin</td>
                        <td>uniquest@gmail.com</td>
                        <td>071 2519865</td>
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
                        <td>uniquest@gmail.com</td>
                        <td>071 2519865</td>
                        <td>2024/06/16</td>
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
                </tbody>
            </table>
            <div class="pagination">
                <button class="page-btn prev">&laquo;</button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn next">&raquo;</button>
            </div>
        </div>
    </main>
</div>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminPagination.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSearchNames.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSortTable.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>