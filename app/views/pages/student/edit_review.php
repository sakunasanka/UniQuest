<?php require APPROOT . '/views/components/ser_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/edit_review.css">

<div class="content-area">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>

    <!-- Content Area -->
    <div class="container">
        <h1>Edit Your Review</h1>

        <div class="review-form">
            <form action="<?php echo URLROOT ?>/student/updateReview/<?php echo $data['review']->id; ?>" method="POST">
                <!-- Rating Input -->
                <div class="rating-stars">
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" <?php echo ($data['review']->Rating == $i) ? 'checked' : ''; ?>>
                        <label for="star<?php echo $i; ?>">★</label>
                    <?php endfor; ?>
                </div>
                <span class="error-msg"><?php echo !empty($data['rating_err']) ? $data['rating_err'] : ''; ?></span>

                <!-- Comment Input -->
                <textarea name="comment" placeholder="Edit your comment" required><?php echo htmlspecialchars($data['review']->Comment); ?></textarea>
                <span class="error-msg"><?php echo !empty($data['comment_err']) ? $data['comment_err'] : ''; ?></span>

                <button type="submit">Update Review</button>
            </form>
        </div>
    </div>
</div>