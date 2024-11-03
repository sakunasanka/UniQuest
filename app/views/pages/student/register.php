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
                <form action="submit_registration.php" method="POST" enctype="multipart/form-data">
                    <!-- Personal Details -->
                    <h2>Personal Details</h2>
                    <div class="form-group">
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" name="first-name" required>
                        
                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" name="last-name" required>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <input type="radio" id="male" name="gender" value="male">
                        <label for="male">Male</label>

                        <input type="radio" id="female" name="gender" value="female">
                        <label for="female">Female</label>

                        <label for="dob">Date Of Birth</label>
                        <input type="date" id="dob" name="dob" required>
                    </div>

                    <div class="form-group">
                        <label for="nic-number">NIC Number</label>
                        <input type="text" id="nic-number" name="nic-number" required>
                        
                        <label for="nic-scan">NIC Scanned Copy</label>
                        <input type="file" id="nic-scan" name="nic-scan" accept=".jpg, .jpeg, .png, .pdf">
                    </div>

                    <!-- New Attach CV Section -->
                    <div class="form-group">
                        <label for="cv-upload">Attach CV</label>
                        <input type="file" id="cv-upload" name="cv-upload" accept=".pdf,.doc,.docx">
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" required>

                        <label for="mobile">Mobile</label>
                        <input type="text" id="mobile" name="mobile" required>
                    </div>

                    <!-- University Details -->
                    <h2>University Details</h2>

                    <div class="form-group">
                        <label for="university">University</label>
                        <input type="text" id="university" name="university" required>
                        
                        <label for="university-email">University Email</label>
                        <input type="email" id="university-email" name="university-email" required>
                    </div>

                    <div class="form-group">
                        <label for="university-id-number">University ID Number</label>
                        <input type="text" id="university-id-number" name="university-id-number" required>
                        
                        <label for="university-id-scan">University ID Scanned Copy</label>
                        <input type="file" id="university-id-scan" name="university-id-scan" accept=".jpg, .jpeg, .png, .pdf">
                    </div>

                    <!-- Login Credentials -->
                    <h2>Login Credentials</h2>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>

                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" id="confirm-password" name="confirm-password" required>
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
