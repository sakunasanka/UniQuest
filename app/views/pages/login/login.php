<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/login.css">

<div class="main-container-without-side">
    <div class="container">
        <div class="left-side">
            <h2>Login</h2>
            <form action="<?php echo URLROOT ?>/login/login" method="POST">
                <input type="email" name="email" placeholder="Enter Your Email" value="<?php echo $data['email']; ?>" required>
                <span class="error-msg"><?php echo $data['email_err']; ?></span>
                <input type="password" name="password" placeholder="Enter Your Password" required>
                <span class="error-msg"><?php echo $data['password_err']; ?></span>
                <a href="#">Forgot password?</a>
                <button type="submit">Log in</button>
            </form>
            <div class="register-link">
                <span>Do not have an account?</span> <a href="/uniquest/student/register">Register now</a>
            </div>
        </div>
        <div class="right-side">
            <a href="/uniquest/student/login">
                <img src="<?php echo URLROOT; ?>/images/student.png" alt="student">
            </a>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>