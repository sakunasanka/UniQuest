<aside class="sidebar">
    <nav class="nav-menu">
        <!-- Dashboard -->
        <button class="nav-btn" data-path="/UniQuest/service_provider/dashboard">
            <span class="material-symbols-outlined"> dashboard </span>
            Dashboard
        </button>

        <!-- Jobs Management with Dropdown -->
        <div class="nav-dropdown">
            <button class="nav-btn dropdown-toggle">
                <span class="material-symbols-outlined"> work </span>
                Jobs
                <span class="material-symbols-outlined dropdown-icon"> expand_more </span>
            </button>
            <div class="dropdown-menu">
                <button class="nav-btn" data-path="/UniQuest/service_provider/ongoing_jobs">Ongoing Jobs</button>
                <button class="nav-btn" data-path="/UniQuest/service_provider/offered_jobs">Offered Jobs</button>
                <button class="nav-btn" data-path="/UniQuest/service_provider/jobpost">Publish a Job</button>
            </div>
        </div>

        <!-- Application Dashboard -->
        <button class="nav-btn" data-path="/UniQuest/service_provider/application_dashboard">
            <span class="material-symbols-outlined"> assignment </span>
            Application Dashboard
        </button>

        <!-- Analytics -->
        <button class="nav-btn" data-path="/UniQuest/service_provider/analytics">
            <span class="material-symbols-outlined"> monitoring </span>
            Analytics
        </button>

        <!-- Reviews -->
        <button class="nav-btn" data-path="/UniQuest/service_provider/reviews">
            <span class="material-symbols-outlined"> rate_review </span>
            Reviews
        </button>

        <!-- Trending companies -->
        <button class="nav-btn" data-path="/UniQuest/jobs/trendyCompany">
            <span class="material-symbols-outlined"> trending_up </span>
            Trending Companies
        </button>

        <!-- Premium -->
        <button class="nav-btn" data-path="/UniQuest/service_provider/premium">
        <span class="material-symbols-outlined">workspace_premium</span>
            Activate Premium
        </button>

        <!-- Company info -->
        <button class="nav-btn" data-path="/UniQuest/user/profile">
        <span class="material-symbols-outlined">info</span>
            Company Info
        </button>

        <!-- Help and Support -->
        <!-- <button class="nav-btn" data-path="/UniQuest/service_provider/support">
            <span class="material-symbols-outlined"> help_outline </span>
            Help and Support
        </button> -->
    </nav>

    <!-- Logout -->
    <button class="nav-btn logout-btn" onclick="window.location.href='<?php echo URLROOT; ?>/user/logout'">
    <span class="material-symbols-outlined"> logout </span>
        Logout
    </button>
    
</aside>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/serviceSidePanel.js"></script>