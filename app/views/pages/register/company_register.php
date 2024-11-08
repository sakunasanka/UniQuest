<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/styles.css">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/register/reg_form.css">


<div class="reg-container">
    <button class="back" onclick="window.history.back()">
        <span class="material-symbols-outlined">arrow_back</span>
    </button>
    <div class="container">
        <div class="image-section">
            <h1>Company Register</h1>
            <img src="<?php echo URLROOT; ?>/images/service.png" alt="Student Registration">
        </div>
        <div class="form-section">
            <form action="<?php echo URLROOT ?>/register/company" method="POST" enctype="multipart/form-data">
                <!-- Company Details -->
                <h2>Company Details</h2>
                <div class="form-row">
                    <div class="input-profile-pic">
                        <div class="file-drop-area">
                            <div class="profile-pic-preview" id="profile-pic-preview">
                                <img src="<?php echo URLROOT; ?>/images/profile_pic_preview.png" alt="profilepic-placeholder">
                            </div>
                            <div class="file-content">
                                <span>Drag & Drop to Upload file</span>
                                <button type="button" class="browse-btn">Browse File
                                    <input type="file" id="companyLogo" name="companyLogo" accept=".jpg, .jpeg, .png">
                                </button>
                                <span class="file-name">No file selected</span>
                            </div>
                        </div>
                        <span class="error-msg"><?php echo !empty($data['companyLogo_err']) ? $data['companyLogo_err'] : '' ?></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="company-name">Company Name</label>
                        <input type="text" id="company-name" name="companyName" value="<?php echo $data['companyName']; ?>" required>
                        <span class="error-msg"><?php echo !empty($data['companyName_err']) ? $data['companyName_err'] : '' ?></span>
                    </div>
                    <div class="input-container">
                        <label for="company-contact">Contact No</label>
                        <input type="text" id="company-contact" name="contactNo" value="<?php echo $data['contactNo']; ?>" required>
                        <span class="error-msg"><?php echo !empty($data['contactNo_err']) ? $data['contactNo_err'] : '' ?></span>
                    </div>
                </div>

                <h3>Address</h3>
                <div class="form-row">
                    <div class="input-container">
                        <label for="street-no">Street No</label>
                        <input type="text" id="streetNo" name="streetNo" value="<?php echo $data['streetNo']; ?>" required>
                        <span class="error-msg"><?php echo !empty($data['streetNo_err']) ? $data['streetNo_err'] : ''; ?></span>
                    </div>
                    <div class="input-container">
                        <label for="address-line1">Address Line 1</label>
                        <input type="text" id="addressLine1" name="addressLine1" value="<?php echo $data['addressLine1']; ?>" required>
                        <span class="error-msg"><?php echo !empty($data['addressLine1_err']) ? $data['addressLine1_err'] : ''; ?></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="address-line2">Address Line 2</label>
                        <input type="text" id="addressLine2" name="addressLine2" value="<?php echo $data['addressLine2']; ?>">
                        <span class="error-msg"><?php echo !empty($data['addressLine2_err']) ? $data['addressLine2_err'] : ''; ?></span>
                    </div>
                    <div class="input-container">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" value="<?php echo $data['city']; ?>" required>
                        <span class="error-msg"><?php echo !empty($data['city_err']) ? $data['city_err'] : ''; ?></span>
                    </div>
                </div>

                <!-- Login Credentials -->
                <h2>Login Credentials</h2>
                <div class="form-row">
                    <div class="input-container">
                        <label for="email">Company Email</label>
                        <input type="email" id="email" name="email" value="<?php echo $data['email']; ?>" required>
                        <span class="error-msg"><?php echo !empty($data['email_err']) ? $data['email_err'] : ''; ?></span>
                    </div>
                    <div class="input-container"></div>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" value="<?php echo $data['password']; ?>" required>
                        <span class="error-msg"><?php echo !empty($data['password_err']) ? $data['password_err'] : ''; ?></span>
                    </div>
                    <div class="input-container">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" value="<?php echo $data['confirm_password']; ?>" required>
                        <span class="error-msg"><?php echo !empty($data['confirm_password_err']) ? $data['confirm_password_err'] : ''; ?></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="input-center terms">
                        <input type="checkbox" id="terms" name="terms" value="accepted" required>
                        <span for="terms">
                            I agreed to all
                            <a href="terms.html" target="_blank">Terms</a>
                            and
                            <a href="privacy.html" target="_blank">Privacy Policy</a>
                        </span>
                        <span class="error-msg"><?php echo !empty($data['terms_err']) ? $data['terms_err'] : ''; ?></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="input-center">
                        <button type="submit">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="module" src="<?php echo URLROOT; ?>/public/js/register/fileUpload.js"></script>