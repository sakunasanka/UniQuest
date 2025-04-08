<?php 
    if (!isset($_SESSION['user_role'])) {
        require APPROOT . '/views/components/header.php';
    }
    else if ($_SESSION['user_role'] == 'Student') {
        require APPROOT . '/views/components/stu_header.php';
    } else if ($_SESSION['user_role'] == 'Company') {
        require APPROOT . '/views/components/ser_header.php';
    } 
    else if ($_SESSION['user_role'] == 'Admin') {
        require APPROOT . '/views/components/adm_header.php';
    }
    else if ($_SESSION['user_role'] == 'VT-Member') {
        require APPROOT . '/views/components/ver_header.php';
    }
?>
<?php require APPROOT . '/views/popups/student/more_reviews.php'; ?>
<?php require APPROOT . '/views/popups/student/addReview_popup.php'; ?>


<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/jobsDescription.css">

<?php if (isset($_SESSION['user_role'])): ?>
<?php else: ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/guest_user.css">
<?php endif; ?>

<div class="main-container">
    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Student'): ?>
        <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>
    <?php elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Company'): ?>
        <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>
    <?php elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin'): ?>
        <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>
    <?php elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'VT-Member'): ?>
        <?php require APPROOT . '/views/components/verificationTeamSidePanel.php'; ?>
    <?php endif; ?>      
    
    <div class="content-area">
        <div class="job-description">
            <h2><?php echo $data['post']->Title; ?></h2>
            <p><?php echo $data['post']->Location; ?></p>
            <h3>Description:</h3>
            <ul>
            <?php
                $description = $data['post']->Description ?? ''; 

                if (!empty(trim($description))) {
                    $descriptionArray = explode("\n", $description);

                    foreach ($descriptionArray as $desc) {
                        if (!empty(trim($desc))) {
                            echo '<li>' . htmlspecialchars(trim($desc)) . '</li>';
                        }
                    }
                } else {
                    echo '<li>No description availaible</li>';
                }
            ?>
            </ul>

            <h3>Qualifications:</h3>
            <ul>
            <?php
                $qualifications = $data['post']->RequiredQualifications ?? '';

                if (!empty(trim($qualifications))) {
                    $qualificationsArray = explode("\n", $qualifications);

                    foreach ($qualificationsArray as $qualification) {
                        if (!empty(trim($qualification))) {
                            echo '<li>' . htmlspecialchars(trim($qualification)) . '</li>';
                        }
                    }
                } else {
                    echo '<li>No qualifications to display</li>';
                }
            ?>
            </ul>

            <h3>Benefits:</h3>
            <ul>
            <?php
                $jobBenefits = $data['post']->JobBenefits ?? '';

                if (!empty(trim($jobBenefits))) {
                    $benefitArray = explode("\n", $jobBenefits);

                    foreach ($benefitArray as $benefit) {
                        if (!empty(trim($benefit))) {
                            echo '<li>' . htmlspecialchars(trim($benefit)) . '</li>';
                        }
                    }
                } else {
                    echo '<li>No benefits to display</li>';
                }
            ?>
            </ul> 

            <div class="reviews-section">
                <h3>Reviews and Ratings about this company</h3>
                <?php if (!empty($data['reviews'])): ?>
                    <?php foreach ($data['reviews'] as $index => $review): ?>
                        <?php if ($index < 3): ?> <!-- Display only the first 3 reviews -->
                            <div class="review" id="page-review-<?php echo $index; ?>" data-id="<?php echo $index; ?>">
                                <p class="review-text">"<?php echo htmlspecialchars($review->Comment ?? ''); ?>"</p>
                                <div class="review-details">
                                    <span class="reviewer-name">- <?php echo htmlspecialchars($review->StudentName); ?></span>
                                    <span class="review-rating"><i class="fa fa-star"></i> <?php echo htmlspecialchars($review->Rating ?? ''); ?></span>
                                </div>
                                <?php if ((isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Student') || (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Company' && $_SESSION['user_id'] == $data['post']->CompanyID)): ?>
                                    <div class="review-actions">
                                        <button class="like-btn" data-id="<?php echo $index; ?>">
                                            <span class="material-symbols-outlined like-icon">thumb_up</span>
                                        </button>
                                        <span class="like-count" data-id="<?php echo $index; ?>">0 likes</span>

                                        <button class="dislike-btn" data-id="<?php echo $index; ?>">
                                            <span class="material-symbols-outlined dislike-icon">thumb_down</span>
                                        </button>
                                        <span class="dislike-count" data-id="<?php echo $index; ?>">0 dislikes</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No reviews available.</p>
                <?php endif; ?>
            </div>

            <div class="buttons btn-space-between">
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Student'): ?>
                    <button onclick="ToggleAddReview()" class="apply-btn">Add review</button>
                    
                    <?php if (count($data['reviews']) >= 3): ?> 
                        <button class="seemore" style="margin-top: 1px;"><p onclick="toggleMoreReviews()">See more reviews...</p></button>
                    <?php endif; ?>
                    
                <?php else: ?>
                    <div></div>

                    <?php if (count($data['reviews']) >= 3): ?> 
                        <button class="seemore" style="margin-top: 1px;"><p onclick="toggleMoreReviews()">See more reviews...</p></button>
                    <?php endif; ?>
                    
                <?php endif; ?>
            </div>  
        </div>

        <div class="job-card">
            <?php  if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Student'):?>
                <div class="card-icons">
                    <i class="fa fa-share-alt" aria-hidden="true"></i>                         
                    <i class="<?php echo in_array($post->JobID, $data['bookmarkedJobIds']) ? 'fa-solid' : 'fa-regular'; ?> fa-bookmark" onclick="toggleBookmark(this); bookmarkJob(<?php echo $post->JobID; ?>, this)"></i>
                </div>
            <?php else:?>
                <div class="card-icons">
                    <i class="fa fa-share-alt" aria-hidden="true"></i>
                </div>
            <?php endif;?> 
            <div class="job-logo">
                <img src="<?php echo empty($data['post']->CompanyLogo)
                                ? URLROOT . '/images/profile_pic_preview.png'
                                : UPLOADROOT . '/profile_pictures/company/' . $data['post']->CompanyLogo; ?>"
                    alt="Burger King Logo">
            </div>
            <div class="job-details">
                <h3><?php echo $data['post']->Title; ?></h3>
                <p><b>@<span><?php echo $data['post']->CompanyName; ?></b></span></p>
                
                <p><?php echo converttimetoreadableformat($post->jobs_create_at); ?></p>
                <p class="job-rating"><i class="fa fa-star"></i> <?php echo $data['displayRating']; ?></p>
                <p><?php echo $data['post']->Location; ?></p>
                <table class="table">
                    <tr><td>Salary:</td><td>Rs.<?php echo $data['post']->SalaryRange; ?> <?php echo $data['post']->SalaryType; ?></td></tr>
                    <tr><td>Applicants:</td><td>26</td></tr>
                </table>

                <div class="social-media-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="buttons">
                <button onclick="goToCompanyDescription(<?php echo $post->CompanyID; ?>)" class="apply-btn">View Company</button>
            </div>
        </div>    
    </div>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>

<script src="<?php echo URLROOT; ?>/public/js/student/jobsDescription.js"></script>

<script>
function toggleBookmark(icon, jobId) {
icon.classList.toggle("fa-regular");
icon.classList.toggle("fa-solid");
icon.classList.toggle("icon-active");
}