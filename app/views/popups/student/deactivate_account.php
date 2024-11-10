<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/delete_account.css">
<div class="l-container">
<div class="d-container"></div>
<div class="container">
        <h2>Delete Account</h2>
        <form action="delete_account.php" method="post">
            <div class="warning">
                <p>Are you sure you want to delete your account?<br>
                Once you delete your account, there is no going back. Please be certain.</p>
            </div>
            <label>
                <input type="checkbox" name="confirm" required>
                I confirm my account deactivation
            </label>
            <div class="buttons">
                <button type="button" class="delete-btn" onclick="closedeleteaccountconfirm()">Deactivate Account</button>
                <a  onclick="canceldeleteaccountconfirm()" href="#" class="cancel-btn">Cancel</a>
            </div>
        </form>
</div>
</div>
    <script type="text/javascript" src="<?php echo URLROOT; ?>/js/student/delete_account.js"></script>
