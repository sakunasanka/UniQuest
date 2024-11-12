<?php require APPROOT . '/views/components/stu_header.php'; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/jobsDescription.css">

<div class="main-container">
    <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>

    <div class="content-area">
        <div class="job-description">
            <h2>Delivery Rider</h2>
            <p>Negombo / Ja Ela / Kiribathgoda</p>

            <h3>Qualifications:</h3>
            <ul>
                <li>Age Between 18 - 40</li>
                <li>With a valid driver's license</li>
                <li>Should own a Motorbike</li>
            </ul>

            <h3>Benefits:</h3>
            <ul>
                <li>Highest salary in the industry</li>
                <li>Special Extra Allowances</li>
                <li>Meals during service hours</li>
                <li>Accommodation is provided</li>
            </ul>

            <p class="note">Please apply only if you are able to work in the mentioned locations in the advert</p>

            <div class="buttons">
                <button onclick="goToApplyPage()" class="apply-btn">Apply</button>
                <button onclick="goToContactPage()" class="contact-btn">Contact</button>
            </div>

            <div class="reviews-section">
                <h4>Reviews and Ratings about this company</h4>

                <div class="review">
                    <p class="review-text">"Great company to work for! The management is very supportive, and they offer a lot of benefits like meals and accommodation."</p>
                    <div class="review-details">
                        <span class="reviewer-name">- John Doe</span>
                        <span class="review-rating"><i class="fa fa-star"></i> 5.0</span>
                    </div>
                </div>

                <div class="review">
                    <p class="review-text">"The salary is quite competitive compared to other companies, and they provide special allowances too."</p>
                    <div class="review-details">
                        <span class="reviewer-name">- Sarah Smith</span>
                        <span class="review-rating"><i class="fa fa-star"></i> 4.5</span>
                    </div>
                </div>

                <div class="review">
                    <p class="review-text">"I had a good experience working here. Flexible working hours and a friendly environment."</p>
                    <div class="review-details">
                        <span class="reviewer-name">- David Lee</span>
                        <span class="review-rating"><i class="fa fa-star"></i> 4.3</span>
                    </div>
                </div>
            </div>
            <div class="buttons">
                <button onclick="goToAddReview()" class="apply-btn">Add review</button>
            </div>
        </div>

        <div class="job-card">
            <div class="job-logo">
                <img src="<?php echo URLROOT; ?>/images/Burger-logo.png" alt="Burger King Logo">
            </div>
            <div class="job-details">
                <h3>Delivery Rider</h3>
                <p>Negombo / Ja Ela / Kiribathgoda</p>
                <p>Rs. 2,000 (per day)</p>
                <p>9 days left</p>
                <p class="job-rating"><i class="fa fa-star"></i> 4.8</p>
                <p>Colombo, Western Province</p>
                <table class="table">
                    <tr><td>Education:</td><td>Ordinary Level</td></tr>
                    <tr><td>Experience:</td><td>No Experience</td></tr>
                    <tr><td>Salary Range:</td><td>Any</td></tr>
                </table>

                <div class="social-media-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="buttons">
                <button onclick="goToCompany()" class="apply-btn">View Company</button>
            </div>
        </div>     
    </div>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>

<script>
    function goToApplyPage() {
        window.location.href = "/uniquest/student/jobsapply"; 
    }

    function goToContactPage() {
        window.location.href = "/uniquest/student/contact_sp"; 
    }

    function goToAddReview() {
        window.location.href = "/uniquest/student/rate_review_company"; 
    }

    function goToCompany() {
        window.location.href = "/uniquest/student/companydescription"; 
    }
</script>
