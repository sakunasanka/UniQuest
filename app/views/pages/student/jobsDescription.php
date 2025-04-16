<?php 
    if (!isset($_SESSION['user_role'])) {
        require APPROOT . '/views/components/header.php';
    }
    else if ($_SESSION['user_role'] == 'Student') {
        require APPROOT . '/views/components/stu_header.php';
    } else if ($_SESSION['user_role'] == 'Company') {
        require APPROOT . '/views/components/ser_header.php';
    } 
    else if ($_SESSION['user_role'] == 'Admin') {
        require APPROOT . '/views/components/adm_header.php';
    }
    else if ($_SESSION['user_role'] == 'VT-Member') {
        require APPROOT . '/views/components/ver_header.php';
    }
?>
<?php require APPROOT . '/views/popups/student/more_reviews.php'; ?>
<?php require APPROOT . '/views/popups/student/addReview_popup.php'; ?>
<?php require APPROOT . '/views/components/chat-sent.php'; ?>

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
        <div class="job-description">
            <div class="title-container">
                <h2><?php echo $data['post']->Title; ?></h2>
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Company'): ?>
                    <button onclick="goToApplications(<?php echo $post->JobID; ?>)" class="apply-btn">View Applications</button>
                <?php endif; ?>
            </div>
            <p><?php echo $data['post']->Location; ?></p>
            <h3>Description:</h3>
            <ul>
            <?php
                $description = $data['post']->Description ?? ''; 

                if (!empty(trim($description))) {
                    $descriptionArray = explode("\n", $description);

                    foreach ($descriptionArray as $desc) {
                        if (!empty(trim($desc))) {
                            echo '<li>' . htmlspecialchars(trim($desc)) . '</li>';
                        }
                    }
                } else {
                    echo '<li>No description availaible</li>';
                }
            ?>
            </ul>

            <h3>Qualifications:</h3>
            <ul>
            <?php
                $qualifications = $data['post']->RequiredQualifications ?? '';

                if (!empty(trim($qualifications))) {
                    $qualificationsArray = explode("\n", $qualifications);

                    foreach ($qualificationsArray as $qualification) {
                        if (!empty(trim($qualification))) {
                            echo '<li>' . htmlspecialchars(trim($qualification)) . '</li>';
                        }
                    }
                } else {
                    echo '<li>No qualifications to display</li>';
                }
            ?>
            </ul>

            <h3>Benefits:</h3>
            <ul>
            <?php
                $jobBenefits = $data['post']->JobBenefits ?? '';

                if (!empty(trim($jobBenefits))) {
                    $benefitArray = explode("\n", $jobBenefits);

                    foreach ($benefitArray as $benefit) {
                        if (!empty(trim($benefit))) {
                            echo '<li>' . htmlspecialchars(trim($benefit)) . '</li>';
                        }
                    }
                } else {
                    echo '<li>No benefits to display</li>';
                }
            ?>
            </ul>
            <?php  if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Student'):?>
                <p class="note">Please apply only if you are able to work in the mentioned locations in the advert</p>

                <div class="buttons">
                    <button onclick="goToApplyPage(<?php echo $post->JobID; ?>)" class="apply-btn">Apply</button>
                    <button id="openPopupBtn" class="contact-btn">Contact</button>
                </div>
            <?php else: ?>    
            <?php endif;?>   

            <div class="reviews-section">
                <h3>Reviews and Ratings about this company</h3>
                <?php if (!empty($data['reviews'])): ?>
                    <?php foreach ($data['reviews'] as $index => $review): ?>
                        <?php if ($index < 3): ?> <!-- Display only the first 3 reviews -->
                            <div class="review" id="page-review-<?php echo $index; ?>" data-id="<?php echo $index; ?>">
                                <p class="review-text">"<?php echo htmlspecialchars($review->Comment ?? ''); ?>"</p>
                                <div class="review-details">
                                    <span class="reviewer-name">- <?php echo htmlspecialchars($review->StudentName); ?></span>
                                    <span class="review-rating"><i class="fa fa-star"></i> <?php echo htmlspecialchars($review->Rating ?? ''); ?></span>
                                </div>
                                <?php if ((isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Student') || (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Company' && $_SESSION['user_id'] == $data['post']->CompanyID)): ?>
                                    <div class="review-actions">
                                        <button class="like-btn" data-id="<?php echo $index; ?>" data-review-id="<?php echo $review->ReviewID; ?>">
                                            <span class="material-symbols-outlined like-icon">thumb_up</span>
                                        </button>
                                        <span class="like-count" data-id="<?php echo $index; ?>"><?php echo htmlspecialchars($review->LikeCount); ?> likes</span>

                                        <button class="dislike-btn" data-id="<?php echo $index; ?>" data-review-id="<?php echo $review->ReviewID; ?>">
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
                        <button class="seemore" style="margin-top: 1px;"><p onclick="toggleMoreReviews()">See more reviews...</p></button>
                    <?php endif; ?>
                    
                <?php elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Company'): ?>
                    <button onclick="goToReport(<?php echo $post->JobID; ?>)" class="apply-btn">Generate Report</button>

                    <?php if (count($data['reviews']) >= 3): ?> 
                        <button class="seemore" style="margin-top: 1px;"><p onclick="toggleMoreReviews()">See more reviews...</p></button>
                    <?php endif; ?>
                    
                <?php else:?>    
                    <div></div>

                    <?php if (count($data['reviews']) >= 3): ?> 
                        <button class="seemore" style="margin-top: 1px;"><p onclick="toggleMoreReviews()">See more reviews...</p></button>
                    <?php endif; ?>
                    
                <?php endif; ?>
            </div>
            <?php  if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Student'):?>
                <div class="make-complain">
                    <button class="make-complain-btn"><p onclick="goToMakeComplaint(<?php echo $post->JobID; ?>)">Click here to make a complain about this job</p></button>
                </div>
            <?php endif;?>    
        </div>

        <div class="job-card">
            <?php  if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Student'):?>
                <div class="card-icons">
                    <i class="fa fa-share-alt" aria-hidden="true" onclick="shareJob(<?php echo $post->JobID; ?>, '<?php echo $post->Category; ?>')"></i>                     
                    <i class="<?php echo in_array($post->JobID, $data['bookmarkedJobIds']) ? 'fa-solid' : 'fa-regular'; ?> fa-bookmark" onclick="toggleBookmark(this); bookmarkJob(<?php echo $post->JobID; ?>, this)"></i>
                </div>
            <?php else:?>
                <div class="card-icons">
                <i class="fa fa-share-alt" aria-hidden="true" onclick="shareJob(<?php echo $post->JobID; ?>, '<?php echo $post->Category; ?>')"></i>
                </div>
            <?php endif;?> 
            <div class="job-logo">
                <img src="<?php echo empty($data['post']->CompanyLogo)
                                ? URLROOT . '/images/profile_pic_preview.png'
                                : UPLOADROOT . '/profile_pictures/company/' . $data['post']->CompanyLogo; ?>"
                    alt="Burger King Logo">
            </div>
            <div class="job-details">
                <h3><?php echo $data['post']->Title; ?></h3>
                <p><b>@<span><?php echo $data['post']->CompanyName; ?></b></span></p>
                
                <p><?php echo converttimetoreadableformat($post->jobs_create_at); ?></p>
                <p class="job-rating"><i class="fa fa-star"></i> <?php echo $data['displayRating']; ?></p>
                <p><?php echo $data['post']->Location; ?></p>
                <table class="table">
                    <tr><td>Salary:</td><td>Rs.<?php echo $data['post']->SalaryRange; ?> <?php echo $data['post']->SalaryType; ?></td></tr>
                    <tr><td>Category:</td><td><?php echo $data['post']->Category; ?></td></tr>
                    <tr><td>Applicants:</td><td>26</td></tr>
                </table>

                <div class="social-media-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="buttons">
                <button onclick="goToCompanyDescription(<?php echo $post->CompanyID; ?>)" class="apply-btn">View Company</button>
            </div>
        </div>    
    </div>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>

<script src="<?php echo URLROOT; ?>/public/js/student/jobsDescription.js"></script>

<script>
    
function goToMakeComplaint(jobId) {
    window.location.href = "/uniquest/student/make_complain/" + jobId;
}

function goToApplyPage(jobId) {
    window.location.href = "/UniQuest/student/jobsApplyform/" + jobId;
}

function goToReport(jobId) {
    window.location.href = "/uniquest/service_provider/report/" + jobId;
}

function toggleBookmark(icon, jobId) {
icon.classList.toggle("fa-regular");
icon.classList.toggle("fa-solid");
icon.classList.toggle("icon-active");
}

// Function to bookmark a job
function bookmarkJob(jobId, iconElement) {
    // Create a new FormData object to send the jobId
    const formData = new FormData();
    formData.append('job_id', jobId); // Append the job ID to the request data

    // Create a new XMLHttpRequest to send the data to the server

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '<?php echo URLROOT; ?>/jobs/toggleBookmark', true);

    // Set up the callback for when the request completes
    xhr.onload = function() {
        if (xhr.status === 200) {
            iconElement.classList.toggle('bookmarked'); // Toggle the bookmark icon
        } else {
            alert('Failed to bookmark the job.');
        }
    };

    // Send the request with the form data
    xhr.send(formData);
}

function shareJob(jobId, jobType) {
    const jobURL = `${window.location.origin}/UniQuest/jobs/jobsdescription/${jobId}`;
    
    navigator.clipboard.writeText(jobURL).then(() => {
        if (jobType === 'Part-time') {
            Flash.show('Job link copied to clipboard!', 'success');
        } else if (jobType === 'Internship') {
            Flash.show('Internship link copied to clipboard!', 'success');
        } else {
            Flash.show('Link copied to clipboard!', 'success');
        }
    }).catch(err => {
        Flash.show('Failed to copy link', 'error');
    });
}

function goToCompanyDescription($companyID) {
    window.location.href = "/uniquest/jobs/companydescription/"+$companyID;
}

function goToApplications(jobId) {
    window.location.href = "/UniQuest/service_provider/new_applications/" + jobId;
}
</script>