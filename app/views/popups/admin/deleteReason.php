<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/admin/addReason.css">

<div class="popup-overlay" id="deleteReasonPopup">
    <div class="popup-content">
        <button class="close-btn">&times;</button>
        <h3>Delete Reason</h3>
        <form class="deleteReasonForm">
            <input type="hidden" class="reasonID" name="reasonID" value="">
            <div class="form-group">
                <p class="warning-text">Are you sure you want to delete this reason? This action cannot be undone.</p>
            </div>
            <div class="form-actions">
                <button type="button" class="cancel-btn">Cancel</button>
                <button type="submit" class="submit-btn delete-btn">Delete</button>
            </div>
        </form>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/public/js/components/deleteReason.js" type="module"></script>