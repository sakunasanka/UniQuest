<?php require APPROOT . '/views/components/stu_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/view_Profile.css">

<!-- Sidebar and Content Layout -->
<div class="content-area">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <div class="page-wrapper">
    <!-- Sidebar -->
    <div class="sidebr">
        <img src="<?php echo URLROOT; ?>/public/images/user.png" alt="Profile Picture" class="profile-pic">
        <ul>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="deactivate_account.php">Deactivate Account</a></li>
            <li><a href="signout.php">Sign out</a></li>
        </ul>
    </div>

    <div class="profile-container">
    <h3>My information</h3>
    <div class="info-section">
        <div class="info-row">
            <label>Full Name</label>
            <span class="colon">:</span>
            <span class="kk">kaveesha rathnayake</span>
        </div>
        <div class="info-row">
            <label>Email</label>
            <span class="colon">:</span>
            <span class="kk">kaveesha123@gmail.com</span>
        </div>
        <div class="info-row">
            <label>Address</label>
            <span class="colon">:</span>
            <span class="kk">29/A, Hambanthota</span>
        </div>
        <div class="info-row">
            <label>NIC No</label>
            <span class="colon">:</span>
            <span class="kk">200456789900</span>
        </div>
        <div class="info-row">
            <label>Date Of Birth</label>
            <span class="colon">:</span>
            <span class="kk">2002/09/06</span>
        </div>
        <div class="info-row">
            <label>Mobile</label>
            <span class="colon">:</span>
            <span class="kk">0776890789</span>
        </div>
        <div class="info-row">
            <label>Uploaded CV</label>
            <span class="colon">:</span>
            <span class="kk"><img src="<?php echo URLROOT; ?>/public/images/cv-icon.png" alt="CV Icon" class="cv-icon"></span>
        </div>
    </div>

    <h3>University information</h3>
    <div class="info-section">
        <div class="info-row">
            <label>University Email</label>
            <span>: 2020cs058stu.cmb.ucsc.ac.lk</span>
        </div>
        <div class="info-row">
            <label>University ID number</label>
            <span>: 21000678</span>
        </div>
    </div>

    <button class="edit-btn">Edit info</button>
</div>
</div>
</div>
<?php require APPROOT . '/views/components/footer.php'; ?>