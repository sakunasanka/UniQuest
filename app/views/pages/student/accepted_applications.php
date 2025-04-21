<?php require APPROOT . '/views/components/header.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="header-text">
            <h1>Accepted Applications</h1>
        </div>
        <div class="table-block">
            
            <table>
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Title</th>
                        <th onclick="sortTable(1)">Company</th>
                        <th onclick="sortTable(2)">Location</th>
                        <th onclick="sortTable(3)">Date</th>
                        <th onclick="sortTable(4)">Status</th>
                        <!-- <th class="no-sort">Actions</th> -->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Delivery Rider</td>
                        <td>Pizza Hut</td>
                        <td>Negombo</td>
                        <td>2024/08/16</td>
                        <td><span class="status active">Accepted</span></td>
                        <!-- <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td> -->
                    </tr>

                    <tr>
                        <td>Software Engineer</td>
                        <td>99X Technology</td>
                        <td>Colombo</td>
                        <td>2024/08/15</td>
                        <td><span class="status active">Accepted</span></td>
                        <!-- <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td> -->
                    </tr>
                    <tr>
                        <td>Delivery Rider</td>
                        <td>Burger King</td>
                        <td>Galle</td>
                        <td>2024/07/16</td>
                        <td><span class="status active">Accepted</span></td>
                        <!-- <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                preview
                            </span>
                        </td> -->
                </tbody>
            </table>
            <?php require APPROOT . '/views/components/pagination.php'; ?>
        </div>
    </main>
</div>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSortTable.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>