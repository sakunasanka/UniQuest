<thead>
    <?php
    $sorter = Sorter::getInstance();
    echo $sorter->renderHeaders($columns);
    ?>
</thead>