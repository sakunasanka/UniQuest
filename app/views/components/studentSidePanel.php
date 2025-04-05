<aside class="sidebar">
    <nav class="nav-menu">
        <!-- Dashboard -->
        <button class="nav-btn" data-paths="/UniQuest/jobs,/UniQuest/internships,/UniQuest/companies">
            <span class="material-symbols-outlined"> work </span>
            Browse Opportunities
        </button>

        <!-- Applications with Dropdown -->
        <div class="nav-dropdown">
            <button class="nav-btn dropdown-toggle">
                <span class="material-symbols-outlined"> assignment </span>
                My Applications
                <span class="material-symbols-outlined dropdown-icon"> expand_more </span>
            </button>
            <div class="dropdown-menu">
                <button class="nav-btn" data-path="/UniQuest/student/all_app">All</button>
                <button class="nav-btn" data-path="/UniQuest/student/accepted_app">Accepted</button>
                <button class="nav-btn" data-path="/UniQuest/student/rejected_app">Rejected</button>
            </div>
        </div>

        <!-- Saved -->
        <button class="nav-btn" data-paths="/UniQuest/student/saveJobs,/UniQuest/student/saveInternships,/UniQuest/student/saveCompanies">
            <span class="material-symbols-outlined"> bookmark </span>
            Saved Opportunities
        </button>

        <!-- Trending companies -->
        <button class="nav-btn" data-path="/UniQuest/student/trendyCompany">
            <span class="material-symbols-outlined"> trending_up </span>
            Trending Companies
        </button>

        <button class="nav-btn" data-path="/UniQuest/User/profile">
            <span class="material-symbols-outlined"> person </span>
            Profile
        </button>

        <!-- Reviews by me -->
        <button class="nav-btn" data-path="/UniQuest/student/myreviews">
            <span class="material-symbols-outlined"> reviews </span>
            Reviews by me
        </button>

        <!-- Help and Support
        <button class="nav-btn" data-path="/UniQuest/student/support">
            <span class="material-symbols-outlined"> help_outline </span>
            Help and Support
        </button> -->
    </nav>

    <button class="nav-btn logout-btn" onclick="window.location.href='<?php echo URLROOT; ?>/User/logout'">
        <span class="material-symbols-outlined"> logout </span>
        Logout
    </button>

</aside>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/serviceSidePanel.js"></script>