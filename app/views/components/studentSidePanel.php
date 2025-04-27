<aside class="sidebar">
    <nav class="nav-menu">

        <button class="nav-btn" data-paths="/UniQuest/jobs,/UniQuest/internships,/UniQuest/companies">
            <span class="material-symbols-outlined"> work </span>
            Browse Opportunities
        </button>

        <div class="nav-dropdown">
            <button class="nav-btn dropdown-toggle" data-path="/UniQuest/student/all_app">
                <span class="material-symbols-outlined"> assignment </span>
                My Applications
            </button>
        </div>

        <button class="nav-btn" data-paths="/UniQuest/student/saveJobs,/UniQuest/student/saveInternships,/UniQuest/student/saveCompanies">
            <span class="material-symbols-outlined"> bookmark </span>
            Saved Opportunities
        </button>

        <button class="nav-btn" data-path="/UniQuest/jobs/trendyCompany">
            <span class="material-symbols-outlined"> trending_up </span>
            Trending Companies
        </button>
        
        <button class="nav-btn" data-path="/UniQuest/student/myreviews">
            <span class="material-symbols-outlined"> reviews </span>
            Reviews by me
        </button>

        <button class="nav-btn" data-path="/UniQuest/User/profile">
            <span class="material-symbols-outlined"> person </span>
            Profile
        </button>

    </nav>

    <button class="nav-btn logout-btn" onclick="window.location.href='<?php echo URLROOT; ?>/User/logout'">
        <span class="material-symbols-outlined"> logout </span>
        Logout
    </button>

</aside>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/serviceSidePanel.js"></script>