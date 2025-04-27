<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/ser_dashboard.css">

<div class="main-container">
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?> 
    <main class="content-area">
        <div class="header-section">
            <h1>Welcome!</h1>

            <?php if($data['companyInfo']->subscription_plan == 'professional'): ?>
                <button class="activate-btn" id="activate-premium" onclick="goToPremiums()">
                    <span class="material-symbols-outlined gold-icon"> workspace_premium </span> Professional
                </button>
            <?php elseif($data['companyInfo']->subscription_plan == 'enterprise'): ?>
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
                <span class="material-symbols-outlined yellow-icon"> work </span>
                <h2>Jobs</h2>
                <p>View, Edit and manage your jobs.</p>
                <div class="card-stats">
                    <span><?php echo $data['companyInfo']->TotalJobViewCount; ?></span>
                    <?php 
                        $change1 = $data['percentageIncreaseViews'] - $data['percentageDecreaseViews'];
                        $isIncrease1 = $change1 > 0;
                        $isDecrease1 = $change1 < 0;
                        $icon1 = $isIncrease1 ? "▲" : ($isDecrease1 ? "▼" : "—");
                        $class1 = $isIncrease1 ? "up" : ($isDecrease1 ? "down" : "neutral");
                        $percentage1 = abs($change1);
                    ?>
                    <span class="<?php echo $class1; ?>">
                        <?php echo $icon1 . ' ' . round($percentage1, 1); ?>%
                    </span>
                </div>
                <p class="card-subtext">Job Clicks (Last month)</p>
            </div>

            <div class="card" onclick="goToApplications()">
                <span class="material-symbols-outlined pink-icon"> assignment </span>
                <h2>Applications</h2>
                <p>View applications for your jobs.</p>
                <div class="applications-stats">
                    <div class="new">
                        <span class="new-stat"><?php echo $data['companyInfo']->PendingApplicationCount; ?></span>
                        <span class="new-label">New</span>
                    </div>
                    <div class="active">
                        <span class="active-stat"><?php echo $data['companyInfo']->AcceptedApplicationCount; ?></span>
                        <span class="active-label">Accepted</span>
                    </div>  
                </div>
            </div>

            <div class="card" onclick="goToAnalytics()">
                <span class="material-symbols-outlined indigo-icon"> monitoring </span>
                <h2>Analytics</h2>
                <p>View analytics and generate reports related to jobs.</p>
                <div class="card-stats">
                    <span><?php echo $data['Rating']; ?></span>
                    <?php 
                        $change2 = $data['percentageIncreaseRatings'] - $data['percentageDecreaseRatings'];
                        $isIncrease2 = $change2 > 0;
                        $isDecrease2 = $change2 < 0;
                        $icon2 = $isIncrease2 ? "▲" : ($isDecrease2 ? "▼" : "—");
                        $class2 = $isIncrease2 ? "up" : ($isDecrease2 ? "down" : "neutral");
                        $percentage2 = abs($change2);
                    ?>
                    <span class="<?php echo $class2; ?>">
                        <?php echo $icon2 . ' ' . round($percentage2, 1); ?>%
                    </span>
                </div>
                <p class="card-subtext">Company Rating (Last month)</p>
            </div>

            <div class="card" onclick="goToReviews()">
                <span class="material-symbols-outlined teal-icon"> rate_review </span>
                <h2>Community Reviews</h2>
                <p>View, respond to, and manage your reviews.</p>
                <div class="card-stats">
                    <span><?php echo $data['companyInfo']->ReviewCount; ?></span>
                    <?php 
                        $change3 = $data['percentageIncreaseReviews'] - $data['percentageDecreaseReviews'];
                        $isIncrease3 = $change3 > 0;
                        $isDecrease3 = $change3 < 0;
                        $icon3 = $isIncrease3 ? "▲" : ($isDecrease3 ? "▼" : "—");
                        $class3 = $isIncrease3 ? "up" : ($isDecrease3 ? "down" : "neutral");
                        $percentage3 = abs($change3);
                    ?>
                    <span class="<?php echo $class3; ?>">
                        <?php echo $icon3 . ' ' . round($percentage3, 1); ?>%
                    </span>
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

    function goToPremiums() {
        window.location.href = "/UniQuest/service_provider/premium";
    }

    window.onload = function() {
        if (window.location.hash === "#reviews-section") {
            const reviewsSection = document.getElementById('reviews-section');
            if (reviewsSection) {
                reviewsSection.scrollIntoView({ behavior: 'smooth' });
            } else {
                window.scrollTo(0, document.body.scrollHeight);
            }
        }
    };
</script>