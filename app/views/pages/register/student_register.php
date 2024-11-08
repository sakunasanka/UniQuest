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
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" name="firstName" value="<?php echo $data['firstName']; ?>" required>
                        <span class="error-msg"><?php echo !empty($data['firstName_err']) ? $data['firstName_err'] : ''; ?></span>
                    </div>
                    <div class="input-container">
                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" name="lastName" value="<?php echo $data['lastName']; ?>" required>
                        <span class="error-msg"><?php echo !empty($data['lastName_err']) ? $data['lastName_err'] : ''; ?></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="dob">Date Of Birth</label>
                        <input type="date" id="dob" name="dob" value="<?php echo $data['dob']; ?>" required>
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
                        <label for="nicNo">NIC Number</label>
                        <input type="text" id="nicNo" name="nicNo" value="<?php echo $data['nicNo']; ?>" required>
                        <span class="error-msg"><?php echo !empty($data['nicNo_err']) ? $data['nicNo_err'] : ''; ?></span>
                    </div>
                    <div class="input-container">
                        <label for="contactNo">Contact Number</label>
                        <input type="text" id="contactNo" name="contactNo" value="<?php echo $data['contactNo']; ?>" required>
                        <span class="error-msg"><?php echo !empty($data['contactNo_err']) ? $data['contactNo_err'] : ''; ?></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="nicCopy">NIC Scanned Copy</label>
                        <div class="file-drop-area">
                            <div class="file-content">
                                <span>Drag & Drop to Upload file</span>
                                <button type="button" class="browse-btn">Browse File
                                    <input type="file" id="nicCopy" name="nicCopy" accept=".jpg, .jpeg, .png, .pdf">
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

                <!-- University Details -->
                <h2>University Details</h2>
                <div class="form-row">
                    <div class="input-container">
                        <label for="university">University</label>
                        <input type="text" id="university" name="university" value="<?php echo $data['university']; ?>" required>
                        <span class="error-msg"><?php echo !empty($data['university_err']) ? $data['university_err'] : ''; ?></span>
                    </div>
                    <div class="input-container">
                        <label for="universityID">University ID Number</label>
                        <input type="text" id="universityID" name="universityID" value="<?php echo $data['universityID']; ?>" required>
                        <span class="error-msg"><?php echo !empty($data['universityID_err']) ? $data['universityID_err'] : ''; ?></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="universityIDCopy">University ID Scanned Copy</label>
                        <div class="file-drop-area">
                            <div class="file-content">
                                <span>Drag & Drop to Upload file</span>
                                <button type="button" class="browse-btn">Browse File
                                    <input type="file" id="universityIDCopy" name="universityIDCopy" accept=".jpg, .jpeg, .png, .pdf">
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
                        <label for="email">University Email</label>
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