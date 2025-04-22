<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/admin/addReason.css">

<!-- Unified Edit Popup -->
<div class="popup-overlay" id="editItemPopup">
    <div class="popup-content">
        <button class="close-btn">&times;</button>
        <h3 class="popup-title">Edit Item</h3>
        <form class="editItemForm">
            <input type="hidden" class="itemID" name="itemID" value="">
            <input type="hidden" class="itemType" name="itemType" value="">

            <div class="form-group name-field">
                <label for="itemName">Name*</label>
                <input type="text" class="itemName" name="itemName" placeholder="Enter name">
            </div>

            <div class="form-group reason-field">
                <label for="itemReason">Reason*</label>
                <textarea class="itemReason" name="itemReason" placeholder="Enter reason"></textarea>
            </div>

            <div class="form-actions">
                <button type="button" class="cancel-btn">Cancel</button>
                <button type="submit" class="submit-btn">Update</button>
            </div>
        </form>
    </div>
</div>


<script type="module" src="<?php echo URLROOT; ?>/public/js/components/editItem.js"></script>