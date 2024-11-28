<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/studentPopups.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/delete_account.css">
<div class="popup-container">
    <div class="popup" id="popup-deactivate">
        <div class="overlay"></div>
        <div class="content">
        <div class="close-btn-container"><button class="close-btn" onclick="closedeletereviewconfirm()"><i class="fa fa-times"></i></button></div>
            <h2>Delete review</h2>
            <input type="hidden" id="postID">
            <form action="<?php echo URLROOT; ?>/service_provider/delete" id="delete-post-form" method="POST">
                <input type="hidden" id="postID">
                <div class="warning">
                    <p>Are you sure you want to delete your review?<br>
                        Once you delete your review, you can't recover it.</p>
                </div>
                <label>
                    <input type="checkbox" name="confirm" value="yes" required>
                    <div class="label-text">I confirm my review deletion</div>
                </label>
                <div class="buttons">
                    <a onclick="canceldeletereviewconfirm()" href="#" class="cancel-btn">Cancel</a>
                  <button type="submit" class="delete-btn">Delete review</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/public/js/student/delete_postjob.js"></script>