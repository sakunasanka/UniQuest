<aside class="sidebar">
    <nav class="nav-menu">
        <button class="nav-btn" data-path="/UniQuest/verification_team/profile">
            <span class="material-symbols-outlined"> person </span>
            Profile
        </button>

        <button class="nav-btn" data-path="/UniQuest/verification_team/dashboard">
            <span class="material-symbols-outlined"> dashboard </span>
            Dashboard
        </button>

        <button class="nav-btn" data-paths="/UniQuest/verification_team/user_ver_pending,/UniQuest/verification_team/user_ver_not">
            <span class="material-symbols-outlined"> person_check </span>
            User Verification
        </button>

        <button class="nav-btn" data-paths="/UniQuest/verification_team/job_ver_pending,/UniQuest/verification_team/job_ver_not">
            <span class="material-symbols-outlined"> domain_verification </span>
            Jobs Verification
        </button>

        <button class="nav-btn" data-paths="/UniQuest/verification_team/user_verified,/UniQuest/verification_team/job_verified">
            <span class="material-symbols-outlined"> done_all </span>
            Verified By Me
        </button>

    </nav>

    <button class="nav-btn logout-btn" onclick="window.location.href='<?php echo URLROOT; ?>/user/logout'">
        <span class="material-symbols-outlined"> logout </span>
        Logout
    </button>
</aside>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSidePanel.js"></script>