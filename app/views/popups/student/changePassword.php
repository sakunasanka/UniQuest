<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/change_pass.css">
<div class="popup-container">
    <div class="popup" id="popup-changepw">
        <div class="overlay" onclick="ToggleChangePasswordForm()"></div>
        <div class="content">
            <div class="close-btn-container">
                <button class="close-btn" onclick="ToggleChangePasswordForm()">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <h2 class="changep_title">Change Password</h2>

            <form id="changePasswordForm" method="POST">
                <div class="changep_form-group">
                    <label for="current_password">Current Password</label>
                    <div class="changep_password-wrapper">
                        <input type="password" id="current_password" name="current_password" placeholder="Current password">
                        <span class="changep_password-toggle">&#128065;</span>
                    </div>
                    <span id="current_password_err" class="error-msg"><?php echo $data['current_password_err'] ?? ''; ?></span>
                </div>

                <div class="changep_form-group">
                    <label for="new_password">New Password</label>
                    <div class="changep_password-wrapper">
                        <input type="password" id="new_password" name="new_password" placeholder="New password">
                        <span class="changep_password-toggle">&#128065;</span>
                    </div>
                    <span id="new_password_err" class="error-msg"><?php echo $data['new_password_err'] ?? ''; ?></span>
                </div>

                <div class="changep_form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <div class="changep_password-wrapper">
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password">
                        <span class="changep_password-toggle">&#128065;</span>
                    </div>
                    <span id="confirm_password_err" class="error-msg"><?php echo $data['confirm_password_err'] ?? ''; ?></span>
                </div>

                <div class="changep_form-group">
                    <button class="changep_change-button">Change Password</button>
                </div>

                <span id="error" class="error-msg"><?php echo $data['confirm_password_err'] ?? ''; ?></span>
            </form>
        </div>
    </div>
</div>



<script src="<?php echo URLROOT; ?>/public/js/student/change_password.js"></script>