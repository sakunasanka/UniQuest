<?php require APPROOT . '/views/components/header.php'; ?>
<?php require APPROOT . '/views/popups/student/deletereview_popup.php'; ?>
<?php require APPROOT . '/views/popups/student/edit_review_popup.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/jobsDescription.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/myReviews.css">
<div class="main-container">
    <div class="content-area">
        <!-- Sidebar -->
        <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>

        <!-- Content Area -->
        <div class="container">
            <h2>Your Ratings and Reviews</h2>
            <div class="view-card view-card-2">
                <div class="reviews-section">
                    <!-- Reviews on Main Page -->
                    <?php foreach ($data['reviews'] as $index => $review): ?>
                        <div class="review" id="page-review-<?php echo $i; ?>" data-id="<?php echo $i; ?>">
                            <!-- Review Header: Company Name and Date -->
                            <div class="review-header">
                                <p class="company-title" onclick="goToCompany(<?php echo $review->CompanyID; ?>)"><?php echo $review->CompanyName; ?></p>
                                <span class="review-date"><?php echo date('F j, Y', strtotime($review->created_at)); ?></span>
                            </div>
                            <!-- Review Comment -->
                            <div class="review-details">
                                <p class="review-text"><?php echo $review->Comment; ?></p>
                                <span class="review-rating"><i class="fa fa-star"></i> <?php echo $review->Rating; ?></span>
                            </div>
                            <div class="review-details">
                                <?php if (($_SESSION['user_role'] == 'Student') || ($_SESSION['user_role'] == 'Company')): ?>
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
                                    <div class="post-control-btn-row">
                                    <button class="post-control-btn edit" onclick="showEditReviewPopup(<?= $review->ReviewID ?>, <?= $review->Rating ?>, '<?= addslashes($review->Comment) ?>', <?= $review->CompanyID ?>)">EDIT</button> 
                                    <button class="post-control-btn delete" onclick="showdeletereviewconfirm(<?=$review->ReviewID?>)">DELETE</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>

<script type="module" src="<?php echo URLROOT; ?>/public/js/student/starhover.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/student/myreviews.js"></script>

<script>
    function goToCompany(companyID) {
        window.location.href = "<?php echo URLROOT; ?>/student/companydescription/" + companyID;
    }
</script>