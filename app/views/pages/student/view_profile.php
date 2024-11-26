<?php require APPROOT . '/views/components/stu_header.php'; ?>
<?php require APPROOT . '/views/popups/student/deactivate_account.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/view_Profile.css">

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <div class="content-area">
        <!-- Sidebar -->
        <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>

        <!-- Content Area -->
        <div class="page-wrapper">
            <!-- Sidebar -->
            <div class="sidebr">
                <img
                    src="<?php echo empty($data['user']['ProfilePic'])
                                ? URLROOT . '/images/profile_pic_preview.png'
                                : UPLOADROOT . '/profile_pictures/student/' . $data['user']['ProfilePic']; ?>"
                    alt="Profile Picture"
                    class="profile-pic">
                <ul>
                    <li><a onclick="showdeleteaccountconfirm()">Deactivate Account</a></li>
                    <li><a href="<?php echo URLROOT ?>/user/logout">Log Out</a></li>
                </ul>
            </div>

            <div class="profile-container">
                <h3>My information</h3>
                <div class="info-section">
                    <div class="info-row">
                        <label>Full Name</label>
                        <span class="colon">:</span>
                        <span class="kk"><?php echo $data['user']['FirstName'] ?> <?php echo $data['user']['LastName'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>Address</label>
                        <span class="colon">:</span>
                        <span class="kk"><?php echo $data['user']['StreetNo'] ?>, <?php echo $data['user']['AddressLine1'] ?>, <?php echo $data['user']['AddressLine2'] ?><?php echo empty($data['user']['AddressLine2']) ? '' : ',' ?> <?php echo $data['user']['City'] ?>
                    </div>
                    <div class="info-row">
                        <label>NIC No</label>
                        <span class="colon">:</span>
                        <span class="kk"><?php echo $data['user']['NIC_No'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>Date Of Birth</label>
                        <span class="colon">:</span>
                        <span class="kk"><?php echo $data['user']['DOB'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>Mobile</label>
                        <span class="colon">:</span>
                        <span class="kk"><?php echo $data['user']['ContactNo'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>Uploaded CV</label>
                        <span class="colon">:</span>
                        <span class="kk">
                            <?php if ($data['user']['CV']): ?>
                                <a href="<?php echo UPLOADROOT; ?>/cvs/<?php echo $data['user']['CV']; ?>" target="_blank">View CV</a>
                            <?php else: ?>
                                No uploaded CV
                            <?php endif; ?>
                        </span>
                    </div>
                </div>

                <h3>University information</h3>
                <div class="info-section">
                    <div class="info-row">
                        <label>University</label>
                        <span class="colon">:</span>
                        <span class="kk"><?php echo $data['user']['University'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>University Email</label>
                        <span class="colon">:</span>
                        <span class="kk"><?php echo $data['user']['Email'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>University ID number</label>
                        <span class="colon">:</span>
                        <span class="kk"><?php echo $data['user']['UniversityID'] ?></span>
                    </div>
                </div>
                <div class="info-row">
                    <button class="edit-btn" onclick="window.location.href='<?php echo URLROOT; ?>/student/edit_profile'">Edit info</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>