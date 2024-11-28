<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/studentPopups.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/review_popup.css">
<div class="popup-container">
    <div class="popup" id="popup-1">
        <div class="overlay"></div>
        <div class="content">
            <div class="close-btn-container"><button class="close-btn" onclick="toggleMoreReviews()"><i class="fa fa-times"></i></button></div>
            <div class="reviews-section-popup">
                <h4>Reviews and Ratings about this company</h4>

                <?php for ($i = 0; $i < 6; $i++): ?>
                    <div class="review" id="popup-review-<?php echo $i; ?>" data-id="<?php echo $i; ?>">
                        <p class="review-text">"Great company to work for! Management is supportive, with benefits like meals and accommodation."</p>
                        <div class="review-details">
                            <span class="reviewer-name">- John Doe</span>
                            <span class="review-rating"><i class="fa fa-star"></i> 5.0</span>
                        </div>
                        <?php  if (($_SESSION['user_role'] == 'Student') ||($_SESSION['user_role'] == 'Company' && $_SESSION['user_id']==$data['post']->CompanyID)):?>
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
                <?php endfor; ?>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/public/js/student/review_popup.js"></script>