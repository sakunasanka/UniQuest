<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/review_popup.css">
<div class="popup-container">
    <div class="popup" id="message-popup">
        <div class="overlay"></div>
        <div class="content">
            <div class="close-btn-container">
                <button class="close-btn" onclick="toggleMessagePopup()"><i class="fa fa-times"></i></button>
            </div>
            <div class="message-details-section">
                <h4>Message Details</h4>
                <p><strong>Topic:</strong> <span id="message-topic"></span></p>
                <p><strong>Email:</strong> <span id="message-email"></span></p>
                <p><strong>Name:</strong> <span id="message-name"></span></p>
                <p><strong>Date:</strong> <span id="message-date"></span></p>
                <p><strong>Message:</strong></p>
                <p id="message-content"></p>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo URLROOT; ?>/public/js/admin/popups.js"></script>


