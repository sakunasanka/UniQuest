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
            <span class="rows-text">Records per Page:</span>
            <select class="limit-select" name="limit" onchange="this.form.submit()">
                <?php
                $limits = [1, 2, 4, 6, 8, 10];
                $selectedLimit = isset($_GET['limit']) ? (int)$_GET['limit'] : $data['rowsPerPage'];
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