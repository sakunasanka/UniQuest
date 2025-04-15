<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/admin/addIndustry.css">

<!-- Popup Overlay -->
<div class="popup-overlay" id="industryPopup">
    <div class="popup-content">
        <button class="close-btn">&times;</button>
        <h3>Add New Industry</h3>
        <form id="industryForm">
            <div class="form-group">
                <label for="industryName">Industry Name*</label>
                <input type="text" id="industryName" name="industryName" placeholder="Enter industry name" required>
                <div id="industryError" class="error-msg" style="color: red; margin-top: 5px;"></div>
            </div>
            <div class="form-actions">
                <button type="button" class="cancel-btn">Cancel</button>
                <button type="submit" class="submit-btn">Save Industry</button>
            </div>
        </form>
    </div>
</div>


<script src="<?php echo URLROOT; ?>/public/js/components/addIndustry.js" type="module"></script>