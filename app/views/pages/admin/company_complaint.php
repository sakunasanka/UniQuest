<?php require APPROOT . '/views/components/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/admin/students_mng.css">

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
                <span class="total-count">Total: 10</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Company Email</th>
                        <th>Complaint</th>
                        <th>Student Name</th>
                        <th>Complained Date</th>
                        <th>Status</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Company 1</td>
                        <td>sakiththewmika@gmail.com</td>
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
                        <td>Company 2</td>
                        <td>sakiththewmika@gmail.com</td>
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
                        <td>Company 3</td>
                        <td>sakiththewmika@gmail.com</td>
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
                        <td>Company 2</td>
                        <td>sakiththewmika@gmail.com</td>
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
                        <td>Company 3</td>
                        <td>sakiththewmika@gmail.com</td>
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
                        <td>Company 1</td>
                        <td>sakiththewmika@gmail.com</td>
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
                        <td>Company 3</td>
                        <td>sakiththewmika@gmail.com</td>
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
                        <td>Company 2</td>
                        <td>sakiththewmika@gmail.com</td>
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
                        <td>Company 3</td>
                        <td>sakiththewmika@gmail.com</td>
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
                        <td>Company 3</td>
                        <td>sakiththewmika@gmail.com</td>
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
<footer class="footer">

</footer>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>