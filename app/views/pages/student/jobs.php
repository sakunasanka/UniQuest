<?php require APPROOT . '/views/components/stu_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/jobs.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="main-container">
    <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>
    
    <div class="content-area">
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/uniquest/student/jobs">Part Time Jobs</button>
            <button class="tab" style="border-radius: 0px 0px 0px 0px;" data-path="/uniquest/student/internships">Internships</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/uniquest/student/company">Companies</button>
        </div>
        <div class="container">
            <div class="search-bar-container">
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
            </div>
            
            <div class="cards-container">
                <form id="bookmarkForm" method="POST" action="<?php echo URLROOT; ?>/student/addBookmarkJob" class="hidden-form"></form>
                <?php foreach($data['posts'] as $post): ?>
                    <div class="card">
                        <div class="card-logo" onclick="goToJobDescription(<?php echo $post->JobID; ?>)">
                            <img src="<?php echo URLROOT; ?>/images/job.png" alt="job">
                        </div>
                        <div class="card-content">
                            <div class="content-hover-class" onclick="goToJobDescription(<?php echo $post->JobID; ?>)">
                                <div class="title-content">
                                    <h3 class="job-title"><?php echo $post->Title; ?></h3>
                                    <div class="job-rating">
                                        <i class="fa fa-star"></i> 4.8
                                    </div>
                                </div>
                                <p class="company-name"><b><?php echo $post->CompanyName; ?></b></p>
                                <p class="job-salary"><?php echo $post->SalaryRange; ?></p>
                                <p class="job-days-left"><?php echo converttimetoreadableformat($post->jobs_create_at); ?></p>
                                
                                <div class="job-location-details">
                                        <?php echo $post->Location; ?>
                                </div>
                            </div>
                            <div class="card-icons">
                                <i class="fa-regular fa-heart" onclick="toggleFavorite(this)"></i>
                                <i class="fa fa-share-alt" aria-hidden="true"></i>
                                <i class="fa-regular fa-bookmark" onclick="toggleBookmark(this); bookmarkJob(<?php echo $post->JobID; ?>, this)"></i>
                            </div>
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
    </div>
</div>

<style>
    .icon-active {
        color: #e74c3c; /* Active color */
    }
</style>

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
                alert(xhr.responseText); // Show the server response (e.g., success message)
                iconElement.classList.toggle('bookmarked'); // Toggle the bookmark icon
            } else {
                alert('Failed to bookmark the job.');
            }
        };

        // Send the request with the form data
        xhr.send(formData);
    }

</script>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<?php require APPROOT . '/views/components/footer.php'; ?>

<!-- <script>
    function goToJobDescription(jobId) {
        window.location.href = "/uniquest/student/jobsdescription/" + jobId;
    }
</script> -->