<?php require APPROOT . '/views/components/adm_header.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/uniquest/admin/job_complaint">Jobs</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/uniquest/admin/company_complaint">Companies</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
            </div>
            <table>
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Company</th>
                        <th onclick="sortTable(1)">Company Email</th>
                        <th onclick="sortTable(2)">No of complaints</th>
                        <th onclick="sortTable(3)">Most recent complaint date</th>
                        <th onclick="sortTable(4)">Status</th>
                        <th class="no-sort">View</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Company 1</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>2</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Resolved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company 2</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>3</td>
                        <td>2024/05/16</td>
                        <td><span class="status pending">Pending</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company 3</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>2</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Resolved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company 2</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>1</td>
                        <td>2024/05/16</td>
                        <td><span class="status pending">Pending</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company 3</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>4</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Resolved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company 1</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>2</td>
                        <td>2024/05/16</td>
                        <td><span class="status pending">Pending</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company 3</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>2</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Resolved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company 2</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>1</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Resolved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company 3</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>3</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Resolved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Company 3</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>1</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Resolved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
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

<?php require APPROOT . '/views/components/footer.php'; ?>