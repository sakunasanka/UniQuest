<?php require APPROOT . '/views/components/header.php'; ?>
<?php require APPROOT . '/views/components/chat-sent.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/admin/view_Profile.css">

<div class="main-container">
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>
    <div class="content-area">
        <div class="content-header">
            <button class="back-btn" onclick="window.location.href='<?php echo URLROOT; ?>/admin/verTeam_mng'">
                <span class="material-symbols-outlined">arrow_back_ios</span>
                <h1>User Management</h1>
            </button>
        </div>

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
                <h3>Verification Team Member information</h3>
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

                <div class="info-row">
                    <label>Contact No</label>
                    <span class="colon">:</span>
                    <span class="kk"><?php echo $data['user']['ContactNo'] ?></span>
                </div>
                <div class="btn-row">
                    <?php if ($data['user']['Status'] == 'Deactive' || $data['user']['Status'] == 'Pendind Deletion' && $data['acc_log'] != NULL): ?>
                        <div class="status-deact">
                            <span>Status: <?php echo $data['user']['Status'] ?></span><br>
                            <span>Reason: <?php echo $data['acc_log']->Reason ?></span><br>
                            <span>Deactivated on: <?php echo substr($data['acc_log']->ActionDate, 0, 10); ?></span><br>
                        </div>
                    <?php elseif ($data['user']['Status'] == 'Active' && $data['acc_log'] != NULL): ?>
                        <div class="status-act">
                            <span>Status: <?php echo $data['user']['Status'] ?></span><br>
                            <span>Reason: <?php echo $data['acc_log']->Reason ?></span><br>
                            <span>Activated on: <?php echo substr($data['acc_log']->ActionDate, 0, 10); ?></span><br>
                        </div>
                    <?php endif; ?>
                    
                </div>
            </div>
            <div class="btn-row">
                <div></div>
                <button id="openPopupBtn" class="contact-btn">Contact</button>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>