<?php require APPROOT . '/views/components/ser_header.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/uniquest/service_provider/ongoing_jobs">Ongoing Jobs</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/uniquest/service_provider/offered_jobs">Offered Jobs</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
                <button class="add-btn">
                    <span class="material-symbols-outlined">post_add</span>
                    <span class="add-btn-text">Post Job</span>
                </button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Title</th>
                        <th onclick="sortTable(1)">Location</th>
                        <th onclick="sortTable(2)">Date Posted</th>
                        <th onclick="sortTable(3)">Views</th>
                        <th onclick="sortTable(4)">Applicants</th>
                        <th class="no-sort">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Delivery Rider</td>
                        <td>Colombo</td>
                        <td>2024/08/16</td>
                        <td>32</td>
                        <td>10</td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn edit">
                                edit_square
                            </span>
                            <span class="material-symbols-outlined action-btn activate">
                                check_circle
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Delivery Rider</td>
                        <td>Negombo</td>
                        <td>2024/08/24</td>
                        <td>40</td>
                        <td>18</td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn edit">
                                edit_square
                            </span>
                            <span class="material-symbols-outlined action-btn activate">
                                check_circle
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Sales Ref</td>
                        <td>Galle</td>
                        <td>2024/07/05</td>
                        <td>50</td>
                        <td>22</td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn edit">
                                edit_square
                            </span>
                            <span class="material-symbols-outlined action-btn activate">
                                check_circle
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