<?php require APPROOT . '/views/components/header.php'; ?>
<?php require APPROOT . '/views/popups/student/changePassword.php'; ?>
<?php require APPROOT . '/views/popups/student/deactivate_account.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/edit_profile.css">

<div class="content-sub">
    <div class="content-sub-1">
        <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>
    </div>
    <div class="prow1">
        <form action="<?php echo URLROOT ?>/service_provider/edit_profile" method="POST" enctype="multipart/form-data">
            <div class="page-wrapper">
                <div class="sidebr">
                    <div class="upload-container">
                        <input type="file" id="profilePic" name="companyLogo" accept=".jpg, .jpeg, .png">
                        <img src="<?php echo UPLOADROOT . '/profile_pictures/company/' . $data['companyLogo']; ?>" alt="profilepic-placeholder" id="profilePicPreview">
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
                            <input type="text" id="company-name" name="companyName" value="<?php echo $data['companyName']; ?>" readonly>
                            <span class="error-msg"><?php echo !empty($data['companyName_err']) ? $data['companyName_err'] : '' ?></span>
                        </div>
                        <div class="form-group">
                            <label for="industry">Industry</label>
                            <select id="industryID" name="industryID" disabled>
                                <option value="" disabled selected>Select Industry</option>
                                <?php foreach ($data['industries'] as $industry) : ?>
                                    <option value="<?php echo $industry->IndustryID; ?>" <?php echo ($data['industryID'] == $industry->IndustryID) ? 'selected' : ''; ?>><?php echo $industry->IndustryName; ?></option>
                                <?php endforeach; ?>
                            </select>
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
                            <label for="linkedin">Linkedin</label>
                            <input type="text" id="linkedin" name="linkedin" value="<?php echo $data['linkedin']; ?>">
                            <span class="error-msg"><?php echo !empty($data['linkedin_err']) ? $data['linkedin_err'] : ''; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="facebook">Facebook</label>
                            <input type="text" id="facebook" name="facebook" value="<?php echo $data['facebook']; ?>">
                            <span class="error-msg"><?php echo !empty($data['facebook_err']) ? $data['facebook_err'] : ''; ?></span>
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
                            <div style="display: flex; justify-content: space-between; gap: 10px; width: 100%;">
                                <select id="districtID" name="districtID" required style="width: 50%;" data-preselected-district="<?php echo htmlspecialchars($data['districtID']); ?>">
                                    <option value="" disabled selected>Select District</option>
                                    <?php foreach ($data['districts'] as $district) : ?>
                                        <option value="<?php echo $district->DistrictID; ?>" <?php echo ($data['districtID'] == $district->DistrictID) ? 'selected' : ''; ?>><?php echo $district->DistrictName; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <select id="cityID" name="cityID" required style="width: 50%;" data-preselected-city="<?php echo htmlspecialchars($data['cityID']); ?>">
                                    <option value="" disabled selected>Select City</option>
                                    <?php foreach ($data['cities'] as $city) : ?>
                                        <option value=" <?php echo $city->CityID; ?>" <?php echo ($data['cityID'] == $city->CityID) ? 'selected' : ''; ?>><?php echo $city->CityName; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <span class="error-msg"><?php echo !empty($data['city_err']) ? $data['city_err'] : ''; ?></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="description">Company Description</label>
                            <textarea id="description" name="description"><?php echo $data['description']; ?></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <button type="button" class="cancel-button" onclick="window.location.href='<?php echo URLROOT; ?>/user/profile'">Cancel</button>
                            <button type="submit" class="save-button">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="module" src="<?php echo URLROOT; ?>/public/js/register/fileUpload.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/student/profile_pic_preview.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/register/citiesForDistrict.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>