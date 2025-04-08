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

<?php if (isset($_GET['pending'])): ?>
    <div id="pendingVerificationPopup" class="popup-overlay" style="display: none;">
        <?php require APPROOT . '/views/popups/wait_to_verify_popup.php'; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the popup element
            const popup = document.getElementById('pendingVerificationPopup');
            
            // Show the popup
            if (popup) {
                popup.style.display = 'block';
            }
        });
    </script>
<?php endif; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/jobs.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/jobs">Part Time Jobs</button>
            <button class="tab" style="border-radius: 0px 0px 0px 0px;" data-path="/UniQuest/internships">Internships</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/companies">Companies</button>
        </div>
        <div class="container">

            <?php require APPROOT . '/views/components/searchBar.php'; ?>


            <!-- <div class="search-bar-container">
                <div class="search-bar">
                    <div class="search-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input type="text" placeholder="Search jobs, internships..." class="search-input">
                    <div class="filters-button">
                        <i class="fa-solid fa-filter"></i>
                        <span>Filters</span>
                    </div>
                </div>
            </div> -->
            <div class="cards-container">
                <form id="bookmarkForm" method="POST" action="<?php echo URLROOT; ?>/student/addBookmarkJob" class="hidden-form"></form>
                <?php foreach ($data['posts'] as $post): ?>
                    <div class="card">
                        <div class="card-logo" onclick="goToJobDescription(<?php echo $post->JobID; ?>)">
                            <img src="<?php echo empty($post->CompanyLogo)
                                            ? URLROOT . '/images/profile_pic_preview.png'
                                            : UPLOADROOT . '/profile_pictures/company/' . $post->CompanyLogo; ?>"
                                alt="Company Logo">
                        </div>
                        <div class="card-content">
                            <div class="content-hover-class" onclick="goToJobDescription(<?php echo $post->JobID; ?>)">
                                <div class="title-content">
                                    <h3 class="job-title"><?php echo $post->Title; ?></h3>
                                    <div class="job-rating">
                                        <i class="fa fa-star"></i>
                                        <?php
                                        if (isset($data['displayRatings'][$post->CompanyID]) && $data['displayRatings'][$post->CompanyID] != 0) {
                                            echo round($data['displayRatings'][$post->CompanyID], 2);
                                        } else {
                                            echo 'N/A';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <p class="company-name"><b><?php echo $post->CompanyName; ?></b></p>
                                <p class="job-salary"><?php echo 'Rs.'?><?php echo $post->SalaryRange; ?> <?php echo $post->SalaryType; ?></p>
                                <p class="job-days-left"><?php echo converttimetoreadableformat($post->jobs_create_at); ?></p>

                                <div class="job-location-details">
                                    <?php echo $post->Location; ?>
                                </div>
                            </div>
                            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Student'): ?>
                                <div class="card-icons">
                                    <i class="fa fa-share-alt" aria-hidden="true"></i>
                                    <i class="<?php echo in_array($post->JobID, $data['bookmarkedJobIds']) ? 'fa-solid' : 'fa-regular'; ?> fa-bookmark" onclick="toggleBookmark(this); bookmarkJob(<?php echo $post->JobID; ?>, this)"></i>
                                </div>
                            <?php else:?>
                                <div class="card-icons">
                                    <i class="fa fa-share-alt" aria-hidden="true"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="social-media-icons">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
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

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<?php require APPROOT . '/views/components/footer.php'; ?>

<script>
    function goToJobDescription(jobId) {
        window.location.href = "/UniQuest/jobs/jobsdescription/" + jobId;
    }
</script>

<script>
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
</script>