<?php require APPROOT . '/views/components/header.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/uniquest/admin/job_ver_all">All</button>
            <button class="tab" data-path="/uniquest/admin/job_ver_pending">Pending</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/uniquest/admin/job_ver_not">Not Approved</button>
        </div>
        <div class="table-block">
            <div class="content-header">
            <div class="input-container">
                    <span class="material-symbols-outlined icon">search</span>
                    <input type="text" class="search" placeholder="Search for Titles...">
                </div>
            </div>
            <table>
                <thead>
                <tr>
                        <th onclick="sortTable(0)">Title</th>
                        <th onclick="sortTable(1)">Company Email</th>
                        <th onclick="sortTable(2)">Job Type</th>
                        <th onclick="sortTable(3)">Requested Date</th>
                        <th onclick="sortTable(4)">Status</th>
                        <th class="no-sort">View</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Title 1</td>
                        <td>uniquest@gmail.com</td>
                        <td>Part Time</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Not Approved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Title 2</td>
                        <td>uniquest@gmail.com</td>
                        <td>Internship</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Not Approved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Title 1</td>
                        <td>uniquest@gmail.com</td>
                        <td>Part Time</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Not Approved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Title 2</td>
                        <td>uniquest@gmail.com</td>
                        <td>Internship</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Not Approved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Title 1</td>
                        <td>uniquest@gmail.com</td>
                        <td>Part Time</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Not Approved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
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

<!-- Footer -->


<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminPagination.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSearchNames.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSortTable.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>