<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/review.css">

<!-- Sidebar and Content Layout -->
<div class="content-area">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>

    <!-- Content Area -->
  

    <!-- Menu Icon -->
    <div class="menu-icon">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <div class="container">
        <h1>Welcome to Job Reviews Section!</h1>

        <!-- Review Filter -->
        <div class="filter">
            <button>All Reviews</button>
            <button>Positive Reviews</button>
            <button>Negative Reviews</button>
        </div>

        <!-- Review List -->
        <div class="review-list">
            <?php
            // Static reviews data
            $reviews = [
                ['name' => 'Sakuna Manamperi', 'rating' => 4, 'time' => '1 hour ago', 'review' => 'This is a really good Company. Highly recommended!', 'replies' => 2, 'icon' => 'check'],
                ['name' => 'Sakith Thewmika', 'rating' => 5, 'time' => '2 hours ago (Edited)', 'review' => 'Great Company and amazing people.', 'replies' => 1, 'icon' => 'clock'],
                ['name' => 'Shehara Gamage', 'rating' => 5, 'time' => '1 day ago', 'review' => 'Keeps getting better.', 'replies' => 0, 'icon' => 'check'],
                ['name' => 'Wameesha Rasanjani', 'rating' => 4, 'time' => '3 days ago', 'review' => 'Love coming into work everyday.', 'replies' => 0, 'icon' => 'check'],
            ];

            foreach ($reviews as $review) {
                echo '<div class="review">';
                echo '    <div class="review-header">';
                echo ' <span class="material-symbols-outlined large-icon">account_circle</span>';
                echo '        <div class="review-details">';
                echo '            <h3>' . $review['name'] . '</h3>';
                echo '            <div class="review-rating">' . str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']) . '</div>';
                echo '            <div class="review-time">' . $review['time'] . '</div>';
                echo '        </div>';
                echo '    </div>';
                echo '    <p class="review-text">"' . $review['review'] . '"</p>';
                echo '    <div class="review-footer">';
                echo '        <div class="replies">' . ($review['replies'] > 0 ? $review['replies'] . ' replies' : 'No replies') . '</div>';
                echo '        <div class="review-actions">';
                echo '            <span>Show more</span>';
                echo '            <span class="material-symbols-outlined">check_circle </span>';
                echo '            <span class="material-symbols-outlined">reply </span>';
                
                echo '        </div>';
                echo '    </div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

        </div>




