<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/jobs_table.css">

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="tabs-header">
            <h1>Ongoing Jobs</h1>
            <!-- <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/uniquest/admin/students_mng">Students</button>
            <button class="tab" data-path="/uniquest/admin/company_mng">Companies</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/uniquest/admin/verTeam_mng">Verification Team</button> -->
        </div>
        <div class="table-block">
            <div class="content-header">
                <div class="input-container">
                    <span class="material-symbols-outlined icon">search</span>
                    <input type="text" class="search" placeholder="Search for Job Titles...">
                </div>
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
                        <td>Negombo</td>
                        <td>2024/08/16</td>
                        <td>35</td>
                        <td>18</td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                            <span class="material-symbols-outlined action-btn edit">
                                edit_square
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                block
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Sales Ref</td>
                        <td>Matara</td>
                        <td>2024/08/24</td>
                        <td>40</td>
                        <td>18</td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                            <span class="material-symbols-outlined action-btn edit">
                                edit_square
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                block
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
                                preview
                            </span>
                            <span class="material-symbols-outlined action-btn edit">
                                edit_square
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                block
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