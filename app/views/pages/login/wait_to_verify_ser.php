<?php require APPROOT . '/views/components/header.php'; ?>
<?php require APPROOT . '/views/popups/wait_to_verify_popup.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/ser_dashboard.css">

<?php if (isset($_SESSION['user_role'])): ?>
<?php else: ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/guest_user.css">
<?php endif; ?>

<div class="main-container">
    <main class="content-area">
        <div class="header-section">
            <h1>Welcome!</h1>
        </div>
        <div class="grid-container">
            <div class="card" onclick="goToJobs()">
                <span class="material-symbols-outlined green-icon"> work </span>
                <h2>Jobs</h2>
                <p>View, Edit and manage your jobs.</p>
            </div>

            <div class="card" onclick="goToApplications()">
                <span class="material-symbols-outlined green-icon"> assignment </span>
                <h2>Applications</h2>
                <p>View applications for your jobs.</p>
            </div>

            <div class="card" onclick="goToAnalytics()">
                <span class="material-symbols-outlined green-icon"> monitoring </span>
                <h2>Analytics</h2>
                <p>View analytics and generate reports related to jobs.</p>
            </div>

            <div class="card" onclick="goToReviews()">
                <span class="material-symbols-outlined green-icon"> rate_review </span>
                <h2>Community Reviews</h2>
                <p>View, respond to, and manage your reviews.</p>
            </div>
        </div>
    </main>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>

<script>
    function goToJobs() {
        window.location.href = "/uniquest/service_provider/ongoing_jobs";
    }

    function goToApplications() {
        window.location.href = "/uniquest/service_provider/new_applications";
    }

    function goToAnalytics() {
        window.location.href = "/uniquest/service_provider/analytics";
    }

    function goToReviews() {
        window.location.href = "/uniquest/service_provider/reviews";
    }

    function goToPremiums() {
        window.location.href = "/uniquest/service_provider/premium";
    }
</script>