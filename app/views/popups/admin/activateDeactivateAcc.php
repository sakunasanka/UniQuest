<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/admin/adminPopups.css">
<div class="popup-container">
    <div class="popup" id="deact-popup" data-urlroot="<?php echo URLROOT; ?>" aria-hidden="true">
        <div class="overlay" onclick="closePopup('deact-popup')"></div>
        <div class="content" role="dialog" aria-labelledby="popup-title" aria-describedby="popup-desc">
            <button class="close-btn" onclick="closePopup('deact-popup')" aria-label="Close"><i class="fa fa-times"></i></button>
            <p id="popup-desc" class="popup-text red-text">Are you sure you want to deactivate this account?</p>
            <input type="hidden" id="ID" value="">
            <input type="hidden" id="category" value="">
            <div class="btn-container">
                <button class="no-btn" onclick="closePopup('deact-popup')">No</button>
                <button class="yes-btn-red" onclick="confirmDeactivationAcc()">Yes</button>
            </div>
        </div>
    </div>
</div>

<div class="popup-container">
    <div class="popup" id="act-popup" data-urlroot="<?php echo URLROOT; ?>" aria-hidden="true">
        <div class="overlay" onclick="closePopup('act-popup')"></div>
        <div class="content" role="dialog" aria-labelledby="popup-title" aria-describedby="popup-desc">
            <button class="close-btn" onclick="closePopup('act-popup')" aria-label="Close"><i class="fa fa-times"></i></button>
            <p id="popup-desc" class="popup-text">Are you sure you want to activate this account?</p>
            <input type="hidden" id="ID" value="">
            <input type="hidden" id="category" value="">
            <div class="btn-container">
                <button class="no-btn" onclick="closePopup('act-popup')">No</button>
                <button class="yes-btn" onclick="confirmActivationAcc()">Yes</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/public/js/admin/popups.js"></script>