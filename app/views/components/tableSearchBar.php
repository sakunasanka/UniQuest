
<!-- 
<div class="search-bar">
    <span class="material-symbols-outlined icon">search</span>
    <input type="text" class="search" placeholder="Search...">
    <select class="column-select"></select>
</div> -->

<?php
    $seacher = TableSearcher::getInstance();
    echo $seacher->renderSearchBar();
?>