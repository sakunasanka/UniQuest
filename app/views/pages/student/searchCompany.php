<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/searchJob.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<body>
    <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>
    <div class="container">
        <div class="left-side">
            <h2>Search Company</h2>
            <img src="<?php echo URLROOT; ?>/images/search.png" alt="SearchJob">
        </div>
        <div class="right-side">
            <a href  ="/uniquest/student/searchJob" >
            <h2>Search Jobs</h2>
            </a>
            <h3>Finding an opportunity?</h3>
            <div class="search-bar">
                <div class="search-icon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input type="text" placeholder="Search jobs, internships" class="search-input">
                <div class="filters-button">
                    <i class="fa-solid fa-filter"></i>
                    <span>Filters</span>
                </div>
                <button class="search-button">Search</button>
            </div>
        </div>
    </div>
</body>

<?php require APPROOT . '/views/components/footer.php'; ?>


  





