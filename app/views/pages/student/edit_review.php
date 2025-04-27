<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/edit_review.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/studentPopups.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/review_popup.css">

<div class="content-area">
    <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>

    <div class="container">
        <h1>Edit Your Review</h1>

        <div class="review-form">
            <h2>Share your experience</h2>
            <form action="<?php echo URLROOT; ?>/student/updateReview/<?php echo $data['review_id']; ?>" method="POST">
                <div class="rating-stars">

                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <input type="radio" id="star<?php echo $i; ?>" name="Rating" value="<?php echo $i; ?>" <?php echo ($data['rating'] == $i) ? 'checked' : ''; ?>>
                        <label for="star<?php echo $i; ?>">★</label>
                    <?php endfor; ?>


                </div>
                <span class="error-msg"><?php echo !empty($data['rating_err']) ? $data['rating_err'] : ''; ?></span>
                <textarea name="Comment" placeholder="Share your experiences" required value="<?php echo $data['comment'] ?>"><?php echo $data['comment'] ?></textarea>
                <span class="error-msg"><?php echo !empty($data['comment_err']) ? $data['comment_err'] : ''; ?></span>


                <button type="submit">Submit Review</button>
            </form>
        </div>
    </div>
</div>