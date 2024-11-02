<?php require APPROOT . '/views/components/header.php'; ?>

<body>
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
               
                    <label for="gender">Gender</label>
                    <input type="radio" id="male" name="gender" value="male">
                    <label for="male">Male</label>

                    <input type="radio" id="female" name="gender" value="female">
                    <label for="female">Female</label>

                    <label for="dob">Date Of Birth</label>
                    <input type="date" id="dob" name="dob" required>
                    <span id="dob-error" class="error-message"></span> 

                    <label for="nic-number">NIC Number</label>
                    <input type="text" id="nic-number" name="nic-number" required>
                    <span id="nic-error" class="error-message"></span>
                    
                    <label for="nic-scan">NIC Scanned Copy</label>
                    <input type="file" id="nic-scan" name="nic-scan" accept=".jpg, .jpeg, .png, .pdf">

                    <label for="cv-upload">Attach CV</label>
                    <input type="file" id="cv-upload" name="cv-upload" accept=".pdf,.doc,.docx">

                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" required>

                    <label for="mobile">Mobile</label>
                    <input type="text" id="mobile" name="mobile" required>
                    <span id="mobile-error" class="error-message"></span>
                </div>

                <!-- University Details -->
                <h2>University Details</h2>

                <div class="form-group">
                    <label for="university">University</label>
                    <input type="text" id="university" name="university" required>
                    
                    <label for="university-email">University Email</label>
                    <input type="email" id="university-email" name="university-email" required>
                    <span id="email-error" class="error-message"></span>

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
                    <span id="password-error" class="error-message"></span>

                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                    <span id="confirm-password-error" class="error-message"></span>
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

        // Phone number validation
        const mobileField = document.getElementById('mobile');
        const mobileError = document.getElementById('mobile-error');
        mobileField.addEventListener('input', function () {
            if (!/^\d{10}$/.test(mobileField.value)) {
                mobileError.textContent = "Please enter a valid 10-digit phone number.";
            } else {
                mobileError.textContent = '';
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

        // Email validation
        const emailField = document.getElementById('university-email');
        const emailError = document.getElementById('email-error');
        emailField.addEventListener('input', function () {
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailRegex.test(emailField.value)) {
                emailError.textContent = "Please enter a valid email address.";
            } else {
                emailError.textContent = '';
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
            validatePassword();
        });
    });
</script>

</body>


