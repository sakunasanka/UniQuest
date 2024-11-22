<?php require APPROOT . '/views/components/ser_header.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/verificationTeamSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/verification_team/job_ver_all">All</button>
            <button class="tab" data-path="/UniQuest/verification_team/job_ver_pending">Pending</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/verification_team/job_ver_not">Not Approved</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
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
                        <td>sakiththewmika@gmail.com</td>
                        <td>Part Time</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Not Approved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Title 2</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>Internship</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Not Approved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Title 1</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>Part Time</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Not Approved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Title 2</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>Internship</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Not Approved</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Title 1</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>Part Time</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Not Approved</span></td>
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