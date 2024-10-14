<?php require APPROOT . '/views/components/header.php'; ?>

<body>
    <div class="container">
        <div class="image-section">
            <h1>Service Provider Register</h1>
            <img src="<?php echo URLROOT; ?>/images/service.png" alt="Student Registration">
        </div>
        
        <div class="form-section">
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
                <input type="radio" id="male" name="gender" value="male"> <label for="male">Male</label>
                <input type="radio" id="female" name="gender" value="female"> <label for="female">Female</label>

                <label for="dob">Date Of Birth</label>
                <input type="date" id="dob" name="dob" required>
            </div>

            <div class="form-group">
                <label for="nic-number">NIC Number</label>
                <input type="text" id="nic-number" name="nic-number" required>
                
                <label for="nic-scan">NIC Scanned Copy</label>
                <input type="file" id="nic-scan" name="nic-scan" accept=".jpg, .jpeg, .png, .pdf">
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" required>

                <label for="mobile">Mobile</label>
                <input type="text" id="mobile" name="mobile" required>
            </div>

            <div class="form-group">
                <label for="personal-email">Personal Email</label>
                <input type="email" id="personal-email" name="personal-email" required>
            </div>

            <!-- Company Details -->
            <h2>Company Details</h2>
            <div class="form-group">
                <label for="company-name">Company Name</label>
                <input type="text" id="company-name" name="company-name" required>

                <label for="company-email">Company Email</label>
                <input type="email" id="company-email" name="company-email" required>
            </div>

            <div class="form-group">
                <label for="company-contact">Company Contact No</label>
                <input type="text" id="company-contact" name="company-contact" required>

                <label for="company-logo">Company Logo</label>
                <input type="file" id="company-logo" name="company-logo" accept=".jpg, .jpeg, .png">
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

            <!-- Terms and Register Button -->
            <div class="form-group terms">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">
                    I agreed to all 
                    <a href="terms.html" target="_blank">Terms</a> and 
                    <a href="privacy.html" target="_blank">Privacy Policy</a>
                </label>
            </div>

            <button type="submit">Register</button>
        </div>
    </div>
</body>

<?php require APPROOT . '/views/components/footer.php'; ?>
