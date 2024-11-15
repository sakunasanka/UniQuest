<?php require APPROOT . '/views/components/stu_header.php'; ?>
<?php require APPROOT . '/views/popups/student/more_reviews.php'; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/jobsDescription.css">

<div class="main-container">
    <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>

    <div class="content-area">
        <div class="job-description">
            <h2><?php echo $data['post']->Title; ?></h2>
            <p><?php echo $data['post']->Location; ?></p>

            <h3>Qualifications:</h3>
            <ul>
                <li><?php echo $data['post']->RequiredQualifications; ?></li>
                <li>With a valid driver's license</li>
                <li>Should own a Motorbike</li>
            </ul>

            <h3>Benefits:</h3>
            <ul>
                <li><?php echo $data['post']->JobBenefits; ?></li>
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

                <?php for ($i = 0; $i < 3; $i++): ?>
                    <div class="review" id="review-<?php echo $i + 1; ?>">
                        <p class="review-text">"Great company to work for! The management is very supportive, and they offer a lot of benefits like meals and accommodation."</p>
                        <div class="review-details">
                            <span class="reviewer-name">- John Doe</span>
                            <span class="review-rating"><i class="fa fa-star"></i> 5.0</span>
                        </div>
                        <div class="review-actions">
                            <button class="like-btn" onclick="toggleLike('review-<?php echo $i + 1; ?>')">
                                <span class="material-symbols-outlined" id="like-icon-<?php echo $i + 1; ?>">thumb_up</span>
                            </button>
                            <span class="like-count" id="like-count-<?php echo $i + 1; ?>">0 likes</span>

                            <button class="dislike-btn" onclick="toggleDislike('review-<?php echo $i + 1; ?>')">
                                <span class="material-symbols-outlined" id="dislike-icon-<?php echo $i + 1; ?>">thumb_down</span>
                            </button>
                            <span class="dislike-count" id="dislike-count-<?php echo $i + 1; ?>">0 dislikes</span>

                            <button class="reply-btn" onclick="toggleReplyForm('review-<?php echo $i + 1; ?>')">
                                <span class="material-symbols-outlined" id="reply-icon">reply</span>
                            </button>
                            <span class="reply-count" id="reply-count-<?php echo $i + 1; ?>">0 replies</span>
                        </div>
                        <div class="reply-section" id="reply-section-<?php echo $i + 1; ?>" style="display: none;">
                            <textarea class="reply-input" id="reply-input-<?php echo $i + 1; ?>" placeholder="Write a reply..."></textarea>
                            <button class="submit-reply-btn" onclick="submitReply('review-<?php echo $i + 1; ?>')">Submit</button>
                            <div class="replies-list" id="replies-list-<?php echo $i + 1; ?>"></div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>

            <div class="buttons btn-space-between">
                <button onclick="goToAddReview()" class="apply-btn">Add review</button>
                <button class="seemore"><p onclick="toggleMoreReviews()">See more reviews...</p></button>
            </div>
        </div>

        <div class="job-card">
            <div class="job-logo">
                <img src="<?php echo URLROOT; ?>/images/Burger-logo.png" alt="Burger King Logo">
            </div>
            <div class="job-details">
                <h3><?php echo $data['post']->Title; ?></h3>
                <p><?php echo $data['post']->Location; ?></p>
                <p><?php echo $data['post']->SalaryRange; ?></p>
                <p><?php echo converttimetoreadableformat($post->jobs_create_at); ?></p>
                <p class="job-rating"><i class="fa fa-star"></i> 4.8</p>
                <p><?php echo $data['post']->Address; ?></p>
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

<script src="<?php echo URLROOT; ?>/public/js/student/jobsDescription.js"></script>
