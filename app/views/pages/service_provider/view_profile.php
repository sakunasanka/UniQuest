<?php require APPROOT . '/views/components/ser_header.php'; ?>
<?php require APPROOT . '/views/popups/student/more_reviews.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/view_profile.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/jobsDescription.css">

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>

    <div class="content-area">
        <div class="view-card">
        <img 
            src="<?php echo empty($data['user']['CompanyLogo']) 
                ? URLROOT . '/images/profile_pic_preview.png' 
                : UPLOADROOT . '/profile_pictures/company/' . $data['user']['CompanyLogo']; ?>" 
            alt="Profile Picture">

            <div class="view-card-content">
                <h1><?php echo $data['user']['CompanyName'] ?></h1>
                <h2><?php echo $data['user']['Industry'] ?></h2>
                <p><?php echo $data['user']['Description'] ?></p>

                <div class="view-card-info">
                    <div>
                        <span>Address</span>
                        <?php echo $data['user']['StreetNo'] ?>, <?php echo $data['user']['AddressLine1'] ?>, <?php echo $data['user']['AddressLine2'] ?><?php echo empty($data['user']['AddressLine2']) ? '' : ',' ?> <?php echo $data['user']['City'] ?></span>
                    </div>
                    <div>
                        <span>Contact No</span>
                        <?php echo $data['user']['ContactNo'] ?>
                    </div>
                    <div>
                        <span>Email</span>
                        <?php echo $data['user']['Email'] ?>
                    </div>
                    <div>
                        <span>Website</span>
                        <a href="<?php echo $data['user']['WebSite'] ?>" target="_blank"><?php echo $data['user']['WebSite'] ?></a>
                    </div>
                </div>
                <div class="edit-btn"> 
                    <button class="edit-btn" onclick="window.location.href='/uniquest/service_provider/edit_profile';">
                        <span class="material-symbols-outlined"> edit </span>
                        Edit Profile
                    </button>
                </div>
            </div>
        </div>
            <div class="view-card view-card-2">
                <div class="reviews-section">
                    <h4>Reviews and Ratings about this company</h4>

                    <!-- Reviews on Main Page -->
                    <?php for ($i = 0; $i < 3; $i++): ?>
                        <div class="review" id="page-review-<?php echo $i; ?>" data-id="<?php echo $i; ?>">
                            <p class="review-text">"Great company to work for! Management is supportive, with benefits like meals and accommodation."</p>
                            <div class="review-details">
                                <span class="reviewer-name">- John Doe</span>
                                <span class="review-rating"><i class="fa fa-star"></i> 5.0</span>
                            </div>
                            <div class="review-actions">
                                <button class="like-btn" data-id="<?php echo $i; ?>">
                                    <span class="material-symbols-outlined like-icon">thumb_up</span>
                                </button>
                                <span class="like-count" data-id="<?php echo $i; ?>">0 likes</span>

                                <button class="dislike-btn" data-id="<?php echo $i; ?>">
                                    <span class="material-symbols-outlined dislike-icon">thumb_down</span>
                                </button>
                                <span class="dislike-count" data-id="<?php echo $i; ?>">0 dislikes</span>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
                <div class="buttons">
                        <button class="seemore"><p onclick="toggleMoreReviews()">See more reviews...</p></button>
                </div>
            </div>    
        </div>
    </div>

<?php require APPROOT . '/views/components/footer.php'; ?>

<script src="<?php echo URLROOT; ?>/public/js/student/jobsDescription.js"></script>