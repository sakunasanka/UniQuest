<?php require APPROOT . '/views/components/stu_header.php'; ?>
<?php require APPROOT . '/views/popups/student/more_reviews.php'; ?>
<?php require APPROOT . '/views/popups/student/addReview_popup.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/view_profile.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/jobsDescription.css">

<?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Student'): ?>
    <?php else: ?>       
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/guest_user.css">
<?php endif; ?>

<div class="main-container">
    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Student'): ?>
        <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>
    <?php endif; ?>    

    <div class="content-area">
        <div class="view-card">
            <img src="<?php echo URLROOT; ?>/images/begoodsolutions.jpeg" alt="Logo not available">

            <div class="view-card-content">
                <div class="title-with-bookmark">
                    <h1>Acme Inc.</h1>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Student'): ?>
                        <div class="card-icons">
                            <i class="fa fa-share-alt" aria-hidden="true"></i>
                            <i class="fa-regular fa-bookmark" onclick="toggleBookmark(this)"></i>
                        </div>
                    <?php endif; ?>
                </div>


                <h2>Software & Technology</h2>
                <p>Acme Inc. is a leading software company that specializes in developing innovative solutions for businesses of all sizes. With a team of talented engineers and designers, we are committed to delivering high-quality products that help our clients achieve their goals.</p>

                <div class="view-card-info">
                    <div>
                        <span>Address</span>
                        123 Main Street, Colombo
                    </div>
                    <div>
                        <span>Phone</span>
                        +94 11-345-2686
                    </div>
                    <div>
                        <span>Email</span>
                        info@academic.com
                    </div>
                    <div>
                        <span>Website</span>
                        <a href="http://www.acmeinc.com" target="_blank">www.acmeinc.com</a>
                    </div>
                </div>

            </div>
        </div>


        <div class="view-card">
            <div class="job-list">
                <?php for ($i = 0; $i < 3; $i++): ?>
                    <div class="job-item" onclick="goToJobDescription()">
                        <div class="job-header">
                            <div>
                                <h5>Senior UX Designer</h5>
                            </div>
                        </div>
                        <div class="job-tags">
                            <span class="tag">On-Site</span>
                            <span class="tag">Full-Time</span>
                            <span class="tag">Design</span>
                        </div>
                        <p class="job-description">
                            Acme Inc. seeks a Senior UX Designer to create user-centric designs, collaborating with teams to deliver innovative, intuitive software solutions for exceptional user experiences.
                        </p>
                        <div class="job-actions">
                            <button class="details-btn">View Details</button>
                        </div>
                    </div>
                <?php endfor; ?>
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
                        <?php if ((isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Student') || (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Company' && $_SESSION['user_id'] == $data['post']->CompanyID)): ?>
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
                        <?php endif; ?>
                    </div>
                <?php endfor; ?>
            </div>
            <div class="buttons btn-space-between">
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Student'): ?>
                    <!-- <button onclick="goToAddReview(<?php echo $post->CompanyID; ?>)" class="apply-btn">Add review</button> -->
                    <button onclick="ToggleAddReview()" class="apply-btn">Add review</button>

                    <button class="seemore">
                        <p onclick="toggleMoreReviews()">See more reviews...</p>
                    </button>
                <?php else: ?>
                    <div></div>
                    <button class="seemore">
                        <p onclick="toggleMoreReviews()">See more reviews...</p>
                    </button>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>

<script src="<?php echo URLROOT; ?>/public/js/student/jobsDescription.js"></script>

<script>
    function goToJobDescription() {
        window.location.href = "/uniquest/student/jobsdescription/" + 10;
    }
</script>


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