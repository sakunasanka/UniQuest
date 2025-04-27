<?php require APPROOT . '/views/components/header.php'; ?>
<?php require APPROOT . '/views/popups/student/more_reviews.php'; ?>
<?php require APPROOT . '/views/popups/student/addReview_popup.php'; ?>
<?php require APPROOT . '/views/components/chat-sent.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/view_profile.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/jobsDescription.css">

<?php if (isset($_SESSION['user_role'])): ?>
<?php else: ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/guest_user.css">
<?php endif; ?>

<div class="main-container">
    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Student'): ?>
        <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>
    <?php elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Company'): ?>
        <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>
    <?php elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin'): ?>
        <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>
    <?php elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'VT-Member'): ?>
        <?php require APPROOT . '/views/components/verificationTeamSidePanel.php'; ?>
    <?php endif; ?>

    <div class="content-area">
        <div class="view-card">
            <div class="job-logo2">
                <img src="<?php echo empty($data['post']->CompanyLogo)
                                ? URLROOT . '/images/profile_pic_preview.png'
                                : UPLOADROOT . '/profile_pictures/company/' . $data['post']->CompanyLogo; ?>"
                    alt="Burger King Logo">
            </div>

            <div class="view-card-content">
                <div class="title-with-bookmark">
                    <h1><?php echo $data['post']->CompanyName; ?></h1>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Student'): ?>
                        <div class="card-icons">
                            <i class="fa fa-share-alt" aria-hidden="true" onclick="shareJob(<?php echo $post->UserID; ?>)"></i>
                            <i class="<?php echo in_array($post->UserID, $data['bookmarkedCompanyIds']) ? 'fa-solid' : 'fa-regular'; ?> fa-bookmark" onclick="toggleBookmark(this); bookmarkCompany(<?php echo $post->UserID; ?>, this);"></i>
                        </div>
                    <?php else: ?>
                        <div class="card-icons">
                            <i class="fa fa-share-alt" aria-hidden="true" onclick="shareJob(<?php echo $post->UserID; ?>)"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <h2><?php echo $data['post']->Industry; ?></h2>
                <p><?php echo $data['post']->Description; ?></p>

                <div class="view-card-info">
                    <div>
                        <span>Address</span>
                        <?php echo $data['post']->Address; ?>
                    </div>
                    <div>
                        <span>Contact No</span>
                        <?php echo $data['post']->ContactNo; ?>
                    </div>
                    <div>
                        <span>Email</span>
                        <?php echo $data['post']->Email; ?>
                    </div>
                </div>
                <div class="view-card-info">
                    <?php if (!empty($data['post']->Website)): ?>
                        <div>
                            <span>Website</span>
                            <?php
                            $website = $data['post']->Website;
                            // Ensure website has proper protocol
                            if (!preg_match("~^(?:f|ht)tps?://~i", $website)) {
                                $website = "https://" . ltrim($website, '/');
                            }
                            ?>
                            <a href="<?php echo htmlspecialchars($website); ?>" target="_blank" rel="noopener noreferrer">
                                <?php echo htmlspecialchars(parse_url($website, PHP_URL_HOST) ?: $website); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($data['post']->LinkedIn)): ?>
                        <div>
                            <span>LinkedIn</span>
                            <?php
                            $linkedin = $data['post']->LinkedIn;
                            // Format LinkedIn URL properly
                            if (!preg_match("~^(?:f|ht)tps?://~i", $linkedin)) {
                                $linkedin = "https://www.linkedin.com/" . ltrim($linkedin, '/');
                            }
                            ?>
                            <a href="<?php echo htmlspecialchars($linkedin); ?>" target="_blank" rel="noopener noreferrer">
                                linkedin.com/<?php echo htmlspecialchars(basename($linkedin)); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($data['post']->Facebook)): ?>
                        <div>
                            <span>Facebook</span>
                            <?php
                            $facebook = $data['post']->Facebook;
                            // Format Facebook URL properly
                            if (!preg_match("~^(?:f|ht)tps?://~i", $facebook)) {
                                $facebook = "https://www.facebook.com/" . ltrim($facebook, '/');
                            }
                            ?>
                            <a href="<?php echo htmlspecialchars($facebook); ?>" target="_blank" rel="noopener noreferrer">
                                facebook.com/<?php echo htmlspecialchars(basename($facebook)); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Student' || $_SESSION['user_role'] == 'Admin'): ?>
                    <div class="buttons">
                        <button id="openPopupBtn" class="contact-btn-2">Contact</button>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="view-card">
            <div class="job-list">
                <?php if (empty($data['jobs'])): ?>
                    <div class="job-header">
                        <div>
                            <h5><?php echo ("No available jobs to show."); ?></h5>
                        </div>
                    </div>
                <?php else: ?>

                    <?php foreach ($data['jobs'] as $index => $job): ?>
                        <div class="job-item" onclick="goToJobDescription(<?php echo ($job->JobID); ?>)">
                            <div class="job-header">
                                <div>
                                    <h5><?php echo ($job->Title); ?></h5>
                                </div>
                            </div>
                            <div class="job-tags">
                                <span class="tag"><?php echo ($job->Category); ?></span>
                            </div>
                            <div>
                                <p>Location: <?php echo ($job->City); ?></p>
                            </div>
                            <div>
                                <p>Salary: Rs.<?php echo ($job->SalaryRange); ?> <?php echo ($job->SalaryType); ?></p>
                            </div>
                            <div>
                                <p>Published On: <?php echo converttimetoreadableformat($job->PublishDate); ?></p>
                            </div>
                            </br>
                            <div class="job-actions">
                                <button class="details-btn">View Details</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="view-card view-card-2">
            <div class="reviews-section">
                <h3>Reviews and Ratings about this company</h3>
                <?php if (!empty($data['reviews'])): ?>
                    <?php foreach ($data['reviews'] as $index => $review): ?>
                        <?php if ($index < 3): ?> 
                            <div class="review" id="page-review-<?php echo $index; ?>" data-id="<?php echo $index; ?>">
                                <p class="review-text">"<?php echo ($review->Comment ?? ''); ?>"</p>
                                <div class="review-details">
                                    <span class="reviewer-name">- <?php echo ($review->StudentName); ?></span>
                                    <span class="review-rating"><i class="fa fa-star"></i> <?php echo htmlspecialchars($review->Rating ?? ''); ?></span>
                                </div>
                                <?php if ((isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Student') || (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Company')): ?>
                                    <div class="review-actions">
                                        <button class="like-btn <?php echo $review->is_liked ? 'liked' : ''; ?>" data-id="<?php echo $index; ?>" data-review-id="<?php echo $review->ReviewID; ?>">
                                            <span class="material-symbols-outlined like-icon">thumb_up</span>
                                        </button>
                                        <span class="like-count" data-id="<?php echo $index; ?>"><?php echo htmlspecialchars($review->LikeCount); ?> likes</span>

                                        <button class="dislike-btn <?php echo $review->is_disliked ? 'disliked' : ''; ?>" data-id="<?php echo $index; ?>" data-review-id="<?php echo $review->ReviewID; ?>">
                                            <span class="material-symbols-outlined dislike-icon">thumb_down</span>
                                        </button>
                                        <span class="dislike-count" data-id="<?php echo $index; ?>"><?php echo htmlspecialchars($review->DislikeCount); ?> dislikes</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No reviews available.</p>
                <?php endif; ?>
            </div>
            <div class="buttons btn-space-between">
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Student'): ?>
                    <button onclick="ToggleAddReview()" class="apply-btn">Add review</button>

                    <?php if (count($data['reviews']) >= 3): ?>
                        <button class="seemore" style="margin-top: 1px;">
                            <p onclick="toggleMoreReviews()">See more reviews...</p>
                        </button>
                    <?php endif; ?>

                <?php else: ?>
                    <div></div>

                    <?php if (count($data['reviews']) >= 3): ?>
                        <button class="seemore" style="margin-top: 1px;">
                            <p onclick="toggleMoreReviews()">See more reviews...</p>
                        </button>
                    <?php endif; ?>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>

<script src="<?php echo URLROOT; ?>/public/js/student/jobsDescription.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/student/myreviews.js"></script>

<script>
    function goToJobDescription(jobId) {
        window.location.href = "/UniQuest/jobs/jobsdescription/" + jobId;
    }
</script>

<script>
    function toggleBookmark(icon, companyId) {
        icon.classList.toggle("fa-regular");
        icon.classList.toggle("fa-solid");
        icon.classList.toggle("icon-active");
    }

    // Function to bookmark a company
    function bookmarkCompany(companyId, iconElement) {
        // Create a new FormData object to send the companyId
        const formData = new FormData();
        formData.append('company_id', companyId); // Append the company ID to the request data
        // Create a new XMLHttpRequest to send the data to the server

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '<?php echo URLROOT; ?>/company/toggleBookmark', true);

        // Set up the callback for when the request completes
        xhr.onload = function() {
            if (xhr.status === 200) {
                iconElement.classList.toggle('bookmarked'); // Toggle the bookmark icon
            } else {
                Flash.show('Failed to bookmark company', 'error');
            }
        };

        // Send the request with the form data
        xhr.send(formData);
    }

    function shareJob(companyId) {
        const jobURL = `${window.location.origin}/UniQuest/jobs/companydescription/${companyId}`;

        navigator.clipboard.writeText(jobURL).then(() => {
            Flash.show('Company link copied to clipboard!', 'success');
        }).catch(err => {
            Flash.show('Failed to copy link', 'error');
        });
    }
</script>