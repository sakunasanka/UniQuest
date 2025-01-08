<?php require APPROOT . '/views/components/stu_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/jobs.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Student'): ?>
    <?php else: ?>       
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/guest_user.css">
<?php endif; ?>

<div class="main-container">
    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Student'): ?>
        <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>
        <?php else: ?>    
    <?php endif; ?>    

    <div class="content-area">
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/student/jobs">Part Time Jobs</button>
            <button class="tab" style="border-radius: 0px 0px 0px 0px;" data-path="/UniQuest/student/internships">Internships</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/student/company">Companies</button>
        </div>
        <div class="container">
            <?php require APPROOT . '/views/components/searchBar.php'; ?>
            <!-- <div class="search-bar-container">
                <div class="search-bar">
                    <div class="search-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input type="text" placeholder="Search jobs, internships..." class="search-input">
                    <div class="filters-button">
                        <i class="fa-solid fa-filter"></i>
                        <span>Filters</span>
                    </div>
                </div>
            </div> -->

            <div class="cards-container">
                <?php for ($i = 0; $i < 6; $i++): ?>
                    <div class="card">
                        <div class="card-logo" onclick="goToInternshipDescription()">
                            <img src="<?php echo URLROOT; ?>/images/begoodsolutions.jpeg" alt="job">
                        </div>
                        <div class="card-content" >
                            <div class="content-hover-class" onclick="goToInternshipDescription()">
                                <div class="title-content">
                                    <h3 class="job-title">Software Engineering Internship</h3>
                                    <div class="job-rating">
                                        <i class="fa fa-star"></i> 4.8
                                    </div>
                                </div>
                                <p class="company-name"><b>Begood solutions</b> </p>
                                
                            
                                
                                <div class="job-location-details">
                                    Colombo, Western Province
                                </div>
                            </div>
                            <?php  if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Student'):?>
                                <div class="card-icons">
                                    <i class="fa-regular fa-heart" onclick="toggleFavorite(this)"></i>
                                    <i class="fa fa-share-alt" aria-hidden="true"></i>
                                    <i class="fa-regular fa-bookmark" onclick="toggleBookmark(this)"></i>
                                </div>
                            <?php endif;?>    
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

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<?php require APPROOT . '/views/components/footer.php'; ?>

<script>
    function goToInternshipDescription() {
        window.location.href = "/UniQuest/student/internshipdescription/"+10;
    }
</script>