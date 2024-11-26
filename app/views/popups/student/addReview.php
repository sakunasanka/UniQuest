<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/studentPopups.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/rate_review_company.css">
<div class="popup-container">
    <div class="popup" id="popup-stu">
        <div class="overlay"></div>
        <div class="content">
            <div class="review-form">
                <h2>Share your experience</h2>
                <form action="<?php echo URLROOT ?>/student/addReview" method="POST">
                    <!-- Rating Input -->
                    <div class="rating-stars">

                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" <?php echo ($data['rating'] == $i) ? 'checked' : ''; ?>>
                            <label for="star<?php echo $i; ?>">★</label>
                        <?php endfor; ?>


                    </div>
                    <span class="error-msg"><?php echo !empty($data['rating_err']) ? $data['rating_err'] : ''; ?></span>

                    <!-- Comment Input -->
                    <textarea name="comment" placeholder="Share your experiences" required value = "<?php echo $data['comment']?>"></textarea>
                    <span class="error-msg"><?php echo !empty($data['comment_err']) ? $data['comment_err'] : ''; ?></span>

                    <input type="hidden" name="company_id" value="<?php echo htmlspecialchars($data['company_id']); ?>">


                    <button type="submit">Submit Review</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/public/js/student/change_password.js"></script>

