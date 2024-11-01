<?php require APPROOT . '/views/components/ser_header.php'; ?>

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
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter Email" required>
                    </div>
                    <div class="input-container">
                        <label for="mobile">Mobile Number</label>
                        <input type="text" id="mobile" name="mobile" placeholder="Enter Mobile Number" required>
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