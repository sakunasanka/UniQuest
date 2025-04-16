<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/searchBar.css">


<!-- <div class="content-header">
    <div class="search-bar">
        <span class="material-symbols-outlined icon">search</span>
        <input type="text" class="search" placeholder="Search for Jobs, Internships and Companies">
        <select class="column-select">
            <option value="1">Name</option>
            <option value="2">Rating</option>
            <option value="3">Location</option>
        </select>

    </div>
</div> -->

<div class='search-filter-panel'>
    <!-- First Row: Sort Option and Search Bar -->
    <div class='search-sort-row'>
        <?php
        $columns = [
            'jobs_create_at' => 'Newest',
            'Rating' => 'Highest Rating',
            'SalaryRange' => 'Highest Salary'
        ];

        $categories = [
            '1' => 'Category 1',
            '2' => 'Category 2',
            '3' => 'Category 3',
            '4' => 'Category 4',
            '5' => 'Category 5'
        ];

        $locations = [
            '1' => 'Location 1',
            '2' => 'Location 2',
            '3' => 'Location 3',
            '4' => 'Location 4',
            '5' => 'Location 5'
        ];

        $ratings = [
            '1' => 'Rating 1',
            '2' => 'Rating 2',
            '3' => 'Rating 3',
            '4' => 'Rating 4',
            '5' => 'Rating 5'
        ];
        ?>
        <?php
        $searcher = Sorter::getInstance();
        echo $searcher->renderMainSort($columns);
        ?>
        <?php
        $searcher = MainSearcher::getInstance();
        echo $searcher->renderSearchBar('Search for Jobs Title...');
        ?>
    </div>

    <!-- Second Row: Filter Functions (Hidden by Default) -->
    <div class='filter-row'>
        <?php
        $filter = Filter::getInstance();
        echo $filter->renderFilters($categories, $locations, $ratings);
        ?>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/js/components/toggleFilter.js"></script>
<script src="<?php echo URLROOT; ?>/js/components/filter.js"></script>
<script src="<?php echo URLROOT; ?>/js/components/salaryRange.js"></script>