<?php require APPROOT . '/views/components/header.php'; ?>

<div class="main-container">
    <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>

    <main class="content-area">
        <div class="header-text">
            <h1>Rejected Applications</h1>
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
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Marketing Executive</td>
                        <td>John Keells</td>
                        <td>Colombo</td>
                        <td>2024/08/14</td>
                        <td><span class="status inactive">Rejected</span></td>
                    </tr>
                    <tr>
                        <td>Sales Ref</td>
                        <td>Abans</td>
                        <td>Wattala</td>
                        <td>2024/07/09</td>
                        <td><span class="status inactive">Rejected</span></td>
                    </tr>
                    <tr>
                        <td>Delivery Rider</td>
                        <td>Burger King</td>
                        <td>Galle</td>
                        <td>2024/07/16</td>
                        <td><span class="status inactive">Rejected</span></td>
                </tbody>
            </table>
            <?php require APPROOT . '/views/components/pagination.php'; ?>
        </div>
    </main>
</div>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSortTable.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>