<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/studentPopups.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/delete_account.css">
<div class="popup-container">
    <div class="popup" id="popup-deactivate">
        <div class="overlay"></div>
        <div class="content">
        <div class="close-btn-container"><button class="close-btn" onclick="closedeletereviewconfirm()"><i class="fa fa-times"></i></button></div>
            <h2>Deactivate post</h2>
            <input type="hidden" id="postID">
            <form action="<?php echo URLROOT; ?>/service_provider/deactivate" id="delete-post-form" method="POST">
                <input type="hidden" id="postID">
                <div class="warning">
                    <p>Are you sure you want to deactivate your post?<br>
                        Once you deactivate your post, you can still view it in Deactive Jobs.<br>
                        If you want to delete it forever, delete from Deactive jobs.</p>
                </div>
                <label>
                    <input type="checkbox" name="confirm" value="yes" required>
                    <div class="label-text">I confirm my post deactivation</div>
                </label>
                <div class="buttons">
                    <a onclick="canceldeletereviewconfirm()" href="#" class="cancel-btn">Cancel</a>
                  <button type="submit" class="delete-btn">Deactivate post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/public/js/student/deactivate_postjob.js"></script>