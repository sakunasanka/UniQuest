<?php require APPROOT . '/views/components/stu_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/rate_review_company.css">

<!-- Sidebar and Content Layout -->
<div class="content-area">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <div class="container">
        <h1>Rate and Review Company</h1>

        <!-- Review Form (Static, Doesn't submit data) -->
        <div class="review-form">
            <h2>Share your experience</h2>
            <form>
                <div class="rating-stars">
                    <input type="radio" id="star1" name="rating" value="1">
                    <label for="star1">★</label>
                    <input type="radio" id="star2" name="rating" value="2">
                    <label for="star2">★</label>
                    <input type="radio" id="star3" name="rating" value="3">
                    <label for="star3">★</label>
                    <input type="radio" id="star4" name="rating" value="4">
                    <label for="star4">★</label>
                    <input type="radio" id="star5" name="rating" value="5">
                    <label for="star5">★</label>
                </div>

                <input type="text" name="job_title" placeholder="Enter your job title" required>

                <textarea name="review" placeholder="Share your experiences" required></textarea>

                <button type="submit">Submit Review</button>
            </form>
        </div>

        <!-- Static Student Reviews -->
        <h2>Student Reviews</h2>
        <div class="student-reviews">
          

            <div class="review-card">
                <h3>Acme Inc.</h3>
                <div class="rating">Rating: 4.8 ★</div>
                <p>I had a great experience working at Acme Inc. The staff was friendly and supportive, and the work was both engaging and rewarding.</p>
            </div>

            <div class="review-card">
                <h3>Globex Corporation</h3>
                <div class="rating">Rating: 4.6 ★</div>
                <p>I had a fantastic experience interning at Globex Corporation. The work was challenging and rewarding, and the company culture was incredibly supportive.</p>
            </div>

            <div class="review-card">
                <h3>Yala Safari Beach Hotel (PVT) Ltd</h3>
                <div class="rating">Rating: 4.3 ★</div>
                <p>Yala Safari Beach part-time jobs provide a great outdoor experience, perfect for nature lovers and those who enjoy working with tourists.</p>
            </div>

            <div class="review-card">
                <h3>Yarl Hotels (PVT) Ltd</h3>
                <div class="rating">Rating: 4.7 ★</div>
                <p>Good job.</p>
            </div>

            <div class="review-card">
                <h3>Meta</h3>
                <div class="rating">Rating: 4.8 ★</div>
                <p>Meta is highly regarded for its innovation and futuristic concepts but some concerns about privacy and data usage.</p>
            </div>

            <div class="review-card">
                <h3>Zyrex Power Company Ltd</h3>
                <div class="rating">Rating: 4.5 ★</div>
                <p>Zyrex Power Company Ltd is praised for reliable solutions and excellent customer service.</p>
            </div>

            <div class="review-card">
                <h3>Spotify</h3>
                <div class="rating">Rating: 4.4 ★</div>
                <p>The internship was challenging but provided valuable experience.</p>
            </div>

            <div class="review-card">
                <h3>Salesforce</h3>
                <div class="rating">Rating: 4.1 ★</div>
                <p>Customers love Salesforce for its powerful CRM features but mention that it can be pricey and sometimes difficult to use.</p>
            </div>
        </div>
    </div>

    <script type="module" src="<?php echo URLROOT; ?>/public/js/student/starhover.js"></script>
