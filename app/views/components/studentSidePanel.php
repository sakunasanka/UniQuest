<aside class="sidebar">
    <nav class="nav-menu">
        <!-- Dashboard -->
        <button class="nav-btn" data-path="/uniquest/service_provider/dashboard">
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
            <button class="nav-btn" data-path="/uniquest/student/all_app">All</button>
                <button class="nav-btn" data-path="/uniquest/student/accepted_app">Accepted</button>
                <button class="nav-btn" data-path="/uniquest/student/rejected_app">Rejected</button>
            </div>
        </div>

        <!-- Saved -->
        <button class="nav-btn" data-path="/uniquest/service_provider/analytics">
            <span class="material-symbols-outlined"> bookmark </span>
            Saved Opportunities
        </button>

        <!-- Trending companies -->
        <button class="nav-btn" data-path="/uniquest/service_provider/reviews">
            <span class="material-symbols-outlined"> trending_up </span>
            Trending Companies
        </button>

        <!-- Help and Support -->
        <button class="nav-btn" data-path="/uniquest/service_provider/support">
            <span class="material-symbols-outlined"> help_outline </span>
            Help and Support
        </button>
    </nav>
</aside>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/serviceSidePanel.js"></script>
