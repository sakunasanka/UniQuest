<?php require APPROOT . '/views/components/stu_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/edit_profile.css">

<!-- Sidebar and Content Layout -->


    <!-- Sidebar -->
<div class="content-sub">
    <div class="content-sub-1">
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>
    </div>
    <!-- Content Area -->
     <!-- Sidebar -->
<div class="prow1">
<div class="page-wrapper">
    <div class="sidebr">
    <h2>Edit Profile</h2>
    <div class="upload-container">
        
        <img src="<?php echo URLROOT; ?>/public/images/edit.png" alt="Profile Picture" class="profile-pic" id="uploadedImage">
        <input type="file" id="fileInput" accept="image/*">
        <div class="upload-icon">⬆️</div>
        <div class="upload-message">Image size should be under 1MB and image ratio needs to be 1:1</div>
    </div>
    </div>
    
    <div class="form-container">
        <form action="#" method="post">
            <div class="form-group">
                <label for="first-name">First name</label>
                <input type="text" id="first-name" name="first-name" placeholder="First name">
            </div>
            <div class="form-group">
                <label for="last-name">Last name</label>
                <input type="text" id="last-name" name="last-name" placeholder="Last name">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email address (University)">
            </div>
            <div class="form-group">
                <label for="nic-number">NIC Number</label>
                <input type="text" id="nic-number" name="nic-number" placeholder="NIC Number">
            </div>
            <div class="form-group">
                <label for="mobile">Mobile</label>
                <input type="text" id="mobile" name="mobile" placeholder="Enter your mobile number">
            </div>
            <div class="form-group">
                <label for="university">University</label>
                <input type="text" id="university" name="university" placeholder="Enter your university name">
            </div>
            <div class="form-group">
                <label for="university-id">University ID</label>
                <input type="text" id="university-id" name="university-id" placeholder="Enter your university ID number">
            </div>
            <!-- Save Changes button -->
            <div class="button-group"></div>
            <div class="form-group">
                <button type="submit" class="save-button">Save Changes</button>
                <button type="submit" class="change-password-btn" onclick="showChangePasswordForm()">change password1</button>
            </div>
            </div>
        </form>
    </div>

    <div class="changep_password-form-container" id="changep_password-form-container">
        <h2>Change password</h2>
        <form action="#" method="post">
            <div class="changep_form-group">
                <label for="current-password">Current Password</label>
                <div class="changep_password-wrapper">
                    <input type="password" id="current-password" name="current-password" placeholder="Password">
                    <span class="changep_password-toggle">&#128065;</span> <!-- Eye icon -->
                </div>
            </div>
            <div class="changep_form-group">
                <label for="new-password">New Password</label>
                <div class="changep_password-wrapper">
                    <input type="password" id="new-password" name="new-password" placeholder="Password">
                    <span class="changep_password-toggle">&#128065;</span> <!-- Eye icon -->
                </div>
            </div>
            <div class="changep_form-group">
                <label for="confirm-password">Confirm Password</label>
                <div class="changep_password-wrapper">
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm new password">
                    <span class="changep_password-toggle">&#128065;</span> <!-- Eye icon -->
                </div>
            </div>
            <!-- Change Password button -->
            <div class="changep_form-group">
                <button type="submit" class="changep_change-button"  onclick="closeChangePasswordForm()">Change Password</button>
            </div>
        </form>
    </div>
</div>
</div>
<script type="text/javascript" src="<?php echo URLROOT; ?>/js/student/change_password.js"></script>   

<?php require APPROOT . '/views/components/footer.php'; ?>