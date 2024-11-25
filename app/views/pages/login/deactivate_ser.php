<?php require APPROOT . '/views/components/ser_header.php'; ?>
<?php require APPROOT . '/views/popups/deactivate_popup.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/ser_dashboard.css">

<div class="main-container">
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?> 
    <main class="content-area">
        <div class="header-section">
            <h1>Welcome!</h1>
            <button class="activate-btn" id="activate-premium">
                <span class="material-symbols-outlined black-icon"> workspace_premium </span> Activate Premium
            </button>
        </div>
        <div class="grid-container">
            <div class="card">
                <span class="material-symbols-outlined green-icon"> work </span>
                <h2>Jobs</h2>
                <p>View, Edit and manage your jobs.</p>
                <div class="card-stats">
                    <span>8</span>
                    <span class="down">▼ 10.5%</span>
                </div>
                <p class="card-subtext">Job Clicks (Last month)</p>
            </div>

            <div class="card">
                <span class="material-symbols-outlined green-icon"> assignment </span>
                <h2>Applications</h2>
                <p>View applications for your jobs.</p>
                <div class="applications-stats">
                    <div class="new">
                        <span class="new-stat">3</span>
                        <span class="new-label">New</span>
                    </div>
                    <div class="active">
                        <span class="active-stat">4</span>
                        <span class="active-label">Active</span>
                    </div>  
                </div>
            </div>

            <div class="card">
                <span class="material-symbols-outlined green-icon"> monitoring </span>
                <h2>Analytics</h2>
                <p>View analytics and generate reports related to jobs.</p>
                <div class="card-stats">
                    <span>4.2</span>
                    <span class="up">▲ 2.6%</span>
                </div>
                <p class="card-subtext">Company Rating (Last month)</p>
            </div>

            <div class="card">
                <span class="material-symbols-outlined green-icon"> rate_review </span>
                <h2>Community Reviews</h2>
                <p>View, respond to, and manage your reviews.</p>
                <div class="card-stats">
                    <span>4</span>
                    <span class="up">▲ 3.5%</span>
                </div>
                <p class="card-subtext">Company Reviews (Last month)</p>
            </div>
        </div>
    </main>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>
