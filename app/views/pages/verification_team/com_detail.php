<?php require APPROOT . '/views/components/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/view_profile.css">

<!-- Sidebar and Content Layout -->
<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/verificationTeamSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="content-header">
            <button class="back-btn" onclick="window.location.href='<?php echo URLROOT; ?>/verification_team/user_verified'">
                <span class="material-symbols-outlined">arrow_back_ios</span>
                <h1>Verified Users</h1>
            </button>
        </div>
        <div class="view-card">
            <div class="view-card-pic">
                <img
                    src="<?php echo empty($data['user']['CompanyLogo'])
                                ? URLROOT . '/images/profile_pic_preview.png'
                                : UPLOADROOT . '/profile_pictures/company/' . $data['user']['CompanyLogo']; ?>"
                    alt="Profile Picture">
            </div>

            <div class="view-card-content">
                <h1><?php echo $data['user']['CompanyName'] ?></h1>
                <h2><?php echo $data['user']['Industry'] ?></h2>
                <p><?php echo $data['user']['Description'] ?></p>

                <div class="view-card-info">
                    <div>
                        <span>Address</span>
                        <?php echo $data['user']['Address'] ?>
                    </div>
                    <div>
                        <span>Contact No</span>
                        <?php echo $data['user']['ContactNo'] ?>
                    </div>
                    <div>
                        <span>Email</span>
                        <?php echo $data['user']['Email'] ?>
                    </div>
                </div>
                <div class="view-card-info">
                    <?php if ($data['user']['Website']): ?>
                        <div>
                            <span>Website</span>
                            <a href="<?php echo $data['user']['Website'] ?>" target="_blank"><?php echo $data['user']['Website'] ?></a>
                        </div>
                    <?php endif; ?>
                    <?php if ($data['user']['LinkedIn']): ?>
                        <div>
                            <span>LinkedIn</span>
                            <a href="<?php echo $data['user']['LinkedIn'] ?>" target="_blank"><?php echo $data['user']['LinkedIn'] ?></a>
                        </div>
                    <?php endif; ?>
                    <?php if ($data['user']['Facebook']): ?>
                        <div>
                            <span>Facebook</span>
                            <a href="<?php echo $data['user']['Facebook'] ?>" target="_blank"><?php echo $data['user']['Facebook'] ?></a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="btn-row">
                    <!-- <button class="contact-btn" onclick="">Contact</button> -->
                    <?php require APPROOT . '/views/components/chat-sent.php'; ?>
                </div>
            </div>
        </div>
        <!-- File Previews -->
        <?php if ($data['user']['BRCertificate']): ?>
            <div class="view-card file-preview">
                <div class="detail-row">
                    <strong>Business Registration </strong>
                </div>
                <iframe src="<?php echo UPLOADROOT; ?>/br_certificates/<?php echo htmlspecialchars($data['user']['BRCertificate']); ?>" frameborder="0"></iframe>
            </div>
        <?php endif; ?>
    </main>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>