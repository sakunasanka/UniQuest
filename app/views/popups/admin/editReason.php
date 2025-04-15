<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/admin/addReason.css">

<!-- Popup Overlay -->
<div class="popup-overlay" id="editReasonPopup">
    <div class="popup-content">
        <button class="close-btn">&times;</button>
        <h3>Edit Reason</h3>
        <form class="editReasonForm">
            <div class="form-group">
                <label for="reasonName">Reason Name*</label>
                <input type="text" class="reasonName" name="reasonName" placeholder="Enter reason name" required>
                <input type="hidden" class="reasonID" name="reasonID" value="">
            </div>
            <div class="form-group">
                <label for="reason">Reason*</label>
                <textarea class="reason" name="reason" rows="3" placeholder="Enter reason" required></textarea>
            </div>
            <div class="form-actions">
                <button type="button" class="cancel-btn">Cancel</button>
                <button type="submit" class="submit-btn">Update Reason</button>
            </div>
        </form>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/public/js/components/editReason.js" type="module"></script>