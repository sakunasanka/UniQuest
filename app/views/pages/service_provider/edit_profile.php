<?php require APPROOT . '/views/components/ser_header.php'; ?>
<?php require APPROOT . '/views/popups/student/changePassword.php'; ?>
<?php require APPROOT . '/views/popups/student/deactivate_account.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/edit_profile.css">

<!-- Sidebar and Content Layout -->
<div class="content-sub">
    <div class="content-sub-1">
        <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>
    </div>
    <!-- Content Area -->
    <!-- Sidebar -->
    <div class="prow1">
        <form action="<?php echo URLROOT ?>/service_provider/edit_profile" method="POST" enctype="multipart/form-data">
            <div class="page-wrapper">
                <div class="sidebr">
                    <div class="upload-container">
                        <input type="file" id="profilePic" name="companyLogo" accept=".jpg, .jpeg, .png">
                        <img src="<?php echo UPLOADROOT .'/profile_pictures/company/' . $data['companyLogo']; ?>" alt="profilepic-placeholder" id="profilePicPreview">
                        <div class="upload-icon">⬆️</div>
                        <div class="upload-message">Image size should be under 5MB</div>
                    </div>
                    <span id="profilePicError" class="error-msg"><?php echo !empty($data['profilePic_err']) ? $data['profilePic_err'] : ''; ?></span>
                    <ul>
                        <li><a onclick="showdeleteaccountconfirm()">Deactivate Account</a></li>
                        <li><a onclick="ToggleChangePasswordForm()">Change Password</a></li>
                    </ul>
                </div>

                <div class="form-container">

                    <h2>Edit Company Info</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="company-name">Company Name</label>
                            <input type="text" id="company-name" name="companyName" value="<?php echo $data['companyName']; ?>" required>
                            <span class="error-msg"><?php echo !empty($data['companyName_err']) ? $data['companyName_err'] : '' ?></span>
                        </div>
                        <div class="form-group">
                            <label for="industry">Industry</label>
                            <input type="text" id="industry" name="industry" value="<?php echo $data['industry']; ?>" required>
                            <span class="error-msg"><?php echo !empty($data['industry_err']) ? $data['industry_err'] : ''; ?></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="company-contact">Contact No</label>
                            <input type="text" id="company-contact" name="contactNo" value="<?php echo $data['contactNo']; ?>" required>
                            <span class="error-msg"><?php echo !empty($data['contactNo_err']) ? $data['contactNo_err'] : '' ?></span>
                        </div>
                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="text" id="website" name="website" value="<?php echo $data['website']; ?>">
                            <span class="error-msg"><?php echo !empty($data['website_err']) ? $data['website_err'] : ''; ?></span>
                        </div>
                    </div>
                    <div class="form-row">
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
                    </div>
                    <div class="form-row">
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
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="description">Company Description</label>
                            <textarea id="description" name="description"><?php echo $data['description']; ?></textarea>
                        </div>
                    </div>

                    <!-- Save Changes button -->
                    <div class="form-row">
                        <div class="form-group">
                            <button type="button" class="cancel-button" onclick="window.location.href='<?php echo URLROOT; ?>/user/profile'">Cancel</button>
                            <button type="submit" class="save-button">Save Changes</button>
                            <!-- <button type="button" class="change-password-btn" onclick="ToggleChangePasswordForm()">change password</button> -->
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="module" src="<?php echo URLROOT; ?>/public/js/register/fileUpload.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/student/profile_pic_preview.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>