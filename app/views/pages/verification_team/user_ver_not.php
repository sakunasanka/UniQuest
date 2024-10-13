<?php require APPROOT . '/views/components/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/admin/students_mng.css">

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/verificationTeamSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/uniquest/verification_team/user_ver_all">All</button>
            <button class="tab" data-path="/uniquest/verification_team/user_ver_pending">Pending</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/uniquest/verification_team/user_ver_not">Not Approved</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <span class="total-count">Total: 5</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Account Type</th>
                        <th>Requested Date</th>
                        <th>Status</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>User 1</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>Student</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Not Approved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>User 2</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>Company</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Not Approved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>User 1</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>Student</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Not Approved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>User 2</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>Company</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Not Approved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>User 1</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>Student</td>
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
            <!-- <div class="pagination">
                <button class="page-btn prev">&laquo;</button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn next">&raquo;</button>
            </div> -->
        </div>
    </main>
</div>

<!-- Footer -->


<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>