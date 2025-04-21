<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/admin/addReason.css">

<!-- Delete Confirmation Popup -->
<div class="popup-overlay" id="deleteIndustryPopup">
    <div class="popup-content">
        <button class="close-btn">&times;</button>
        <h3>Delete Industry</h3>
        <form class="deleteIndustryForm">
            <input type="hidden" class="industryID" name="industryID" value="">
            <div class="form-group">
                <p class="warning-text">Are you sure you want to delete this industry? This action cannot be undone.</p>
            </div>
            <div class="form-actions">
                <button type="button" class="cancel-btn">Cancel</button>
                <button type="submit" class="submit-btn delete-btn">Delete</button>
            </div>
        </form>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/public/js/components/deleteIndustry.js" type="module"></script>