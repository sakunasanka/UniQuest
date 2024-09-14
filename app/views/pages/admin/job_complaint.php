<?php require APPROOT . '/views/components/header.php'; ?>

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
                        <th onclick="sortTable(2)">Complaint</th>
                        <th onclick="sortTable(3)">Student Name</th>
                        <th onclick="sortTable(4)">Complained Date</th>
                        <th onclick="sortTable(5)">Status</th>
                        <th class="no-sort">View</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Job 1</td>
                        <td>uniquest@gmail.com</td>
                        <td>Complaint 1</td>
                        <td>Student 1</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Resolved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Intern 1</td>
                        <td>uniquest@gmail.com</td>
                        <td>Complaint 2</td>
                        <td>Student 2</td>
                        <td>2024/05/16</td>
                        <td><span class="status pending">Pending</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>job 2</td>
                        <td>uniquest@gmail.com</td>
                        <td>Complaint 2</td>
                        <td>Student 2</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Resolved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Intern 1</td>
                        <td>uniquest@gmail.com</td>
                        <td>Complaint 2</td>
                        <td>Student 2</td>
                        <td>2024/05/16</td>
                        <td><span class="status pending">Pending</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>job 2</td>
                        <td>uniquest@gmail.com</td>
                        <td>Complaint 2</td>
                        <td>Student 2</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Resolved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Job 1</td>
                        <td>uniquest@gmail.com</td>
                        <td>Complaint 2</td>
                        <td>Student 2</td>
                        <td>2024/05/16</td>
                        <td><span class="status pending">Pending</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>job 2</td>
                        <td>uniquest@gmail.com</td>
                        <td>Complaint 2</td>
                        <td>Student 2</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Resolved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Intern 1</td>
                        <td>uniquest@gmail.com</td>
                        <td>Complaint 2</td>
                        <td>Student 2</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Resolved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>job 2</td>
                        <td>uniquest@gmail.com</td>
                        <td>Complaint 2</td>
                        <td>Student 2</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Resolved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>job 2</td>
                        <td>uniquest@gmail.com</td>
                        <td>Complaint 2</td>
                        <td>Student 2</td>
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