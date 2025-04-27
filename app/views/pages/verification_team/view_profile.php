<?php require APPROOT . '/views/components/header.php'; ?>
<?php require APPROOT . '/views/popups/student/deactivate_account.php'; ?>
<?php require APPROOT . '/views/popups/student/changePassword.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/admin/view_Profile.css">

<div class="main-container">
    <div class="content-area">
        <?php require APPROOT . '/views/components/verificationTeamSidePanel.php'; ?>

        <div class="profile-container">
            <div class="profile-section">
                <div class="profile-pic">
                    <img
                        src="<?php echo empty($data['user']['ProfilePic'])
                                    ? URLROOT . '/images/profile_pic_preview.png'
                                    : UPLOADROOT . '/profile_pictures/vT-Member/' . $data['user']['ProfilePic']; ?>"
                        alt="Profile Picture">
                </div>
                <ul>
                    <li><a onclick="ToggleChangePasswordForm()">Change Password</a></li>
                    <li><a onclick="showdeleteaccountconfirm()">Deactivate Account</a></li>
                </ul>
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
                <div class="info-row">
                    <label>Contact No</label>
                    <span class="colon">:</span>
                    <span class="kk"><?php echo $data['user']['ContactNo'] ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>