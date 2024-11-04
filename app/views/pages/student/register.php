<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/register.css">

<body>
    <div class="main-container-without-side">
        <div class="container">
            <div class="image-section">
                <h1>Student Registration</h1>
                <img src="<?php echo URLROOT; ?>/images/college students-amico.png" alt="Student Registration">
            </div>
            <div class="form-section">
                <form action="<?php echo URLROOT ?>/student/register" method="POST" enctype="multipart/form-data">
                    <!-- Personal Details -->
                    <h2>Personal Details</h2>
                    <div class="form-group">
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" name="firstName" value="<?php echo $data['firstName']; ?>" required>
                        <span class="error-msg"><?php echo $data['firstName_err']; ?></span>

                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" name="lastName" value="<?php echo $data['lastName']; ?>" required>
                        <span class="error-msg"><?php echo $data['lastName_err']; ?></span>

                        <label for="profile-pic">Profile Picture</label>
                        <input type="file" id="profilePic" name="profilePic" value="<?php echo $data['profilePic']; ?>" accept=".jpg, .jpeg, .png">
                        <span class="error-msg"><?php echo $data['profilePic_err']; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <input type="radio" id="male" name="gender" value="male">
                        <label for="male">Male</label>

                        <input type="radio" id="female" name="gender" value="female">
                        <label for="female">Female</label>
                        <span class="error-msg"><?php echo $data['gender_err']; ?></span>

                        <label for="dob">Date Of Birth</label>
                        <input type="date" id="dob" name="dob" value="<?php echo $data['dob']; ?>" required>
                        <span class="error-msg"><?php echo $data['dob_err']; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="nicNo">NIC Number</label>
                        <input type="text" id="nicNo" name="nicNo" value="<?php echo $data['nicNo']; ?>" required>
                        <span class="error-msg"><?php echo $data['nicNo_err']; ?></span>

                        <label for="nicCopy">NIC Scanned Copy</label>
                        <input type="file" id="nicCopy" name="nicCopy" value="<?php echo $data['nicCopy']; ?>" accept=".jpg, .jpeg, .png, .pdf">
                        <span class="error-msg"><?php echo $data['nicCopy_err']; ?></span>
                    </div>

                    <!-- New Attach CV Section -->
                    <div class="form-group">
                        <label for="cv">Attach CV</label>
                        <input type="file" id="cv" name="cv" value="<?php echo $data['cv']; ?>" accept=".pdf,.doc,.docx">
                        <span class="error-msg"><?php echo $data['cv_err']; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="contactNo">Contact Number</label>
                        <input type="text" id="contactNo" name="contactNo" value="<?php echo $data['contactNo']; ?>" required>
                        <span class="error-msg"><?php echo $data['contactNo_err']; ?></span>
                    </div>

                    <h3>Address</h3>
                    <div class="form-group">
                        <label for="street-no">Street No</label>
                        <input type="text" id="streetNo" name="streetNo" value="<?php echo $data['streetNo']; ?>" required>
                        <span class="error-msg"><?php echo $data['streetNo_err']; ?></span>

                        <label for="address-line1">Address Line 1</label>
                        <input type="text" id="addressLine1" name="addressLine1" value="<?php echo $data['addressLine1']; ?>" required>
                        <span class="error-msg"><?php echo $data['addressLine1_err']; ?></span>

                        <label for="address-line2">Address Line 2</label>
                        <input type="text" id="addressLine2" name="addressLine2" value="<?php echo $data['addressLine2']; ?>">
                        <span class="error-msg"><?php echo $data['addressLine2_err']; ?></span>

                        <label for="city">City</label>
                        <input type="text" id="city" name="city" value="<?php echo $data['city']; ?>" required>
                        <span class="error-msg"><?php echo $data['city_err']; ?></span>
                    </div>

                    <!-- University Details -->
                    <h2>University Details</h2>

                    <div class="form-group">
                        <label for="university">University</label>
                        <input type="text" id="university" name="university" value="<?php echo $data['university']; ?>" required>
                        <span class="error-msg"><?php echo $data['university_err']; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="universityID">University ID Number</label>
                        <input type="text" id="universityID" name="universityID" value="<?php echo $data['universityID']; ?>" required>
                        <span class="error-msg"><?php echo $data['universityID_err']; ?></span>

                        <label for="universityIDCopy">University ID Scanned Copy</label>
                        <input type="file" id="universityIDCopy" name="universityIDCopy" value="<?php echo $data['universityIDCopy']; ?>" accept=".jpg, .jpeg, .png, .pdf">
                        <span class="error-msg"><?php echo $data['universityIDCopy_err']; ?></span>
                    </div>

                    <!-- Login Credentials -->
                    <h2>Login Credentials</h2>

                    <div class="form-group">
                        <label for="email">University Email</label>
                        <input type="email" id="email" name="email" value="<?php echo $data['email']; ?>" required>
                        <span class="error-msg"><?php echo $data['email_err']; ?></span>

                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" value="<?php echo $data['password']; ?>" required>
                        <span class="error-msg"><?php echo $data['password_err']; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" value="<?php echo $data['confirm_password']; ?>" required>
                        <span class="error-msg"><?php echo $data['confirm_password_err']; ?></span>

                    </div>

                    <div class="form-group terms">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">
                            I agreed to all
                            <a href="terms.html" target="_blank">Terms</a>
                            and
                            <a href="privacy.html" target="_blank">Privacy Policy</a>
                        </label>
                    </div>

                    <button type="submit">Register</button>
                </form>
            </div>
        </div>
    </div>

    <?php require APPROOT . '/views/components/footer.php'; ?>