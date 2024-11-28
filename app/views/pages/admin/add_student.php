<?php require APPROOT . '/views/components/adm_header.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="table-block">
            <div class="content-header">
                <button class="back-btn">
                    <span class="material-symbols-outlined">arrow_back_ios</span>
                    <h1>Student Management</h1>
                </button>

            </div>
            <form class="add-member-form">
                <h2>Personal Details</h2>
                <div class="form-row">
                    <div class="input-container">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="firstName" placeholder="Enter First Name" required>
                    </div>
                    <div class="input-container">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastName" placeholder="Enter Last Name" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" placeholder="Enter Date of Birth" required>
                    </div>
                    <div class="input-container">
                        <label for="gender">Gender</label>
                        <input type="radio" id="male" name="gender" value="male">
                        <span>Male</span>
                        <input type="radio" id="female" name="gender" value="fenale">
                        <span>Female</span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="mobile">Mobile Number</label>
                        <input type="text" id="mobile" name="mobile" placeholder="Enter Mobile Number" required>
                    </div>
                    <div class="input-container">
                        <label for="profile-photo">Profile Photo</label>
                        <input type="file" id="profile-photo" name="profile-photo">
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="nic">NIC Number</label>
                        <input type="text" id="nic" name="nic" placeholder="Enter NIC Number" required>
                    </div>
                    <div class="input-container">
                        <label for="nic-scan">NIC Scanned Copy</label>
                        <input type="file" id="nic-scan" name="nic-scan" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="cv">Attached CV</label>
                        <input type="file" id="cv" name="cv">
                    </div>
                    <div class="input-container"></div>
                </div>
                <h3>Address</h3>
                <div class="form-row">
                    <div class="input-container">
                        <label for="address-no">Street Number</label>
                        <input type="text" id="address-no" name="address-no" placeholder="Enter Street Number" required>
                    </div>
                    <div class="input-container">
                        <label for="address-line1">Address Line 1</label>
                        <input type="text" id="address-line1" name="address-line1" placeholder="Enter Address Line 1" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="address-line2">Address Line 2</label>
                        <input type="text" id="address-line2" name="address-line2" placeholder="Enter Address Line 2">
                    </div>
                    <div class="input-container">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" placeholder="Enter City" required>
                    </div>
                </div>
                <h2>University Details</h2>
                <div class="form-row">
                    <div class="input-container">
                        <label for="university">University</label>
                        <input type="text" id="university" name="university" placeholder="Enter University" required>
                    </div>
                    <div class="input-container">
                        <label for="email">University Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter University Email" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="university-id">University ID Number</label>
                        <input type="text" id="university-id" name="university-id" placeholder="Enter University ID Number" required>
                    </div>
                    <div class="input-container">
                        <label for="university-id-scan">University ID Scanned Copy</label>
                        <input type="file" id="university-id-scan" name="university-id-scan" required>
                    </div>
                </div>
                <h2>Login Credentials</h2>
                <div class="form-row">
                    <div class="input-container">
                        <label for="userName">User Name</label>
                        <input type="text" id="userName" name="userName" placeholder="Enter User Name" required>
                    </div>
                    <div class="input-container"></div>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter Password" required>
                    </div>
                    <div class="input-container">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" id="confirm-password" name="confirm-password" placeholder="Enter Confirm Password" required>
                    </div>
                </div>
                <div class="form-row">
                <div class="input-container"></div>
                    <button class="save-btn" type="submit">
                        <span class="material-symbols-outlined">save</span>
                        <span class="add-btn-text">Save</span>
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>


<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminBackButton.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>