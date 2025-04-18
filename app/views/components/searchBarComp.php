<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/searchBar.css">


<div class='search-filter-panel'>
    <!-- First Row: Sort Option and Search Bar -->
    <div class='search-sort-row'>
        <?php
        $industries = [];
        foreach ($data['industries'] as $industry) {
            $industries[$industry->IndustryID] = $industry->IndustryName;
        }

        $districts = [];
        foreach ($data['districts'] as $district) {
            $districts[$district->DistrictID] = $district->DistrictName;
        }

        $cities = [];

        $ratings = [
            '1' => '1 Star',
            '2' => '2 Stars',
            '3' => '3 Stars',
            '4' => '4 Stars',
            '5' => '5 Stars'
        ];
        ?>
        <?php
        $searcher = MainSearcher::getInstance();
        echo $searcher->renderSearchBar('Search Company Names...');
        ?>
    </div>

    <!-- Second Row: Filter Functions (Hidden by Default) -->
    <div class='filter-row'>
        <?php
        $filter = Filter::getInstance();
        echo $filter->renderFilterComp($industries, $districts, $cities, $ratings);
        ?>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/js/components/toggleFilter.js"></script>
<script src="<?php echo URLROOT; ?>/js/components/filter.js"></script>
<script src="<?php echo URLROOT; ?>/js/components/salaryRange.js"></script>
<script src="<?php echo URLROOT; ?>/js/components/cityFilter.js"></script>