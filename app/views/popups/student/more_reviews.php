<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/studentPopups.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/review_popup.css">
<div class="popup-container">
    <div class="popup" id="popup-1">
        <div class="overlay"></div>
        <div class="content">
            <div class="close-btn-container"><button class="close-btn" onclick="toggleMoreReviews()"><i class="fa fa-times"></i></button></div>
            <div class="reviews-section-popup">
                <h3>Reviews and Ratings about this company</h3>

                <?php if (!empty($data['reviews'])): ?>
                <?php foreach ($data['reviews'] as $review): ?>
                    <div class="review">
                        <p class="review-text"><?php echo htmlspecialchars($review->Comment ?? ''); ?></p>
                        <div class="review-details">
                            <span class="reviewer-name">- <?php echo htmlspecialchars($review->StudentName ?? 'Anonymous'); ?></span>
                            <span class="review-rating"><i class="fa fa-star"></i> <?php echo htmlspecialchars($review->Rating ?? '0'); ?></span>
                        </div>
                        <?php  if ((isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Student') ||(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Company' && $_SESSION['user_id']==$data['post']->CompanyID)):?>
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
                        <?php endif;?>
                    </div>
                <?php endforeach; ?>
                <?php else:?>
                    <p>No reviews available.</p>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/public/js/student/review_popup.js"></script>