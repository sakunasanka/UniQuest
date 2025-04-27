
<?php require APPROOT . '/views/components/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/rate_review_company.css">

<div class="content-area">
    <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>

    <div class="container">
        <h1>Rate and Review Company</h1>
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
                <textarea name="comment" placeholder="Share your experiences" required value = "<?php echo $data['comment']?>"></textarea>
                <span class="error-msg"><?php echo !empty($data['comment_err']) ? $data['comment_err'] : ''; ?></span>

                <input type="hidden" name="company_id" value="<?php echo htmlspecialchars($data['company_id']); ?>">


                <button type="submit">Submit Review</button>
            </form>
        </div>
        <h2>Student Reviews</h2>
        <div class="student-reviews">
            <?php if (!empty($data['reviews'])): ?>
                <?php foreach ($data['reviews'] as $review): ?>
                    <div class="review-card">
                        <h3><?php echo htmlspecialchars($review->CompanyID); ?></h3>
                        <div class="rating">Rating: <?php echo $review->Rating; ?> ★</div>
                        <p><?php echo ($review->Comment); ?></p>
                        <form action="<?php echo URLROOT; ?>/student/editReview/<?php echo $review->id; ?>" method="POST" class="edit-form">
                            <button type="submit" class="edit-btn">Edit</button>
                        </form> 
                        <form action="<?php echo URLROOT; ?>/student/deleteReview/<?php echo $review->id; ?>" method="POST" class="delete-form">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>  
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No reviews available for this company.</p>
            <?php endif; ?>
        </div>
    </div>

</div>



    <script type="module" src="<?php echo URLROOT; ?>/public/js/student/starhover.js"></script>