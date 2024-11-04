<?php require APPROOT . '/views/components/stu_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/jobs.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="main-container">
    <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>

    <div class="content-area">
        <div class="container">
            <div class="search-bar-container">
                <div class="search-bar">
                    <div class="search-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input type="text" placeholder="Search jobs, internships" class="search-input">
                    <div class="filters-button">
                        <i class="fa-solid fa-filter"></i>
                        <span>Filters</span>
                    </div>
                </div>
            </div>

            <div class="cards-container">
                <?php for ($i = 0; $i < 6; $i++): ?>
                    <div class="card">
                        <div class="card-logo">
                            <img src="<?php echo URLROOT; ?>/images/job.png" alt="job">
                        </div>
                        <div class="card-content">
                            <div class="job-rating">
                                <i class="fa fa-star"></i> 4.8
                            </div>
                            <h3 class="job-title">Delivery Rider</h3>
                            <p class="job-location">Negombo / Ja Ela / Kiribathgoda</p>
                            <p class="job-salary">Rs. 2,000 (per day)</p>
                            <p class="job-days-left">9 days left</p>
                            
                            <div class="job-location-details">
                                Colombo, Western Province
                            </div>
                            <div class="card-icons">
                                <i class="fa-regular fa-heart" onclick="toggleFavorite(this)"></i>
                                <i class="fa fa-share-alt" aria-hidden="true"></i>
                                <i class="fa-regular fa-bookmark" onclick="toggleBookmark(this)"></i>
                            </div>
                        </div>
                        <div class="social-media-icons">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>  
    </div>
</div>

<style>
    .icon-active {
        color: #e74c3c; /* Active color */
    }
</style>

<script>
    function toggleFavorite(icon) {
        icon.classList.toggle("fa-regular");
        icon.classList.toggle("fa-solid");
        icon.classList.toggle("icon-active");
    }

    function toggleBookmark(icon) {
        icon.classList.toggle("fa-regular");
        icon.classList.toggle("fa-solid");
        icon.classList.toggle("icon-active");
    }
</script>

<?php require APPROOT . '/views/components/footer.php'; ?>
