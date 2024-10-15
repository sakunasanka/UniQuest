<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/delete_account.css">

<!-- Sidebar and Content Layout -->
<div class="content-area">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->

    <div class="container">
        <!-- Sidebar within the body -->
        <div class="sidebr">
        <img src="<?php echo URLROOT; ?>/public/images/user.png" alt="Profile Picture" class="profile-pic">

            <ul>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="deactivate_account.php">Deactivate Account</a></li>
                <li><a href="signout.php">Sign out</a></li>
            </ul>
        </div>

        <!-- Main content area -->
        <div class="main-content">
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
                    <button type="submit" class="delete-btn">Deactivate Account</button>
                    <a href="#" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>



</div>