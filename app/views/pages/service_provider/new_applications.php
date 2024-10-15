<?php require APPROOT . '/views/components/ser_header.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/uniquest/service_provider/new_applications">New Applications</button>
            <button class="tab" data-path="/uniquest/service_provider/offered_applications">Offered Applications</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/uniquest/service_provider/rejected_applications">Rejected Applications</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
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
            <?php require APPROOT . '/views/components/pagination.php'; ?>
        </div>
    </main>
</div>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSortTable.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>