<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/jobs.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Add near your user profile dropdown -->
    

<!-- Include CSS -->
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/notifications.css">

<!-- Include JavaScript -->
<script src="<?php echo URLROOT; ?>/js/notifications.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

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
        <div class="container">
        <?php $columns = [
            'CompanyName' => 'Company Name',
            'City' => 'Location',
            'Industry' => 'Industry',
            'Rating' => 'Rating'
            ]; ?>
            <?php require APPROOT . '/views/components/searchBarComp.php'; ?>
            <div class="cards-container">
                <?php if(empty($data['posts'])): ?>
                    <div class="no-results">No results found.</div>
                <?php endif; ?>
                <?php foreach ($data['posts'] as $post): ?>
                    <div class="card">
                        <div class="card-logo" onclick="goToCompanyDescription(<?php echo $post->UserID; ?>)">
                            <img
                                src="<?php echo empty($post->CompanyLogo)
                                            ? URLROOT . '/images/profile_pic_preview.png'
                                            : UPLOADROOT . '/profile_pictures/company/' . $post->CompanyLogo; ?>"
                                alt="Profile Picture">
                        </div>
                        <div class="card-content">
                            <div class="content-hover-class" onclick="goToCompanyDescription(<?php echo $post->UserID; ?>)">
                                <div class="title-content">
                                    <h3 class="company-title"><?php echo $post->CompanyName; ?></h3>
                                    <div class="job-rating">
                                        <i class="fa fa-star"></i>
                                        <?php
                                        if (isset($data['displayRatings'][$post->UserID]) && $data['displayRatings'][$post->UserID] != 0) {
                                            echo round($data['displayRatings'][$post->UserID], 2);
                                        } else {
                                            echo 'N/A';
                                        }
                                        ?>
                                    </div>
                                </div>


                                <div class="job-location-details">
                                    <?php echo $post->City; ?>
                                </div>
                            </div>

                            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Student'): ?>
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
                        <div class="social-media-icons">
                            <?php if (!empty($post->Website)): ?>
                                <?php $website = (strpos($post->Website, 'http') === 0) ? $post->Website : 'https://' . $post->Website; ?>
                                <a href="<?php echo htmlspecialchars($website); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    aria-label="Company website">
                                    <i class="fas fa-globe"></i>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($post->LinkedIn)): ?>
                                <?php $linkedin = (strpos($post->LinkedIn, 'http') === 0) ? $post->LinkedIn : 'https://www.linkedin.com/' . ltrim($post->LinkedIn, '/'); ?>
                                <a href="<?php echo htmlspecialchars($linkedin); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    aria-label="LinkedIn profile">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($post->Facebook)): ?>
                                <?php $facebook = (strpos($post->Facebook, 'http') === 0) ? $post->Facebook : 'https://www.facebook.com/' . ltrim($post->Facebook, '/'); ?>
                                <a href="<?php echo htmlspecialchars($facebook); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    aria-label="Facebook page">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php require APPROOT . '/views/components/pagination.php'; ?>
    </div>
</div>

<style>
    .icon-active {
        color: #e74c3c;
        /* Active color */
    }
</style>

<?php require APPROOT . '/views/components/footer.php'; ?>

<script>
    function goToCompanyDescription(companyId) {
        window.location.href = "/UniQuest/jobs/companydescription/" + companyId;
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