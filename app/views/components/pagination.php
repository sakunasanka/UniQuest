<!-- <div class="pagination"> -->
<!-- <button class="page-btn prev">&laquo;</button> -->
<!-- <button class="page-btn active">1</button> -->
<!-- <button class="page-btn next">&raquo;</button> -->
<!-- </div> -->

<!-- <script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminPagination.js"></script> -->


<div class="pagination">
    <div class="limit-container">
        <!-- Form for limit selection -->
        <form method="GET" class="limit-form">
            <span class="rows-text">Limit:</span>
            <select class="limit-select" name="limit" onchange="this.form.submit()">
                <?php
                $selectedLimit = isset($_GET['limit']) ? (int)$_GET['limit'] : $data['rowsPerPage'];
                if ($selectedLimit == 12) {
                    $limits = [12, 24, 48, 96];
                } elseif ($selectedLimit == 10) {
                    $limits = [5, 10, 20, 40, 80];
                } elseif ($selectedLimit == 2) {
                    $limits = [2, 4, 8, 16, 32]; //test
                } else {
                    $limits = [5, 10, 15, 20, 25, 30, 35, 40, 45, 50];
                }
                foreach ($limits as $limit) {
                    $selected = ($limit == $selectedLimit) ? "selected" : "";
                    echo "<option value='$limit' $selected>$limit</option>";
                }
                ?>
            </select>
            <!-- Preserve other query parameters -->
            <?php
            $url = $_SERVER['REQUEST_URI'];
            $parsedUrl = parse_url($url);
            $queryParams = [];
            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $queryParams);
            }
            unset($queryParams['limit']); // Remove 'limit' to avoid duplication
            unset($queryParams['page']); // Optionally remove 'page' to reset to page 1
            foreach ($queryParams as $key => $value) {
                echo "<input type='hidden' name='$key' value='$value'>";
            }
            ?>
        </form>
    </div>
    <?php
    // Initialize the Pager with the selected limit
    $pager = Pager::getInstance($data['totalRows'], $selectedLimit);
    echo $pager->render();
    ?>
</div>