<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/deactivated_popup.css">
<div class="popup-container">
    <div class="popup" id="popup-deactivated">
        <div class="overlay"></div>
        <div class="content">
            <div class="notification-message">
                <h2>
                    <span class="material-symbols-outlined">block</span> 
                    Account Deactivated
                </h2>
                <p>
                    Your account has been deactivated. This could be due to one of the following reasons:
                </p>
                <ul class="deactivation-reasons">
                    <li>Deactivation request made by you.</li>
                    <li>Action taken by a system administrator.</li>
                    <li>Prolonged inactivity on your account.</li>
                </ul>
                <span>
                    To continue using UniQuest, please log in to reactivate your account. <b>Note: If you do not log in within 30 days, your account will be permanently deleted</b> 
                </span>
            </div>
            <div class="button-container">
                <a href="<?php echo URLROOT; ?>" class="go-home-btn">Go to Home Page</a>
                <a href="<?php echo URLROOT; ?>/user/login" class="login-again-btn">Log in Again</a>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/public/js/login/deactivate_popup.js"></script>