<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/delete_account.css">
<div class="popup-container">
    <div class="popup" id="popup-stu">
        <div class="overlay"></div>
        <div class="content">
            <button class="close-btn" onclick="closedeleteaccountconfirm()"><i class="fa fa-times"></i></button><button class="close-btn" onclick="toggleMoreReviews()"><i class="fa fa-times"></i></button>
            <h2>Delete Account</h2>
            <form action="delete_account.php" method="post">
                <div class="warning">
                    <p>Are you sure you want to delete your account?<br>
                    Once you delete your account, there is no going back. Please be certain.</p>
                </div>
                <label>
                    <input type="checkbox" name="confirm" required>
                    <div class="label-text">I confirm my account deactivation</div>
                </label>
                <div class="buttons">
                    <button type="button" class="delete-btn" onclick="closedeleteaccountconfirm()">Deactivate Account</button>
                    <a  onclick="canceldeleteaccountconfirm()" href="#" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/public/js/student/delete_account.js"></script>

