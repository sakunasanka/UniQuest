<aside class="sidebar">
    <nav class="nav-menu">
        <button class="nav-btn" data-path="/UniQuest/admin/dashboard">
            <span class="material-symbols-outlined"> dashboard </span>
            Dashboard
        </button>

        <button class="nav-btn" data-paths="/UniQuest/admin/students_mng,/UniQuest/admin/company_mng,/UniQuest/admin/verTeam_mng,/UniQuest/admin/add_member,/UniQuest/admin/add_student,/UniQuest/admin/add_company">
            <span class="material-symbols-outlined"> manage_accounts</span>
            User Management
        </button>

        <button class="nav-btn" data-paths="/UniQuest/admin/ptjobs_mng,/UniQuest/admin/intern_mng">
            <span class="material-symbols-outlined"> folder_managed </span>
            Jobs Management
        </button>

        <button class="nav-btn" data-paths="/UniQuest/admin/user_ver_pending,/UniQuest/admin/user_ver_not">
            <span class="material-symbols-outlined"> person_check </span>
            User Verification
        </button>

        <button class="nav-btn" data-paths="/UniQuest/admin/job_ver_pending,/UniQuest/admin/job_ver_not">
            <span class="material-symbols-outlined"> domain_verification </span>
            Jobs Verification
        </button>

        <button class="nav-btn" data-paths="/UniQuest/admin/all_complaints,/UniQuest/admin/job_complaints,/UniQuest/admin/company_complaints">
            <span class="material-symbols-outlined"> problem </span>
            Complaints
        </button>

        <button class="nav-btn" data-paths="/UniQuest/admin/messages_stu">
            <span class="material-symbols-outlined">sms</span>
            Messages
        </button>

        <button class="nav-btn" data-path="/UniQuest/admin/analytics">
            <span class="material-symbols-outlined"> monitoring </span>
            Analytics
        </button>

        <button class="nav-btn" data-path="/UniQuest/admin/reports">
            <span class="material-symbols-outlined"> summarize </span>
            Reports
        </button>

        <button class="nav-btn" data-path="/UniQuest/admin/app_settings">
            <span class="material-symbols-outlined"> settings_applications </span>
            Application Settings
        </button>

        <button class="nav-btn" data-path="/UniQuest/user/profile">
            <span class="material-symbols-outlined"> person </span>
            Profile
        </button>
    </nav>

    <button class="nav-btn logout-btn" onclick="window.location.href='<?php echo URLROOT; ?>/user/logout'">
        <span class="material-symbols-outlined"> logout </span>
        Logout
    </button>

</aside>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSidePanel.js"></script>