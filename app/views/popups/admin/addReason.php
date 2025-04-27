<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/admin/addReason.css">

<div class="popup-overlay" id="reasonPopup">
    <div class="popup-content">
        <button class="close-btn">&times;</button>
        <h3>Add New Reason</h3>
        <form id="reasonForm">
            <div class="form-group">
                <label for="reasonName">Reason Name*</label>
                <input type="text" id="reasonName" name="reasonName" placeholder="Enter reason name" required>
            </div>
            <div class="form-group">
                <label for="reason">Reason*</label>
                <textarea id="reason" name="reason" rows="3" placeholder="Enter reason" required></textarea>
            </div>
            <div class="form-actions">
                <button type="button" class="cancel-btn">Cancel</button>
                <button type="submit" class="submit-btn">Save Reason</button>
            </div>
        </form>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/public/js/components/addReason.js" type="module"></script>