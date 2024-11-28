<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/studentPopups.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/review_popup.css">
<div class="popup-container bottom-div">
    <div class="popup" id="popup-editreview">
        <div class="overlay"></div>
        <div class="content popup_top_padding">
        <div class="close-btn-container"><button class="close-btn" onclick="ToggleEditReview()"><i class="fa fa-times"></i></button></div>
            <div class="review-form">
                <h2>Share your experience</h2>
                <form action="<?php echo URLROOT; ?>/student/updateReview/<?php echo $data['review_id']; ?>" method="POST">
                    <!-- Rating Input -->
                    <div class="rating-stars">

                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" <?php echo ($data['rating'] == $i) ? 'checked' : ''; ?>>
                            <label for="star<?php echo $i; ?>">★</label>
                        <?php endfor; ?>


                    </div>
                    <span class="error-msg"><?php echo !empty($data['rating_err']) ? $data['rating_err'] : ''; ?></span>

                    <!-- Comment Input -->
                    <textarea name="comment" placeholder="Share your experiences" required value = "<?php echo $data['comment']?>"><?php echo $data['comment']?></textarea>
                    <span class="error-msg"><?php echo !empty($data['comment_err']) ? $data['comment_err'] : ''; ?></span>

                    <input type="hidden" name="company_id" value="<?php echo htmlspecialchars($data['company_id']); ?>">


                    <button type="submit">Submit Review</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/public/js/student/editReview_popup.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/student/starhover.js"></script>
