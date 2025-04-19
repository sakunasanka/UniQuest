<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/jobs.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
            <!-- <div class="search-bar-container">
                <div class="search-bar">
                    <div class="search-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input type="text" placeholder="Search company..." class="search-input">
                    <div class="filters-button">
                        <i class="fa-solid fa-filter"></i>
                        <span>Filters</span>
                    </div>
                </div>
            </div> -->

            <h1 class= "H1">Trending Companies</h1>
            <h2 class= "H2">Check out the top-rated companies based on the student reviews</h2>

            <div class="cards-container">
                <?php if(empty($data['trendy_companies'])): ?>
                    <div class="no-results">No results found.</div>
                <?php endif; ?>
                
                <?php foreach($data['trendy_companies'] as $index=>$post): ?>

                    <div class="card">
                        <div class="card-logo" onclick="goToCompanyDescription(<?php echo $post['CompanyID']; ?>)">
                            <img
                                src="<?php echo empty($post['CompanyLogo'])
                                            ? URLROOT . '/images/profile_pic_preview.png'
                                            : UPLOADROOT . '/profile_pictures/company/' . $post['CompanyLogo']; ?>"
                                alt="Profile Picture">
                        </div>
                        <div class="card-content">
                            <div class="content-hover-class" onclick="goToCompanyDescription(<?php echo $post['CompanyID']; ?>)">
                                <div class="title-content">
                                    <h3 class="company-title"><?php echo $post['CompanyName']; ?></h3>
                                    <div class="job-rating">
                                        <i class="fa fa-star"></i>
                                        <?php
                                        if (isset($data['displayRatings'][$post['CompanyID']]) && $data['displayRatings'][$post['CompanyID']] != 0) {
                                            echo round($data['displayRatings'][$post['CompanyID']], 2);
                                        } else {
                                            echo 'N/A';
                                        }
                                        ?>
                                    </div>
                                </div>


                                <div class="job-location-details">
                                    <?php echo $post['City']; ?>
                                </div>
                            </div>

                            <?php if (isset($_SESSION['user_role']) && ($_SESSION['user_role'] == 'Student')): ?>
                                <div class="card-icons">
                                    <i class="fa fa-share-alt" aria-hidden="true" onclick="shareJob(<?php echo $post['CompanyID']; ?>)"></i>
                                    <i class="<?php echo in_array($post['CompanyID'], $data['bookmarkedCompanyIds']) ? 'fa-solid' : 'fa-regular'; ?> fa-bookmark" onclick="toggleBookmark(this); bookmarkCompany(<?php echo $post['CompanyID']; ?>, this);"></i>
                                </div>
                            <?php else: ?>
                                <div class="card-icons">
                                    <i class="fa fa-share-alt" aria-hidden="true" onclick="shareJob(<?php echo $post['CompanyID']; ?>)"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="social-media-icons">
                            
                            <?php if (!empty(($post['Website']))): ?>
                                <?php $website = (strpos($post['Website'], 'http') === 0) ? $post['Website'] : 'https://' . $post['Website']; ?>
                                <a href="<?php echo htmlspecialchars($website); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    aria-label="Company website">
                                    <i class="fas fa-globe"></i>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($post['LinkedIn'])): ?>
                                <?php $linkedin = (strpos($post['LinkedIn'], 'http') === 0) ? $post['LinkedIn'] : 'https://www.linkedin.com/' . ltrim($post['LinkedIn'], '/'); ?>
                                <a href="<?php echo htmlspecialchars($linkedin); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    aria-label="LinkedIn profile">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($post['Facebook'])): ?>
                                <?php $facebook = (strpos($post['Facebook'], 'http') === 0) ? $post['Facebook'] : 'https://www.facebook.com/' . ltrim($post['Facebook'], '/'); ?>
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
        color: #e74c3c; /* Active color */
    }
</style>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<?php require APPROOT . '/views/components/footer.php'; ?>

<script>
    function goToCompanyDescription(companyId) {
        window.location.href = "/UniQuest/jobs/companydescription/" +companyId;
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
                alert('Failed to bookmark the company.');
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