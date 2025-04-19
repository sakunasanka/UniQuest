<?php require APPROOT . '/views/components/stu_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/jobs.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="main-container">
    <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>

    <div class="content-area">
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/student/saveJobs">Saved Jobs</button>
            <button class="tab" style="border-radius: 0px 0px 0px 0px;" data-path="/UniQuest/student/saveInternships">Saved Internships</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/student/saveCompanies">Saved Companies</button>
        </div>
        <div class="container">
        <?php $columns = [
                'jobs_create_at' => 'Newest',
                'Rating' => 'Highest Rating',
                'SalaryRange' => 'Highest Salary'
            ]; ?>
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
                <?php if(empty($data['posts'])): ?>
                    <div class="no-results">No results found.</div>
                <?php endif; ?>
            <?php foreach ($data['posts'] as $post): ?>
                    <div class="card">
                    <div class="card-logo" onclick="goToJobDescription(<?php echo $post->JobID; ?>)">
                            <img src="<?php echo empty($post->CompanyLogo)
                                            ? URLROOT . '/images/profile_pic_preview.png'
                                            : UPLOADROOT . '/profile_pictures/company/' . $post->CompanyLogo; ?>"
                                alt="Burger King Logo">
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
                            <div class="card-icons">
                                <i class="fa fa-share-alt" aria-hidden="true" onclick="shareJob(<?php echo $post->JobID; ?>)"></i>

                                <i class="<?php echo in_array($post->JobID, $data['bookmarkedJobIds']) ? 'fa-solid' : 'fa-regular'; ?> fa-bookmark" onclick="toggleBookmark(this); bookmarkInternship(<?php echo $post->JobID; ?>, this); // window.location.reload();"></i>
                            </div>
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
    </div>
</div>

<style>
    .icon-active {
        color: #e74c3c;
        /* Active color */
    }
</style>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/student/jobBookmark.js"></script>
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
    function bookmarkInternship(jobId, iconElement) {
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

    function shareJob(jobId) {
        const jobURL = `${window.location.origin}/UniQuest/jobs/jobsdescription/${jobId}`;
        
        navigator.clipboard.writeText(jobURL).then(() => {
            Flash.show('Internship link copied to clipboard!', 'success');
        }).catch(err => {
            Flash.show('Failed to copy link', 'error');
        });
    }
</script>