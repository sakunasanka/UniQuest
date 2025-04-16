<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/register/reg_form.css">
</head>

<body>
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
                                    <span>Drag & Drop to Upload Company Logo</span>
                                    <button type="button" class="browse-btn">Browse File
                                        <input type="file" id="companyLogo" name="companyLogo" accept=".jpg, .jpeg, .png">
                                    </button>
                                    <span class="file-name">No file selected</span>
                                </div>
                            </div>
                            <span class="req-msg">Only JPG, JPEG, PNG files are allowed, and maximum file size is 5MB</span>
                            <span class="error-msg"><?php echo !empty($data['companyLogo_err']) ? $data['companyLogo_err'] : '' ?></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-container">
                            <label for="company-name">Company Name<span class="req"> *</span></label>
                            <input type="text" id="company-name" name="companyName" value="<?php echo $data['companyName']; ?>" placeholder="Enter Company Name" required>
                            <span class="error-msg"><?php echo !empty($data['companyName_err']) ? $data['companyName_err'] : '' ?></span>
                        </div>
                        <div class="input-container">
                            <label for="company-contact">Contact Number<span class="req"> *</span></label>
                            <input type="text" id="company-contact" name="contactNo" value="<?php echo $data['contactNo']; ?>" placeholder="Enter Contact Number" required>
                            <span class="error-msg"><?php echo !empty($data['contactNo_err']) ? $data['contactNo_err'] : '' ?></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-container">
                            <label for="industry">Industry<span class="req"> *</span></label>
                            <!-- <input type="text" id="industry" name="industry" value="<?php echo $data['industry']; ?>" placeholder="Enter Industry" required> -->
                            <select id="industry" name="industry" required>
                                <option value="" disabled selected>Select Industry</option>
                                <?php foreach ($data['industries'] as $industry) : ?>
                                    <option value="<?php echo $industry->IndustryName; ?>" <?php echo ($data['industry'] == $industry->IndustryName) ? 'selected' : ''; ?>><?php echo $industry->IndustryName; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="error-msg"><?php echo !empty($data['industry_err']) ? $data['industry_err'] : '' ?></span>
                        </div>
                        <div class="input-container">
                            <label for="website">Company Website</label>
                            <input type="text" id="website" name="website" value="<?php echo $data['website']; ?>" placeholder="Enter Company Website">
                            <span class="error-msg"><?php echo !empty($data['website_err']) ? $data['website_err'] : '' ?></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-container textarea">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" placeholder="Enter Description"><?php echo $data['description']; ?></textarea>
                            <span class="error-msg"><?php echo !empty($data['description_err']) ? $data['description_err'] : '' ?></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-container">
                            <label for="linkedin">LinkedIn</label>
                            <input type="text" id="linkedin" name="linkedin" value="<?php echo $data['linkedin']; ?>" placeholder="Enter LinkedIn Profile Link" required>
                            <span class="error-msg"><?php echo !empty($data['linkedin_err']) ? $data['linkedin_err'] : '' ?></span>
                        </div>
                        <div class="input-container">
                            <label for="facebook">Facebook</label>
                            <input type="text" id="facebook" name="facebook" value="<?php echo $data['facebook']; ?>" placeholder="Enter Facebook Page Link" required>
                            <span class="error-msg"><?php echo !empty($data['facebook_err']) ? $data['facebook_err'] : '' ?></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-container" style="flex-basis: 100%;">
                            <label for="brCertificate">Business Registration Copy</label>
                            <div class="file-drop-area">
                                <div class="file-content">
                                    <span>Drag & Drop to Upload Business Registration Copy</span>
                                    <button type="button" class="browse-btn">Browse File
                                        <input type="file" id="brCertificate" name="brCertificate" accept=".pdf,.doc,.docx" required>
                                    </button>
                                    <span class="file-name">No file selected</span>
                                </div>
                            </div>
                            <span class="req-msg">Only PDF, DOC, DOCX files are allowed, and maximum file size is 5MB</span>
                            <span class="error-msg"><?php echo !empty($data['brCertificate_err']) ? $data['brCertificate_err'] : ''; ?></span>
                        </div>
                        <!-- <div class="input-container"></div> -->
                    </div>

                    <div class="form-row">
                        <div class="input-container" style="flex-basis: 100%;">
                            <span class="note-msg">Help us get to know your company! Upload your BR certificate and share your website or social media page so we can verify your profile and activate your account.</span>
                        </div>
                    </div>

                    <h3>Address</h3>
                    <div class="form-row">
                        <div class="input-container">
                            <label for="street-no">Street No<span class="req"> *</span></label>
                            <input type="text" id="streetNo" name="streetNo" value="<?php echo $data['streetNo']; ?>" placeholder="Enter Street Number" required>
                            <span class="error-msg"><?php echo !empty($data['streetNo_err']) ? $data['streetNo_err'] : ''; ?></span>
                        </div>
                        <div class="input-container">
                            <label for="address-line1">Address Line 1<span class="req"> *</span></label>
                            <input type="text" id="addressLine1" name="addressLine1" value="<?php echo $data['addressLine1']; ?>" placeholder="Enter Address Line 1" required>
                            <span class="error-msg"><?php echo !empty($data['addressLine1_err']) ? $data['addressLine1_err'] : ''; ?></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-container">
                            <label for="address-line2">Address Line 2</label>
                            <input type="text" id="addressLine2" name="addressLine2" value="<?php echo $data['addressLine2']; ?>" placeholder="Enter Address Line 2">
                            <span class="error-msg"><?php echo !empty($data['addressLine2_err']) ? $data['addressLine2_err'] : ''; ?></span>
                        </div>
                        <div class="input-container">
                            <label for="city">City<span class="req"> *</span></label>
                            <input type="text" id="city" name="city" value="<?php echo $data['city']; ?>" placeholder="Enter City" required>
                            <span class="error-msg"><?php echo !empty($data['city_err']) ? $data['city_err'] : ''; ?></span>
                        </div>
                    </div>

                    <!-- Login Credentials -->
                    <h2>Login Credentials</h2>
                    <div class="form-row">
                        <div class="input-container">
                            <label for="email">Company Email<span class="req"> *</span></label>
                            <input type="email" id="email" name="email" value="<?php echo $_SESSION['verified_email'] ?>" placeholder="Enter Company Email" required readonly>
                            <span class="error-msg"><?php echo !empty($data['email_err']) ? $data['email_err'] : ''; ?></span>
                        </div>
                        <div class="input-container"></div>
                    </div>
                    <div class="form-row">
                        <div class="input-container">
                            <label for="password">Password<span class="req"> *</span></label>
                            <input type="password" id="password" name="password" value="<?php echo $data['password']; ?>" placeholder="Enter Password" required minlength="8">
                            <span class="req-msg">Password must contain at least 8 characters, including UPPER/lowercase and numbers</span>
                            <span class="error-msg"><?php echo !empty($data['password_err']) ? $data['password_err'] : ''; ?></span>
                        </div>
                        <div class="input-container">
                            <label for="confirm_password">Confirm Password<span class="req"> *</span></label>
                            <input type="password" id="confirm_password" name="confirm_password" value="<?php echo $data['confirm_password']; ?>" placeholder="Enter Confirm Password" required minlength="8">
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

                    <div class="form-row">
                        <div class="input-center">
                            <span class="login">Already have an account? <a href="<?php echo URLROOT; ?>/user/login">Login</a></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script type="module" src="<?php echo URLROOT; ?>/public/js/register/fileUpload.js"></script>

</html>