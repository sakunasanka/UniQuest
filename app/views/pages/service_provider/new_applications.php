<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/jobs_table.css">

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="tabs-header">
            <h1>New Applications</h1>
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
            </div>
            <table>
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Job Title</th>
                        <th onclick="sortTable(1)">Name</th>
                        <th onclick="sortTable(2)">Email</th>
                        <th onclick="sortTable(3)">Mobile Number</th>
                        <th onclick="sortTable(4)">City</th>
                        <th onclick="sortTable(5)">Date</th>
                        <th class="no-sort">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Delivery Rider</td>
                        <td>Sakith</td>
                        <td>uniquest@gmail.com</td>
                        <td>0771702961</td>
                        <td>Negombo</td>
                        <td>2024/08/20</td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                            <span class="material-symbols-outlined action-btn activate">
                                check_circle
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                block
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Sales Ref</td>
                        <td>Damsara</td>
                        <td>uniquest@gmail.com</td>
                        <td>0718544398</td>
                        <td>Galle</td>
                        <td>2024/08/25</td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                            <span class="material-symbols-outlined action-btn activate">
                                check_circle
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                block
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Delivery Rider</td>
                        <td>Nipuna</td>
                        <td>uniquest@gmail.com</td>
                        <td>0769383889</td>
                        <td>Colombo</td>
                        <td>2024/08/15</td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                            <span class="material-symbols-outlined action-btn activate">
                                check_circle
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