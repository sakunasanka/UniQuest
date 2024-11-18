<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/edit_Profile.css">

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>

    <div class="s_e_p_content">

        <form action="<?php echo URLROOT ?>/service_provider/edit_profile" method="POST" enctype="multipart/form-data">
            <h2>Company Info Form</h2>

            <div class="file-drop-area">
                <div class="profile-pic-preview" id="profile-pic-preview">
                    <img src="<?php echo UPLOADROOT; ?>/profile_pictures/company/<?php echo $data['companyLogo']; ?>" alt="profilepic-placeholder">
                </div>
                <div class="file-content">
                    <span>Drag & Drop to Upload file</span>
                    <button type="button" class="browse-btn">Browse File
                        <input type="file" id="companyLogo" name="companyLogo" accept=".jpg, .jpeg, .png">
                    </button>
                    <span class="file-name">No file selected</span>
                </div>
            </div>

            <label for="company-name">Company Name</label>
            <input type="text" id="company-name" name="companyName" value="<?php echo $data['companyName']; ?>" required>
            <span class="error-msg"><?php echo !empty($data['companyName_err']) ? $data['companyName_err'] : '' ?></span>

            <label for="industry">Industry</label>
            <input type="text" id="industry" name="industry" value="<?php echo $data['industry']; ?>" required>

            <label for="description">Company Description</label>
            <input type="text" id="description" name="description" value="<?php echo $data['description']; ?>">

            <label for="company-contact">Contact No</label>
            <input type="text" id="company-contact" name="contactNo" value="<?php echo $data['contactNo']; ?>" required>
            <span class="error-msg"><?php echo !empty($data['contactNo_err']) ? $data['contactNo_err'] : '' ?></span>


            <label for="street-no">Street No</label>
            <input type="text" id="streetNo" name="streetNo" value="<?php echo $data['streetNo']; ?>" required>
            <span class="error-msg"><?php echo !empty($data['streetNo_err']) ? $data['streetNo_err'] : ''; ?></span>


            <label for="address-line1">Address Line 1</label>
            <input type="text" id="addressLine1" name="addressLine1" value="<?php echo $data['addressLine1']; ?>" required>
            <span class="error-msg"><?php echo !empty($data['addressLine1_err']) ? $data['addressLine1_err'] : ''; ?></span>


            <label for="address-line2">Address Line 2</label>
            <input type="text" id="addressLine2" name="addressLine2" value="<?php echo $data['addressLine2']; ?>">
            <span class="error-msg"><?php echo !empty($data['addressLine2_err']) ? $data['addressLine2_err'] : ''; ?></span>


            <label for="city">City</label>
            <input type="text" id="city" name="city" value="<?php echo $data['city']; ?>" required>
            <span class="error-msg"><?php echo !empty($data['city_err']) ? $data['city_err'] : ''; ?></span>

            <label for="website">Website</label>
            <input type="text" id="website" name="website" value="<?php echo $data['website']; ?>">

            <input type="submit" value="Save Changes">
            <input type="button" value="Cancel" onclick="window.location.href='index.php';">
        </form>
    </div>

</div>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/register/fileUpload.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>