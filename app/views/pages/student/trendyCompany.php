<?php require APPROOT . '/views/components/stu_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/jobs.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="main-container">
    <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>

    <div class="content-area">
        <div class="container">
            <!-- <div class="search-bar-container">
                <div class="search-bar">
                    <div class="search-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input type="text" placeholder="Search company..." class="search-input">
                    <div class="filters-button">
                        <i class="fa-solid fa-filter"></i>
                        <span>Filters</span>
                    </div>
                </div>
            </div> -->
        
            <h1 class= "H1">Trending Companies</h1>
            <h2 class= "H2">Check out the top-rated companies based on the student reviews</h2>

            <div class="cards-container">
                <?php foreach($data['trendy_companies'] as $post): ?>
                    <div class="card">
                        <div class="card-logo" onclick="goToCompanyDescription(<?php echo $post['CompanyID']; ?>)">
                            <img
                                src="<?php echo empty($post['CompanyLogo'])
                                            ? URLROOT . '/images/profile_pic_preview.png'
                                            : UPLOADROOT . '/profile_pictures/company/' . $post['CompanyLogo']; ?>"
                                alt="Profile Picture">
                        </div>
                        <div class="card-content">
                            <div class="content-hover-class" onclick="goToCompanyDescription()">
                                <div class="title-content">
                                    <h3 class="company-title"><?php echo $post['CompanyName']; ?></h3>
                                    <div class="job-rating">
                                        <i class="fa fa-star"></i><?php echo $post['avg_rating']; ?>
                                    </div>
                                </div>
                                <p class="review-count">Based on <span><?php echo $post['total_reviews']; ?></span> 
                                   <?php 
                                        if ($post['total_reviews'] == 1) {
                                            echo 'review';
                                        } else {
                                            echo 'reviews';
                                        }
                                   ;?>
                                </p>
                                
                                <div class="job-location-details">
                                    <?php echo $post['City']; ?>
                                </div>
                            </div>
                            
                            <?php  if ($_SESSION['user_role'] == 'Student'):?>
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
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .icon-active {
        color: #e74c3c; /* Active color */
    }
</style>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<?php require APPROOT . '/views/components/footer.php'; ?>

<script>
    function goToCompanyDescription(companyId) {
        window.location.href = "/UniQuest/student/companydescription/" +companyId;
    }
</script>

<script>
    function toggleFavorite(icon) {
        icon.classList.toggle("fa-regular");
        icon.classList.toggle("fa-solid");
        icon.classList.toggle("icon-active");
    }

    function toggleBookmark(icon, companyId) {
        icon.classList.toggle("fa-regular");
        icon.classList.toggle("fa-solid");
        icon.classList.toggle("icon-active");
    }

    // Function to bookmark a company
    function bookmarkCompany(companyId, iconElement) {
        // Create a new FormData object to send the companyId
        const formData = new FormData();
        formData.append('company_id', companyId); // Append the company ID to the request data
        // Create a new XMLHttpRequest to send the data to the server

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '<?php echo URLROOT; ?>/company/toggleBookmark', true);

        // Set up the callback for when the request completes
        xhr.onload = function() {
            if (xhr.status === 200) {
                iconElement.classList.toggle('bookmarked'); // Toggle the bookmark icon
            } else {
                alert('Failed to bookmark the company.');
            }
        };

        // Send the request with the form data
        xhr.send(formData);
    }
</script>