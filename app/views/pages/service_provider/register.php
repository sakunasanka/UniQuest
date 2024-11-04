<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/register.css">


<div class="main-container-without-side">
    <div class="container">
        <div class="image-section">
            <h1>Service Provider Register</h1>
            <img src="<?php echo URLROOT; ?>/images/service.png" alt="Student Registration">
        </div>

        <form class="form-section" action="<?php echo URLROOT ?>/service_provider/register" method="POST" enctype="multipart/form-data">
            <!-- Company Details -->
            <h2>Company Details</h2>
            <div class="form-group">
                <label for="company-name">Company Name</label>
                <input type="text" id="company-name" name="companyName" value="<?php echo $data['companyName']; ?>" required>
                <span class="error-msg"><?php echo !empty($data['companyName_err']) ? $data['companyName_err'] : '' ?></span>
            </div>

            <div class="form-group">
                <label for="company-contact">Company Contact No</label>
                <input type="text" id="company-contact" name="contactNo" value="<?php echo $data['contactNo']; ?>" required>
                <span class="error-msg"><?php echo !empty($data['contactNo_err']) ? $data['contactNo_err'] : '' ?></span>

                <label for="company-logo">Company Logo</label>
                <input type="file" id="companyLogo" name="companyLogo" value="<?php echo $data['companyLogo']; ?>" accept=".jpg, .jpeg, .png">
                <span class="error-msg"><?php echo !empty($data['companyLogo_err']) ? $data['companyLogo_err'] : '' ?></span>

            </div>

            <h3>Company Address</h3>
            <div class="form-group">
                <label for="street-no">Street No</label>
                <input type="text" id="streetNo" name="streetNo" value="<?php echo $data['streetNo']; ?>" required>
                <span class="error-msg"><?php echo !empty($data['streetNo_err']) ? $data['streetNo_err'] : '' ?></span>

                <label for="address-line1">Address Line 1</label>
                <input type="text" id="addressLine1" name="addressLine1" value="<?php echo $data['addressLine1']; ?>" required>
                <span class="error-msg"><?php echo !empty($data['addressLine1_err']) ? $data['addressLine1_err'] : '' ?></span>

                <label for="address-line2">Address Line 2</label>
                <input type="text" id="addressLine2" name="addressLine2" value="<?php echo $data['addressLine2']; ?>">
                <span class="error-msg"><?php echo !empty($data['addressLine2_err']) ? $data['addressLine2_err'] : '' ?></span>

                <label for="city">City</label>
                <input type="text" id="city" name="city" value="<?php echo $data['city']; ?>" required>
                <span class="error-msg"><?php echo !empty($data['city_err']) ? $data['city_err'] : '' ?></span>
            </div>

            <!-- Login Credentials -->
            <h2>Login Credentials</h2>
            <div class="form-group">
                <label for="company-email">Company Email</label>
                <input type="email" id="company-email" name="email" value="<?php echo $data['email']; ?>" required>
                <span class="error-msg"><?php echo !empty($data['email_err']) ? $data['email_err'] : '' ?></span>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" value="<?php echo $data['password']; ?>" required>
                <span class="error-msg"><?php echo !empty($data['password_err']) ? $data['password_err'] : '' ?></span>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" value="<?php echo $data['confirm_password']; ?>" required>
                <span class="error-msg"><?php echo !empty($data['confirm_password_err']) ? $data['confirm_password_err'] : '' ?></span>
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

            <button type="submit" value="register">Register</button>
        </form>
    </div>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>