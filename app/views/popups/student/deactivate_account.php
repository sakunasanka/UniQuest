<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/studentPopups.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/delete_account.css">
<div class="popup-container">
    <div class="popup" id="popup-deactivate">
        <div class="overlay"></div>
        <div class="content">
        <div class="close-btn-container"><button class="close-btn" onclick="closedeleteaccountconfirm()"><i class="fa fa-times"></i></button></div>
            <h2>Delete Account</h2>
            <form action="<?php echo URLROOT ?>/user/deactivate" method="POST">
                <div class="warning">
                    <p>Are you sure you want to delete your account?<br>
                    Once you delete your account, there is no going back. Please be certain.</p>
                </div>
                <label>
                    <input type="checkbox" name="confirm" required>
                    <div class="label-text">I confirm my account deactivation</div>
                </label>
                <div class="buttons">
                    <button type="submit" class="delete-btn">Deactivate Account</button>
                    <a  onclick="canceldeleteaccountconfirm()" href="#" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/public/js/student/delete_account.js"></script>

