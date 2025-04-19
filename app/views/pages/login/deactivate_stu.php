<?php require APPROOT . '/views/components/stu_header.php'; ?>
<?php require APPROOT . '/views/popups/deactivate_popup.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/jobs.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="main-container">
    <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>

    <div class="content-area">
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/student/jobs">Part Time Jobs</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/student/company">Companies</button>
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
                <?php for ($i = 0; $i < 6; $i++): ?>
                    <div class="card">
                        <div class="card-logo">
                            <img src="<?php echo URLROOT; ?>/images/job.png" alt="job">
                        </div>
                        <div class="card-content">
                            <div class="job-rating">
                                <i class="fa fa-star"></i> 4.8
                            </div>
                            <h3 class="job-title">Delivery Rider</h3>
                            <p class="job-location">Negombo / Ja Ela / Kiribathgoda</p>
                            <p class="job-salary">Rs. 2,000 (per day)</p>
                            <p class="job-days-left">9 days left</p>
                            
                            <div class="job-location-details">
                                Colombo, Western Province
                            </div>
                            <div class="card-icons">
                                <i class="fa fa-share-alt" aria-hidden="true"></i>
                                <i class="fa-regular fa-bookmark" onclick="toggleBookmark(this)"></i>
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
                <?php endfor; ?>
            </div>
        </div>  
    </div>
</div>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<?php require APPROOT . '/views/components/footer.php'; ?>