<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/studentPopups.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/review_popup.css">
<div class="popup-container bottom-div">
    <div class="popup" id="popup-addreview">
        <div class="overlay"></div>
        <div class="content popup_top_padding">
        <div class="close-btn-container"><button class="close-btn" onclick="ToggleAddReview()"><i class="fa fa-times"></i></button></div>
            <div class="review-form">
                <h2>Share your experience</h2>
                <form action="<?php echo URLROOT ?>/student/addReview" method="POST">
                    <div class="rating-stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" <?php echo ($data['rating'] == $i) ? 'checked' : ''; ?>>
                            <label for="star<?php echo $i; ?>">★</label>
                        <?php endfor; ?>

                    </div>
                    <span class="error-msg"><?php echo !empty($data['rating_err']) ? $data['rating_err'] : ''; ?></span>

                    <textarea name="comment" placeholder="Share your experiences" required><?php echo $data['comment']; ?></textarea>
                    <span class="error-msg"><?php echo !empty($data['comment_err']) ? $data['comment_err'] : ''; ?></span>

                    <input type="hidden" name="company_id" value="<?php echo htmlspecialchars($data['company_id']); ?>">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($data['user_id']); ?>">
                    <input type="hidden" name="existingReview" value="<?php echo $data['existingReview'] ? 'true' : 'false'; ?>">

                    <button type="submit"><?php echo $data['existingReview'] ? 'Update Review' : 'Submit Review'; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/public/js/student/addReview_popup.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/student/starhover.js"></script>
