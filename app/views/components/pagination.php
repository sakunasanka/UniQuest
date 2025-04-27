<div class="pagination">
    <div class="limit-container">

        <form method="GET" class="limit-form">
            <span class="rows-text">Limit:</span>
            <select class="limit-select" name="limit" onchange="this.form.submit()">
                <?php
                $selectedLimit = isset($_GET['limit']) ? (int)$_GET['limit'] : $data['rowsPerPage'];
                if (in_array($selectedLimit, [12, 24, 48, 96])) {
                    $limits = [12, 24, 48, 96];
                } elseif (in_array($selectedLimit, [10, 20, 40, 80])) {
                    $limits = [10, 20, 40, 80];
                } else {
                    $limits = [10, 20, 40, 80];
                }
                foreach ($limits as $limit) {
                    $selected = ($limit == $selectedLimit) ? "selected" : "";
                    echo "<option value='$limit' $selected>$limit</option>";
                }
                ?>
            </select>

            <?php
            $url = $_SERVER['REQUEST_URI'];
            $parsedUrl = parse_url($url);
            $queryParams = [];
            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $queryParams);
            }
            unset($queryParams['limit']); 
            unset($queryParams['page']); 
            foreach ($queryParams as $key => $value) {
                echo "<input type='hidden' name='$key' value='$value'>";
            }
            ?>
        </form>
    </div>
    <?php

    $pager = Pager::getInstance($data['totalRows'], $selectedLimit);
    echo $pager->render();
    ?>
</div>