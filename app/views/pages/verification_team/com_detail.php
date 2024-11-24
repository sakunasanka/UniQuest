<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/view_profile.css">

<!-- Sidebar and Content Layout -->
<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/verificationTeamSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="content-header">
            <button class="back-btn"  onclick="window.location.href='<?php echo URLROOT; ?>/verification_team/user_verified'">
                <span class="material-symbols-outlined">arrow_back_ios</span>
                <h1>Verified By Me</h1>
            </button>
        </div>
        <div class="view-card">
            <div class="view-card-pic">
                <img src="<?php echo URLROOT . '/images/profile_pic_preview.png' ?>" alt="Profile Picture">

            </div>

            <div class="view-card-content">
                <h1>Acme Inc</h1>
                <h2>Software & Technology</h2>
                <p>Acme Inc. is a leading company that specializes in developing innovative solutions for businesses of all sizes. With a team of talented engineers and designers, we are committed to delivering high-quality products that help our clients achieve their goals.</p>

                <div class="view-card-info">
                    <div>
                        <span>Address</span>
                        123, Main Street, Colombo 01
                    </div>
                    <div>
                        <span>Contact No</span>
                        0113452660
                    </div>
                    <div>
                        <span>Email</span>
                        info@academic.com
                    </div>
                    <div>
                        <span>Website</span>
                        <a href="" target="_blank">www.acmeinc.com</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>