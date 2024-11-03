<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/login.css">

<header class="header">

</header>

<body>
    <div class="main-container-without-side">
        <div class="container">
            <div class="left-side">
                <h2>Service Provider</h2>
                <h3>Login</h3>
                <form action="<?php echo URLROOT?>/service_provider/login" method="POST">
                    <input type="email" name="email" placeholder="Enter Your Email" value="<?php echo $data['email']; ?>" required>
                    <span class="error-msg"><?php echo $data['email_err']; ?></span>
                    <input type="password" name="password" placeholder="Enter Your Password" required>
                    <span class="error-msg"><?php echo $data['password_err']; ?></span>
                    <a href="#">Forgot password?</a>
                    <button type="submit">Log in</button>
                </form>
                <div class="register-link">
                    <span>Do not have an account?</span> <a href="/uniquest/service_provider/register">Register now</a>
                </div>
            </div>
            <div class="right-side">
                <h2>Student</h2>
                <a href="/uniquest/student/login">
                    <img src="<?php echo URLROOT; ?>/images/student.png" alt="student">
                </a>
            </div>
        </div>
    </div>

    <?php require APPROOT . '/views/components/footer.php'; ?>