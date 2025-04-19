<?php require APPROOT . '/views/components/header.php'; ?>
<?php require APPROOT . '/views/popups/student/more_reviews.php'; ?>
<?php require APPROOT . '/views/popups/student/deactivate_account.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/view_profile.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/jobsDescription.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/studentPopups.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/review_popup.css">

<?php
if (($data['user']['subscription_plan'] == 'professional' || $data['user']['subscription_plan'] == 'enterprise') && $data['user']['subscription_status'] == 'active') {
    $currentDateTime = date('Y-m-d H:i:s');
    $remainingDays = converttimetodays(strtotime($data['user']['subscription_end_date']) - strtotime($currentDateTime));
} else {
    $remainingDays = 0;
}
?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>

    <div class="content-area">
        <div class="view-card">
            <div class="view-card-pic">
                <img
                    src="<?php echo empty($data['user']['CompanyLogo'])
                                ? URLROOT . '/images/profile_pic_preview.png'
                                : UPLOADROOT . '/profile_pictures/company/' . $data['user']['CompanyLogo']; ?>"
                    alt="Profile Picture">

                <ul class="view-card-options">
                    <li><a onclick="showdeleteaccountconfirm()">Deactivate Account</a></li>
                    <li><a href="<?php echo URLROOT ?>/user/logout">Log Out</a></li>
                </ul>
            </div>

            <div class="view-card-content">
                <div class="view-card-header">
                    <div class="view-card-title">
                        <h1><?php echo $data['user']['CompanyName'] ?></h1>
                        <h2><?php echo $data['companyData']->Industry ?></h2>
                        <p><?php echo $data['user']['Description'] ?></p>
                    </div>

                    <?php if (($data['user']['subscription_plan'] == 'professional' || $data['user']['subscription_plan'] == 'enterprise') && $data['user']['subscription_status'] == 'active'): ?>
                        <div class="plan-card">
                            <div class="subscription-plan">
                                <?php if ($data['user']['subscription_plan'] == 'professional'): ?>
                                    <span class="material-symbols-outlined gold-icon"> workspace_premium </span> Professional

                                <?php elseif ($data['user']['subscription_plan'] == 'enterprise'): ?>
                                    <span class="material-symbols-outlined black-icon"> workspace_premium </span> Enterprise

                                <?php endif; ?>
                            </div>
                            <?php if (($data['user']['subscription_plan'] == 'professional' || $data['user']['subscription_plan'] == 'enterprise') && $data['user']['subscription_status'] == 'active'): ?>
                                <div class="days-remaining"> <?php echo $remainingDays; ?> </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="view-card-info">
                    <div>
                        <span>Address</span>
                        <?php echo $data['user']['Address'] ?>
                    </div>
                    <div>
                        <span>Contact No</span>
                        <?php echo $data['user']['ContactNo'] ?>
                    </div>
                    <div>
                        <span>Email</span>
                        <?php echo $data['user']['Email'] ?>
                    </div>
                </div>
                <div class="view-card-info">
                    <?php if ($data['user']['Website']): ?>
                        <div>
                            <span>Website</span>
                            <a href="<?php echo $data['user']['Website'] ?>" target="_blank"><?php echo $data['user']['Website'] ?></a>
                        </div>
                    <?php endif; ?>
                    <?php if ($data['user']['LinkedIn']): ?>
                        <div>
                            <span>LinkedIn</span>
                            <a href="<?php echo $data['user']['LinkedIn'] ?>" target="_blank"><?php echo $data['user']['LinkedIn'] ?></a>
                        </div>
                    <?php endif; ?>
                    <?php if ($data['user']['Facebook']): ?>
                        <div>
                            <span>Facebook</span>
                            <a href="<?php echo $data['user']['Facebook'] ?>" target="_blank"><?php echo $data['user']['Facebook'] ?></a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="edit-btn">
                    <button class="edit-btn" onclick="window.location.href='/UniQuest/service_provider/edit_profile';">
                        <span class="material-symbols-outlined"> edit </span>
                        Edit Profile
                    </button>
                </div>
            </div>
        </div>
        <div class="view-card-2">
            <div class="reviews-section" id="reviews-section">
                <h4>Reviews and Ratings about this company</h4>

                <?php if (!empty($data['reviews'])): ?>
                    <?php foreach ($data['reviews'] as $index => $review): ?>
                        <?php if ($index < 3): ?> <!-- Display only the first 3 reviews -->
                            <div class="review" id="page-review-<?php echo $index; ?>" data-id="<?php echo $index; ?>">
                                <div class="review-header">
                                    <p class="review-text">"<?php echo htmlspecialchars($review->Comment ?? ''); ?>"</p>
                                    <span class="review-date"><?php echo date('F j, Y', strtotime($review->created_at)); ?></span>
                                </div>
                                <div class="review-details">
                                    <span class="reviewer-name">- <?php echo htmlspecialchars($review->StudentName); ?></span>
                                    <span class="review-rating"><i class="fa fa-star"></i> <?php echo htmlspecialchars($review->Rating ?? ''); ?></span>
                                </div>
                                <?php if ((isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Student') || (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Company')): ?>
                                    <div class="review-actions">
                                        <button class="like-btn <?php echo $review->is_liked ? 'liked' : ''; ?>" data-id="<?php echo $index; ?>" data-review-id="<?php echo $review->ReviewID; ?>">
                                            <span class="material-symbols-outlined like-icon">thumb_up</span>
                                        </button>
                                        <span class="like-count" data-id="<?php echo $index; ?>"><?php echo htmlspecialchars($review->LikeCount); ?> likes</span>

                                        <button class="dislike-btn <?php echo $review->is_disliked ? 'disliked' : ''; ?>" data-id="<?php echo $index; ?>" data-review-id="<?php echo $review->ReviewID; ?>">
                                            <span class="material-symbols-outlined dislike-icon">thumb_down</span>
                                        </button>
                                        <span class="dislike-count" data-id="<?php echo $index; ?>"><?php echo htmlspecialchars($review->DislikeCount); ?> dislikes</span>
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
                <div></div>
                <?php if (count($data['reviews']) >= 3): ?> 
                        <button class="seemore" style="margin-top: 1px;"><p onclick="toggleMoreReviews()">See more reviews...</p></button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>

<script src="<?php echo URLROOT; ?>/public/js/student/myreviews.js"></script>