<?php require APPROOT . '/views/components/stu_header.php'; ?>
<?php require APPROOT . '/views/popups/student/more_reviews.php'; ?>
<?php require APPROOT . '/views/popups/student/addReview_popup.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/jobsDescription.css">

<div class="main-container">
    <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>
    
    <div class="content-area">
        <div class="job-description">
            <h2><?php echo $data['post']->Title; ?></h2>
            <p><?php echo $data['post']->Location; ?></p>
            <h3>Description:</h3>
            <!-- <ul>
                <li><?php echo $data['post']->Description; ?></li>
            </ul> -->
            <ul>
            <?php
                $description = $data['post']->Description;

                // Split the string into an array. Change the delimiter as needed (e.g., ',' or ';').
                $descriptionArray = explode("\n", $description);

                // Generate the list items
                foreach ($descriptionArray as $description) {
                    // Trim any extra spaces and output the <li> tag
                    if (!empty(trim($description))) {
                        echo '<li>' . htmlspecialchars(trim($description)) . '</li>';
                    }
                }
            ?>
            </ul>
            <h3>Qualifications:</h3>
            <!-- <ul>
                <li><?php echo $data['post']->RequiredQualifications; ?></li>
                <li>With a valid driver's license</li>
                <li>Should own a Motorbike</li>
            </ul> -->
            <ul>
            <?php
                $qualifications = $data['post']->RequiredQualifications;

                // Split the string into an array. Change the delimiter as needed (e.g., ',' or ';').
                $qualificationsArray = explode("\n", $qualifications);

                // Generate the list items
                foreach ($qualificationsArray as $qualification) {
                    // Trim any extra spaces and output the <li> tag
                    if (!empty(trim($qualification))) {
                        echo '<li>' . htmlspecialchars(trim($qualification)) . '</li>';
                    }
                }
            ?>
            </ul>

            <h3>Benefits:</h3>
            <!-- <ul>
                <li><?php echo $data['post']->JobBenefits; ?></li>
                <li>Special Extra Allowances</li>
                <li>Meals during service hours</li>
                <li>Accommodation is provided</li>
            </ul> -->
            <ul>
            <?php
                $jobBenefits = $data['post']->JobBenefits;

                // Split the string into an array. Change the delimiter as needed (e.g., ',' or ';').
                $benefitArray = explode("\n", $jobBenefits);

                // Generate the list items
                foreach ($benefitArray as $benefit) {
                    // Trim any extra spaces and output the <li> tag
                    if (!empty(trim($benefit))) {
                        echo '<li>' . htmlspecialchars(trim($benefit)) . '</li>';
                    }
                }
            ?>
            </ul>
            <?php  if ($_SESSION['user_role'] == 'Student'):?>
                <p class="note">Please apply only if you are able to work in the mentioned locations in the advert</p>

                <div class="buttons">
                    <button onclick="goToApplyPage(<?php echo $post->JobID; ?>)" class="apply-btn">Apply</button>
                    <button onclick="goToContactPage()" class="contact-btn">Contact</button>
                </div>
            <?php endif;?>    

            <div class="reviews-section">
                <h3>Reviews and Ratings about this company</h3>

                 <!-- Reviews on Main Page -->
                 <?php for ($i = 0; $i < 3; $i++): ?>
                    <div class="review" id="page-review-<?php echo $i; ?>" data-id="<?php echo $i; ?>">
                        <p class="review-text">"Great company to work for! Management is supportive, with benefits like meals and accommodation."</p>
                        <div class="review-details">
                            <span class="reviewer-name">- John Doe</span>
                            <span class="review-rating"><i class="fa fa-star"></i> 5.0</span>
                        </div>
                        <?php  if (($_SESSION['user_role'] == 'Student') ||($_SESSION['user_role'] == 'Company' && $_SESSION['user_id']==$data['post']->CompanyID)):?>
                            <div class="review-actions">
                                <button class="like-btn" data-id="<?php echo $i; ?>">
                                    <span class="material-symbols-outlined like-icon">thumb_up</span>
                                </button>
                                <span class="like-count" data-id="<?php echo $i; ?>">0 likes</span>

                                <button class="dislike-btn" data-id="<?php echo $i; ?>">
                                    <span class="material-symbols-outlined dislike-icon">thumb_down</span>
                                </button>
                                <span class="dislike-count" data-id="<?php echo $i; ?>">0 dislikes</span>
                            </div>
                        <?php endif;?>    
                    </div>
                <?php endfor; ?>
            </div>

            <div class="buttons btn-space-between">
            <?php  if ($_SESSION['user_role'] == 'Student'):?>
                <button onclick="ToggleAddReview()" class="apply-btn">Add review</button>
               
                <button class="seemore"><p onclick="toggleMoreReviews()">See more reviews...</p></button>
            <?php else:?>
                <div></div>
                <button class="seemore" style="margin-top: 1px;"><p onclick="toggleMoreReviews()">See more reviews...</p></button>
        
            <?php endif;?>    
            </div>
            <?php  if ($_SESSION['user_role'] == 'Student'):?>
                <div class="make-complain">
                    <button class="make-complain-btn"><p onclick="goToMakeComplaint(<?php echo $post->JobID; ?>)">Click here to make a complain about this job</p></button>
                </div>
            <?php endif;?>    
        </div>

        <div class="job-card">
            <?php  if ($_SESSION['user_role'] == 'Student'):?>
                <div class="card-icons">
                    <i class="fa-regular fa-heart" onclick="toggleFavorite(this)"></i>
                    <i class="fa fa-share-alt" aria-hidden="true"></i>
                                    
                    <i class="<?php echo in_array($post->JobID, $data['bookmarkedJobIds']) ? 'fa-solid' : 'fa-regular'; ?> fa-bookmark" onclick="toggleBookmark(this); bookmarkJob(<?php echo $post->JobID; ?>, this)"></i>
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
                <p><?php echo $data['post']->SalaryRange; ?></p>
                <p><?php echo converttimetoreadableformat($post->jobs_create_at); ?></p>
                <p class="job-rating"><i class="fa fa-star"></i> 4.8</p>
                <p><?php echo $data['post']->Location; ?></p>
                <table class="table">
                    <tr><td>Experience:</td><td>No Experience</td></tr>
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
<script type="module" src="<?php echo URLROOT; ?>/public/js/student/jobBookmark.js"></script>

<script>
    function goToMakeComplaint(jobId) {
        window.location.href = "/uniquest/student/make_complain/" + jobId;
    }
</script>

<script>
    function goToApplyPage(jobId) {
        window.location.href = "/UniQuest/student/jobsApply/" + jobId;
    }
</script>

<script>
    function toggleFavorite(icon) {
    icon.classList.toggle("fa-regular");
    icon.classList.toggle("fa-solid");
    icon.classList.toggle("icon-active");
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

function goToCompanyDescription($companyID) {
    window.location.href = "/uniquest/student/companydescription/"+$companyID;
}
</script>