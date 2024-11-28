<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/studentPopups.css">
<div class="popup-container">
    <div class="popup" id="popup-changepw">
        <div class="overlay"></div>
        <div class="content">
        <div class="close-btn-container"><button class="close-btn" onclick="ToggleChangePasswordForm()"><i class="fa fa-times"></i></button></div>
            <h2>Change password</h2>

            <form action="#" method="post">
                <div class="changep_form-group">
                    <label for="current-password">Current Password</label>
                    <div class="changep_password-wrapper">
                        <input type="password" id="current-password" name="current-password" placeholder="Password">
                        <span class="changep_password-toggle">&#128065;</span> <!-- Eye icon -->
                    </div>
                </div>
                <div class="changep_form-group">
                    <label for="new-password">New Password</label>
                    <div class="changep_password-wrapper">
                        <input type="password" id="new-password" name="new-password" placeholder="Password">
                        <span class="changep_password-toggle">&#128065;</span> <!-- Eye icon -->
                    </div>
                </div>
                <div class="changep_form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <div class="changep_password-wrapper">
                        <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm new password">
                        <span class="changep_password-toggle">&#128065;</span> <!-- Eye icon -->
                    </div>
                </div>
                <!-- Change Password button -->
                <div class="changep_form-group">
                    <button class="changep_change-button"  onclick="ToggleChangePasswordForm()">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/public/js/student/change_password.js"></script>