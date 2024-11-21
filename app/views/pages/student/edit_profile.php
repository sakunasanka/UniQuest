<?php require APPROOT . '/views/components/stu_header.php'; ?>
<?php require APPROOT . '/views/popups/student/changePassword.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/edit_profile.css">

<!-- Sidebar and Content Layout -->

<!-- Sidebar -->
<div class="content-sub">
    <div class="content-sub-1">
        <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>
    </div>
    <!-- Content Area -->
    <!-- Sidebar -->
    <div class="prow1">
        <form action="<?php echo URLROOT ?>/student/edit_profile" method="POST" enctype="multipart/form-data">
            <div class="page-wrapper">
                <div class="sidebr">
                    <h2>Edit Profile</h2>
                    <div class="upload-container">
                        <input type="file" id="profilePic" name="profilePic" accept=".jpg, .jpeg, .png">
                        <img src="<?php echo UPLOADROOT . '/profile_pictures/student/' . $data['profilePic']; ?>" alt="Profile Picture" id="profilePicPreview">
                        <div class="upload-icon">⬆️</div>
                        <div class="upload-message">Image size should be under 1MB and image ratio needs to be 1:1</div>
                    </div>
                </div>

                <div class="form-container">
                    <div class="form-group">
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" name="firstName" value="<?php echo $data['firstName']; ?>" required>
                        <span class="error-msg"><?php echo !empty($data['firstName_err']) ? $data['firstName_err'] : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" name="lastName" value="<?php echo $data['lastName']; ?>" required>
                        <span class="error-msg"><?php echo !empty($data['lastName_err']) ? $data['lastName_err'] : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="contactNo">Contact Number</label>
                        <input type="text" id="contactNo" name="contactNo" value="<?php echo $data['contactNo']; ?>" required>
                        <span class="error-msg"><?php echo !empty($data['contactNo_err']) ? $data['contactNo_err'] : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="street-no">Street No</label>
                        <input type="text" id="streetNo" name="streetNo" value="<?php echo $data['streetNo']; ?>" required>
                        <span class="error-msg"><?php echo !empty($data['streetNo_err']) ? $data['streetNo_err'] : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="address-line1">Address Line 1</label>
                        <input type="text" id="addressLine1" name="addressLine1" value="<?php echo $data['addressLine1']; ?>" required>
                        <span class="error-msg"><?php echo !empty($data['addressLine1_err']) ? $data['addressLine1_err'] : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="address-line2">Address Line 2</label>
                        <input type="text" id="addressLine2" name="addressLine2" value="<?php echo $data['addressLine2']; ?>">
                        <span class="error-msg"><?php echo !empty($data['addressLine2_err']) ? $data['addressLine2_err'] : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" value="<?php echo $data['city']; ?>" required>
                        <span class="error-msg"><?php echo !empty($data['city_err']) ? $data['city_err'] : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="cv">Attach CV</label>
                        <div class="file-drop-area">
                            <div class="file-content">
                                <span>Drag & Drop to Upload file</span>
                                <button type="button" class="browse-btn">Browse File
                                    <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx">
                                </button>
                                <span class="file-name"><?php echo isset($data['cv']) ? $data['cv'] : 'No file selected'; ?></span>
                            </div>
                            <span class="error-msg"><?php echo !empty($data['cv_err']) ? $data['cv_err'] : ''; ?></span>
                        </div>
                    </div>

                    <!-- Save Changes button -->
                    <div class="button-group"></div>
                    <div class="form-group">
                        <button type="submit" class="save-button">Save Changes</button>
                        <button type="button" class="change-password-btn" onclick="ToggleChangePasswordForm()">change password</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>

<script type="module" src="<?php echo URLROOT; ?>/public/js/register/fileUpload.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>