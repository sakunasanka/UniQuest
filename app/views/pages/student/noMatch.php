<?php require APPROOT . '/views/components/header.php'; ?>

<header class="header">
</header>

<body>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/noMatch.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <div class="container">
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

        <div class="no-matches-container">
            <img src="<?php echo URLROOT; ?>/images/noMatch.png" alt="No Matches Found" class="no-matches-image">
            <h2>Sorry, No matches were found</h2>
            <p>Please try another search</p>
        </div>
    </div>
</body>

<?php require APPROOT . '/views/components/footer.php'; ?>