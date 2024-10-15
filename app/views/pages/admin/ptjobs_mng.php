<?php require APPROOT . '/views/components/ser_header.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/uniquest/admin/ptjobs_mng">Part Time Jobs</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/uniquest/admin/intern_mng">Interships</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
                <button class="add-btn">
                    <span class="material-symbols-outlined">add</span>
                    <span class="add-btn-text">Add Job</span>
                </button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Title</th>
                        <th onclick="sortTable(1)">Company Name</th>
                        <th onclick="sortTable(2)">Email</th>
                        <th onclick="sortTable(3)">Posted Date</th>
                        <th onclick="sortTable(4)">Status</th>
                        <th class="no-sort">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Job 1</td>
                        <td>Company 1</td>
                        <td>uniquest@gmail.com</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view" data-tooltip="View Profile">
                                preview
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate" data-tooltip="Deactivate User">
                                block
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Job 2</td>
                        <td>Company 2</td>
                        <td>uniquest@gmail.com</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Deactive</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                            <span class="material-symbols-outlined action-btn activate">
                                check_circle
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Job 1</td>
                        <td>Company 1</td>
                        <td>uniquest@gmail.com</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view" data-tooltip="View Profile">
                                preview
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate" data-tooltip="Deactivate User">
                                block
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Job 2</td>
                        <td>Company 2</td>
                        <td>uniquest@gmail.com</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Deactive</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                            <span class="material-symbols-outlined action-btn activate">
                                check_circle
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Job 1</td>
                        <td>Company 1</td>
                        <td>uniquest@gmail.com</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view" data-tooltip="View Profile">
                                preview
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate" data-tooltip="Deactivate User">
                                block
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Job 1</td>
                        <td>Company 1</td>
                        <td>uniquest@gmail.com</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view" data-tooltip="View Profile">
                                preview
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate" data-tooltip="Deactivate User">
                                block
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Job 1</td>
                        <td>Company 1</td>
                        <td>uniquest@gmail.com</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view" data-tooltip="View Profile">
                                preview
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate" data-tooltip="Deactivate User">
                                block
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Job 1</td>
                        <td>Company 1</td>
                        <td>uniquest@gmail.com</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view" data-tooltip="View Profile">
                                preview
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate" data-tooltip="Deactivate User">
                                block
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Job 1</td>
                        <td>Company 1</td>
                        <td>uniquest@gmail.com</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view" data-tooltip="View Profile">
                                preview
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate" data-tooltip="Deactivate User">
                                block
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Job 2</td>
                        <td>Company 2</td>
                        <td>uniquest@gmail.com</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Deactive</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                            <span class="material-symbols-outlined action-btn activate">
                                check_circle
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Job 2</td>
                        <td>Company 2</td>
                        <td>uniquest@gmail.com</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Deactive</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                            <span class="material-symbols-outlined action-btn activate">
                                check_circle
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Job 1</td>
                        <td>Company 1</td>
                        <td>uniquest@gmail.com</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view" data-tooltip="View Profile">
                                preview
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate" data-tooltip="Deactivate User">
                                block
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Job 2</td>
                        <td>Company 2</td>
                        <td>uniquest@gmail.com</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Deactive</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                            <span class="material-symbols-outlined action-btn activate">
                                check_circle
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Job 1</td>
                        <td>Company 1</td>
                        <td>uniquest@gmail.com</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view" data-tooltip="View Profile">
                                preview
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate" data-tooltip="Deactivate User">
                                block
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Job 1</td>
                        <td>Company 1</td>
                        <td>uniquest@gmail.com</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view" data-tooltip="View Profile">
                                preview
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate" data-tooltip="Deactivate User">
                                block
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


<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSortTable.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>