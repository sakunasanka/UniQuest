<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/admin/adminPopups.css">
<div class="popup-container">
    <div class="popup" id="popup-1">
        <div class="overlay"></div>
        <div class="content">
            <button class="close-btn" onclick="toggleMoreReviews()"><i class="fa fa-times"></i></button><button class="close-btn" onclick="toggleMoreReviews()"><i class="fa fa-times"></i></button>
            <p class="popup-text red-text">Are you sure you want to deactivate this job?</p>
            <div class="btn-container">
                <a href="#" class="no-btn" onclick="togglePopup()">No</a>
                <a href="#" class="yes-btn-red" >Yes</a>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/public/js/admin/popups.js"></script>

