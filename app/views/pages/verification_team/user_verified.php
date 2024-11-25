<?php require APPROOT . '/views/components/ver_header.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/verificationTeamSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/verification_team/user_verified">Users</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/verification_team/job_verified">Jobs</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
            </div>
            <table>
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">User ID</th>
                        <th onclick="sortTable(1)">Email</th>
                        <th onclick="sortTable(2)">Account Type</th>
                        <th onclick="sortTable(3)">Requested Date</th>
                        <th onclick="sortTable(4)">Status</th>
                        <th class="no-sort">View</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>User 1</td>
                        <td>sunil@uoc.com</td>
                        <td>Student</td>
                        <td>2024-10-25</td>
                        <td><span class="status active">Approved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/verification_team/stu_detail'">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>User 2</td>
                        <td>info@academic.com</td>
                        <td>Company</td>
                        <td>2024-05-16</td>
                        <td><span class="status active">Approved</span></td>
                        <td class="action">
                        <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/verification_team/com_detail'">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>User 1</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>Student</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Approved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>User 2</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>Company</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Approved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>User 1</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>Student</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Approved</span></td>
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

<!-- Footer -->


<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSortTable.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>