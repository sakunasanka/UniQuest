<?php require APPROOT . '/views/components/header.php'; ?>

<body>
    <div class="container">
        <div class="image-section">
            <h1>Service Provider Register</h1>
            <img src="<?php echo URLROOT; ?>/images/service.png" alt="Student Registration">
        </div>

        <div class="form-section">
            <form id="registrationForm" onsubmit="return validateForm()">

                <!-- Personal Details -->
                <h2>Personal Details</h2>
                <div class="form-group">
                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" name="first-name" required>

                    <label for="last-name">Last Name</label>
                    <input type="text" id="last-name" name="last-name" required>
                
                    <label for="gender">Gender</label>
                    <input type="radio" id="male" name="gender" value="male" required> <label for="male">Male</label>
                    <input type="radio" id="female" name="gender" value="female" required> <label for="female">Female</label>

                    <label for="dob">Date Of Birth</label>
                    <input type="date" id="dob" name="dob" required>
                    <span id="dob-error" class="error-message"></span>

                    <label for="nic-number">NIC Number</label>
                    <input type="text" id="nic-number" name="nic-number" required>
                    <span id="nic-error" class="error-message"></span>

                    <label for="nic-scan">NIC Scanned Copy</label>
                    <input type="file" id="nic-scan" name="nic-scan" accept=".jpg, .jpeg, .png, .pdf">
                
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" required>

                    <label for="mobile">Mobile</label>
                    <input type="text" id="mobile" name="mobile" required>
                    <span id="mobile-error" class="error-message"></span>
               
                    <label for="personal-email">Personal Email</label>
                    <input type="email" id="personal-email" name="personal-email" required>
                    <span id="personal-email-error" class="error-message"></span>

                </div>

                <!-- Company Details -->
                <h2>Company Details</h2>
                <div class="form-group">
                    <label for="company-name">Company Name</label>
                    <input type="text" id="company-name" name="company-name" required>

                    <label for="company-email">Company Email</label>
                    <input type="email" id="company-email" name="company-email" required>
                    <span id="company-email-error" class="error-message"></span>
                
                    <label for="company-contact">Company Contact No</label>
                    <input type="text" id="company-contact" name="company-contact" required>
                    <span id="company-contact-error" class="error-message"></span>

                    <label for="company-logo">Company Logo</label>
                    <input type="file" id="company-logo" name="company-logo" accept=".jpg, .jpeg, .png">
                </div>

                <!-- Login Credentials -->
                <h2>Login Credentials</h2>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                    <span id="username-error" class="error-message"></span>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <span id="password-error" class="error-message"></span>
               
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                    <span id="confirm-password-error" class="error-message"></span>
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
            </form>
        </div>
    </div>

    <script>
           document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        
        // Age validation
        const dobField = document.getElementById('dob');
        const dobError = document.getElementById('dob-error');
        dobField.addEventListener('change', function () {
            const dob = new Date(dobField.value);
            const age = new Date().getFullYear() - dob.getFullYear();
            if (age < 18 || (age === 18 && new Date() < new Date(dob.setFullYear(dob.getFullYear() + 18)))) {
                dobError.textContent = 'You must be at least 18 years old to register.';
            } else {
                dobError.textContent = '';
            }
        });

        // Personal mobile number validation
        const mobileField = document.getElementById('mobile');
        const mobileError = document.getElementById('mobile-error');
        mobileField.addEventListener('input', function () {
            if (!/^\d{10}$/.test(mobileField.value)) {
                mobileError.textContent = "Please enter a valid 10-digit phone number.";
            } else {
                mobileError.textContent = '';
            }
        });

        // Company phone number validation
        const companyContactField = document.getElementById('company-contact');
        const companyContactError = document.getElementById('company-contact-error');
        companyContactField.addEventListener('input', function () {
            if (!/^\d{10}$/.test(companyContactField.value)) {
                companyContactError.textContent = "Please enter a valid 10-digit company contact number.";
            } else {
                companyContactError.textContent = '';
            }
        });

        // Password validation
        const passwordField = document.getElementById('password');
        const passwordError = document.getElementById('password-error');
        const confirmPasswordField = document.getElementById('confirm-password');
        const confirmPasswordError = document.getElementById('confirm-password-error');
        
        function validatePassword() {
            const password = passwordField.value;
            if (password.length < 8 || !/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[0-9]/.test(password)) {
                passwordError.textContent = "Password must be at least 8 characters, with uppercase, lowercase letters, and a number.";
            } else {
                passwordError.textContent = '';
            }
        }

        passwordField.addEventListener('input', validatePassword);

        confirmPasswordField.addEventListener('input', function () {
            if (passwordField.value !== confirmPasswordField.value) {
                confirmPasswordError.textContent = "Passwords do not match.";
            } else {
                confirmPasswordError.textContent = '';
            }
        });

         // Personal email validation
        const personalEmailField = document.getElementById('personal-email');
        const personalEmailError = document.getElementById('personal-email-error');
        personalEmailField.addEventListener('input', function () {
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailRegex.test(personalEmailField.value)) {
                personalEmailError.textContent = "Please enter a valid email address.";
            } else {
                personalEmailError.textContent = '';
            }
        });

        // Company email validation
        const companyEmailField = document.getElementById('company-email');
        const companyEmailError = document.getElementById('company-email-error');
        companyEmailField.addEventListener('input', function () {
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailRegex.test(companyEmailField.value)) {
                companyEmailError.textContent = "Please enter a valid email address.";
            } else {
                companyEmailError.textContent = '';
            }
        });

        // NIC validation
        const nicField = document.getElementById('nic-number');
        const nicError = document.getElementById('nic-error');
        nicField.addEventListener('input', function () {
            // Assuming NIC format: either 10 digits (old format) or 12 digits (new format)
            const nicRegex = /^(?:\d{9}[VvXx]|\d{12})$/;
            if (!nicRegex.test(nicField.value)) {
                nicError.textContent = "Please enter a valid NIC (e.g., 123456789V or 123456789123).";
            } else {
                nicError.textContent = '';
            }
        });

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (validatePassword()) {
            form.submit();
            }
        });
    });
    </script>
</body>
