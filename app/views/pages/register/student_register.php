<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/styles.css">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/register/reg_form.css">


<div class="reg-container">
    <button class="back" onclick="window.history.back()">
        <span class="material-symbols-outlined">arrow_back</span>
    </button>
    <div class="container">
        <div class="image-section">
            <h1>Student Registration</h1>
            <img src="<?php echo URLROOT; ?>/images/college students-amico.png" alt="Student Registration">
        </div>
        <div class="form-section">
            <form action="<?php echo URLROOT ?>/register/student" method="POST" enctype="multipart/form-data">
                <!-- Personal Details -->
                <h2>Personal Details</h2>
                <div class="form-row">
                    <div class="input-profile-pic">
                        <div class="file-drop-area">
                            <div class="profile-pic-preview" id="profile-pic-preview">
                                <img src="<?php echo URLROOT; ?>/images/profile_pic_preview.png" alt="profilepic-placeholder">
                            </div>
                            <div class="file-content">
                                <span>Drag & Drop to Upload file</span>
                                <button type="button" class="browse-btn">Browse File
                                    <input type="file" id="profilePic" name="profilePic" accept=".jpg, .jpeg, .png">
                                </button>
                                <span class="file-name">No file selected</span>
                            </div>
                        </div>
                        <span class="error-msg"><?php echo !empty($data['profilePic_err']) ? $data['profilePic_err'] : ''; ?></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="first-name">First Name<span class="req"> *</span></label>
                        <input type="text" id="first-name" name="firstName" value="<?php echo $data['firstName']; ?>" placeholder="Enter First Name" required>
                        <span class="error-msg"><?php echo !empty($data['firstName_err']) ? $data['firstName_err'] : ''; ?></span>
                    </div>
                    <div class="input-container">
                        <label for="last-name">Last Name<span class="req"> *</span></label>
                        <input type="text" id="last-name" name="lastName" value="<?php echo $data['lastName']; ?>" placeholder="Enter Last Name" required>
                        <span class="error-msg"><?php echo !empty($data['lastName_err']) ? $data['lastName_err'] : ''; ?></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="dob">Date Of Birth<span class="req"> *</span></label>
                        <input type="date" id="dob" name="dob" value="<?php echo $data['dob']; ?>" placeholder="Enter Date of Birth" required>
                        <span class="error-msg"><?php echo !empty($data['dob_err']) ? $data['dob_err'] : ''; ?></span>
                    </div>
                    <div class="input-container">
                        <label for="gender">Gender</label>
                        <input type="radio" id="male" name="gender" value="male">
                        <span for="male">Male</span>
                        <input type="radio" id="female" name="gender" value="female">
                        <span for="female">Female</span> <br>
                        <span class="error-msg"><?php echo !empty($data['gender_err']) ? $data['gender_err'] : ''; ?></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="nicNo">NIC Number<span class="req"> *</span></label>
                        <input type="text" id="nicNo" name="nicNo" value="<?php echo $data['nicNo']; ?>" placeholder="Enter NIC Number" required>
                        <span class="error-msg"><?php echo !empty($data['nicNo_err']) ? $data['nicNo_err'] : ''; ?></span>
                    </div>
                    <div class="input-container">
                        <label for="contactNo">Contact Number<span class="req"> *</span></label>
                        <input type="text" id="contactNo" name="contactNo" value="<?php echo $data['contactNo']; ?>" placeholder="Enter Contact Number" required>
                        <span class="error-msg"><?php echo !empty($data['contactNo_err']) ? $data['contactNo_err'] : ''; ?></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="nicCopy">NIC Scanned Copy<span class="req"> *</span></label>
                        <div class="file-drop-area">
                            <div class="file-content">
                                <span>Drag & Drop to Upload file</span>
                                <button type="button" class="browse-btn">Browse File
                                    <input type="file" id="nicCopy" name="nicCopy" accept=".jpg, .jpeg, .png, .pdf" required>
                                </button>
                                <span class="file-name">No file selected</span>
                            </div>
                        </div>
                        <span class="error-msg"><?php echo !empty($data['nicCopy_err']) ? $data['nicCopy_err'] : ''; ?></span>
                    </div>
                    <div class="input-container">
                        <label for="cv">Attach CV</label>
                        <div class="file-drop-area">
                            <div class="file-content">
                                <span>Drag & Drop to Upload file</span>
                                <button type="button" class="browse-btn">Browse File
                                    <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx">
                                </button>
                                <span class="file-name">No file selected</span>
                            </div>
                        </div>
                        <span class="error-msg"><?php echo !empty($data['cv_err']) ? $data['cv_err'] : ''; ?></span>
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

                <!-- University Details -->
                <h2>University Details</h2>
                <div class="form-row">
                    <div class="input-container">
                        <label for="university">University<span class="req"> *</span></label>
                        <input type="text" id="university" name="university" value="<?php echo $data['university']; ?>" placeholder="Enter University" required>
                        <span class="error-msg"><?php echo !empty($data['university_err']) ? $data['university_err'] : ''; ?></span>
                    </div>
                    <div class="input-container">
                        <label for="universityID">University ID Number<span class="req"> *</span></label>
                        <input type="text" id="universityID" name="universityID" value="<?php echo $data['universityID']; ?>" placeholder="Enter University ID Number" required>
                        <span class="error-msg"><?php echo !empty($data['universityID_err']) ? $data['universityID_err'] : ''; ?></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="universityIDCopy">University ID Scanned Copy<span class="req"> *</span></label>
                        <div class="file-drop-area">
                            <div class="file-content">
                                <span>Drag & Drop to Upload file</span>
                                <button type="button" class="browse-btn">Browse File
                                    <input type="file" id="universityIDCopy" name="universityIDCopy" accept=".jpg, .jpeg, .png, .pdf" required>
                                </button>
                                <span class="file-name">No file selected</span>
                            </div>
                        </div>
                        <span class="error-msg"><?php echo !empty($data['universityIDCopy_err']) ? $data['universityIDCopy_err'] : ''; ?></span>
                    </div>
                    <div class="input-container"></div>
                </div>

                <!-- Login Credentials -->
                <h2>Login Credentials</h2>
                <div class="form-row">
                    <div class="input-container">
                        <label for="email">University Email<span class="req"> *</span></label>
                        <input type="email" id="email" name="email" value="<?php echo $data['email']; ?>" placeholder="Enter University Email" required>
                        <span class="error-msg"><?php echo !empty($data['email_err']) ? $data['email_err'] : ''; ?></span>
                    </div>
                    <div class="input-container"></div>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="password">Password<span class="req"> *</span></label>
                        <input type="password" id="password" name="password" value="<?php echo $data['password']; ?>" placeholder="Enter Password" required>
                        <span class="password-req">Password must contain at least 8 characters, including UPPER/lowercase and numbers</span>
                        <span class="error-msg"><?php echo !empty($data['password_err']) ? $data['password_err'] : ''; ?></span>
                    </div>
                    <div class="input-container">
                        <label for="confirm_password">Confirm Password<span class="req"> *</span></label>
                        <input type="password" id="confirm_password" name="confirm_password" value="<?php echo $data['confirm_password']; ?>" placeholder="Enter Confirm Password" required>
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

<script type="module" src="<?php echo URLROOT; ?>/public/js/register/fileUpload.js"></script>