<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/delete_account.css">
<div class="popup-container">
    <div class="popup" id="popup-stu">
        <div class="overlay"></div>
        <div class="content">
            <button class="close-btn" onclick="closedeleteaccountconfirm()"><i class="fa fa-times"></i></button>
            <h2>Delete Account</h2>
            <form action="<?php echo URLROOT ?>/user/deactivate" method="POST">
                <div class="warning">
                    <p>Are you sure you want to delete your account?<br>
                        Once you deactivate your account, you can log in within 30 days to reactivate it. After 30 days, your account will be permanently deleted</p>
                </div>
                <label>
                    <input type="checkbox" name="confirm" value="yes" required>
                    <div class="label-text">I confirm my account deactivation</div>
                </label>
                <div class="buttons">
                    <a onclick="canceldeleteaccountconfirm()" href="#" class="cancel-btn">Cancel</a>
                    <button type="submit" class="delete-btn">Deactivate Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/public/js/student/delete_account.js"></script>