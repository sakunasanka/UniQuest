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
                    <h1>Verification Team Management</h1>
                </button>

            </div>
            <form class="add-member-form" action="<?php echo URLROOT ?>/admin/add_member" method="POST" enctype="multipart/form-data">
                <h2>Personal Details</h2>
                <div class="form-row">
                    <div class="input-container">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="firstName" placeholder="Enter First Name" required>
                        <span class="error-msg"><?php echo !empty($data['firstName_err']) ? $data['firstName_err'] : ''; ?></span>
                    </div>
                    <div class="input-container">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastName" placeholder="Enter Last Name" required>
                        <span class="error-msg"><?php echo !empty($data['lastName_err']) ? $data['lastName_err'] : ''; ?></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="contactNo">Contact Number</label>
                        <input type="text" id="contactNo" name="contactNo" placeholder="Enter Contact Number" required>
                        <span class="error-msg"><?php echo !empty($data['contactNo_err']) ? $data['contactNo_err'] : ''; ?></span>
                    </div>
                    <div class="input-container">
                        <label for="profilePic">Profile Picture</label>
                        <input type="file" id="profilePic" name="profilePic" accept=".jpg, .jpeg, .png">
                        <span class="error-msg"><?php echo !empty($data['profilePic_err']) ? $data['profilePic_err'] : ''; ?></span>
                    </div>
                </div>
                <h2>Login Credentials</h2>
                <div class="form-row">
                    <div class="input-container">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter Email" required>
                        <span class="error-msg"><?php echo !empty($data['email_err']) ? $data['email_err'] : ''; ?></span>
                    </div>
                    <div class="input-container"></div>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter Password" required>
                        <span class="error-msg"><?php echo !empty($data['password_err']) ? $data['password_err'] : ''; ?></span>
                    </div>
                    <div class="input-container">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Enter Confirm Password" required>
                        <span class="error-msg"><?php echo !empty($data['confirm_password_err']) ? $data['confirm_password_err'] : ''; ?></span>
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