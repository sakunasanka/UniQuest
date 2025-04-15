<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/admin/addIndustry.css">

<!-- Popup Overlay -->
<div class="popup-overlay" id="editIndustryPopup">
    <div class="popup-content">
        <button class="close-btn">&times;</button>
        <h3>Edit Industry</h3>
        <form class="editIndustryForm">
            <div class="form-group">
                <label for="industryName">Industry Name*</label>
                <input type="text" class="industryName" name="industryName" placeholder="Enter industry name" required>
                <input type="hidden" class="industryID" name="industryID" value="">
            </div>
            <div class="form-actions">
                <button type="button" class="cancel-btn">Cancel</button>
                <button type="submit" class="submit-btn">Update</button>
            </div>
        </form>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/public/js/components/editIndustry.js" type="module"></script>