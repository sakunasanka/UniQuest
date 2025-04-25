<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/deactivated_popup.css">
<div class="popup-container">
    <div class="popup" id="popup-not-approved">
        <div class="overlay"></div>
        <div class="content">
            <div class="notification-message">
            <span class="material-symbols-outlined deactivated-icon">cancel</span>
                <h2>Request Not Approved</h2>
                <p>Unfortunately, your request to join UniQuest was not approved.</p>
                <p>You can submit a new registration request after <b>15 days</b>.</p>
            </div>
            <a href="<?php echo URLROOT; ?>" class="go-home-btn">Go to Home Page</a>
        </div>
    </div>
</div>
<script src="<?php echo URLROOT; ?>/public/js/login/not_approved.js"></script>
