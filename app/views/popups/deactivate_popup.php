<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/deactivated_popup.css">
<div class="popup-container">
    <div class="popup" id="popup-deactivated">
        <div class="overlay"></div>
        <div class="content">
            <div class="notification-message">
                <span class="material-symbols-outlined deactivated-icon">block</span>
                <h2>Account Deactivated</h2>
                <p>Your account has been deactivated. This could be due to<br> one of the following reasons:</p>
                <ul class="deactivation-reasons">
                    <li>Action taken by a system administrator.</li>
                    <li>Prolonged inactivity on your account.</li>
                </ul>
                <!-- <p class="reactivation-note">
                    To continue using UniQuest, please log in to reactivate your account.
                    <br><b>Note: If you do not log in within 30 days, your account will be permanently deleted.</b>
                </p> -->
            </div>
            <a href="<?php echo URLROOT; ?>" class="go-home-btn">Go to Home Page</a>
        </div>
    </div>
</div>


<script src="<?php echo URLROOT; ?>/public/js/login/deactivate_popup.js"></script>