<?php require APPROOT . '/views/components/adm_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/admin/view_Profile.css">

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>
    <div class="content-area">
        <div class="content-header">
            <button class="back-btn" onclick="window.location.href='<?php echo URLROOT; ?>/admin/students_mng'">
                <span class="material-symbols-outlined">arrow_back_ios</span>
                <h1>User Management</h1>
            </button>
        </div>

        <!-- Content Area -->
        <div class="profile-container">
            <div class="profile-section">
                <div class="profile-pic">
                    <img
                        src="<?php echo empty($data['user']['ProfilePic'])
                                    ? URLROOT . '/images/profile_pic_preview.png'
                                    : UPLOADROOT . '/profile_pictures/vT-Member/' . $data['user']['ProfilePic']; ?>"
                        alt="Profile Picture">
                </div>
            </div>
            <div class="info-section">
                <h3>My information</h3>
                <div class="info-row">
                    <label>Full Name</label>
                    <span class="colon">:</span>
                    <span class="kk"><?php echo $data['user']['FirstName'] ?> <?php echo $data['user']['LastName'] ?></span>
                </div>
                <div class="info-row">
                    <label>Email</label>
                    <span class="colon">:</span>
                    <span class="kk"><?php echo $data['user']['Email'] ?></span>
                </div>
                <!-- contact no -->
                <div class="info-row">
                    <label>Contact No</label>
                    <span class="colon">:</span>
                    <span class="kk"><?php echo $data['user']['ContactNo'] ?></span>
                </div>
                <div class="btn-row">
                    <div></div>
                    <?php require APPROOT . '/views/components/chat-sent.php'; ?>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>