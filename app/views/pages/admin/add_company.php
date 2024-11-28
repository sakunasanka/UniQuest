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
                    <h1>Company Management</h1>
                </button>

            </div>
            <form class="add-member-form">
                <h2>Company Details</h2>
                <div class="form-row">
                    <div class="input-container">
                        <label for="name">Company Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter Company Name" required>
                    </div>
                    <div class="input-container">
                        <label for="logo">Company Logo</label>
                        <input type="file" id="logo" name="logo">
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="email">Company Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter Company Email" required>
                    </div>
                    <div class="input-container">
                        <label for="phone">Contact Number</label>
                        <input type="text" id="phone" name="phone" placeholder="Enter Contact Number" required>
                    </div>
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
                <h2>Login Credential</h2>
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