<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/ser_dashboard.css">

<div class="main-container">
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?> 
    <main class="content-area">
        <div class="header-section">
            <h1>Welcome!</h1>

            <?php
            if($data['companyInfo']->subscription_plan == 'professional'):
            ?>
            <button class="activate-btn" id="activate-premium" onclick="goToPremiums()">
                <span class="material-symbols-outlined gold-icon"> workspace_premium </span> Professional
            </button>

            <?php
            elseif($data['companyInfo']->subscription_plan == 'enterprise'):
            ?>
            <button class="activate-btn" id="activate-premium" onclick="goToPremiums()">
                <span class="material-symbols-outlined black-icon"> workspace_premium </span> Enterprise
            </button>

            <?php else: ?>   
            <button class="activate-btn" id="activate-premium" onclick="goToPremiums()">
                <span class="material-symbols-outlined black-icon"> workspace_premium </span> Activate Premium
            </button>
            <?php endif; ?>
        </div>
        <div class="grid-container">
            <div class="card" onclick="goToJobs()">
                <span class="material-symbols-outlined green-icon"> work </span>
                <h2>Jobs</h2>
                <p>View, Edit and manage your jobs.</p>
                <div class="card-stats">
                    <span><?php $data['companyInfo']->TotalJobViewCount ?></span>
                    <span class="down">▼ 10.5%</span>
                </div>
                <p class="card-subtext">Job Clicks (Last month)</p>
            </div>

            <div class="card" onclick="goToApplications()">
                <span class="material-symbols-outlined green-icon"> assignment </span>
                <h2>Applications</h2>
                <p>View applications for your jobs.</p>
                <div class="applications-stats">
                    <div class="new">
                        <span class="new-stat"><?php $data['companyInfo']->PendingApplicationCount ?></span>
                        <span class="new-label">New</span>
                    </div>
                    <div class="active">
                        <span class="active-stat"><?php $data['companyInfo']->AcceptedApplicationCount ?></span>
                        <span class="active-label">Active</span>
                    </div>  
                </div>
            </div>
           
            <div class="card" onclick="goToAnalytics()">
                <span class="material-symbols-outlined green-icon"> monitoring </span>
                <h2>Analytics</h2>
                <p>View analytics and generate reports related to jobs.</p>
                <div class="card-stats">
                    <span><?php echo $data['Rating']?></span>
                    <span class="up">▲ 2.6%</span>
                </div>
                <p class="card-subtext">Company Rating (Last month)</p>
            </div>

            <div class="card" onclick="goToReviews()">
                <span class="material-symbols-outlined green-icon"> rate_review </span>
                <h2>Community Reviews</h2>
                <p>View, respond to, and manage your reviews.</p>
                <div class="card-stats">
                    <span><?php $data['companyInfo']-> ReviewCount ?></span>
                    <span class="up">▲ 3.5%</span>
                </div>
                <p class="card-subtext">Company Reviews (Last month)</p>
            </div>
        </div>
    </main>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>

<script>
    function goToJobs() {
        window.location.href = "/UniQuest/service_provider/pending_jobs";
    }

    function goToApplications() {
        window.location.href = "/UniQuest/service_provider/application_dashboard";
    }

    function goToAnalytics() {
        window.location.href = "/UniQuest/service_provider/analytics";
    }

    function goToReviews() {
        window.location.href = "/UniQuest/user/profile#reviews-section";
    }

    window.onload = function() {
        if(window.location.hash === "#reviews-section") {
            const reviewsSection = document.getElementById('reviews-section');
            if(reviewsSection) {
                reviewsSection.scrollIntoView({ behavior: 'smooth' });
            } else {
                window.scrollTo(0, document.body.scrollHeight);
            }
        }
    };

    function goToPremiums() {
        window.location.href = "/UniQuest/service_provider/premium";
    }
</script>