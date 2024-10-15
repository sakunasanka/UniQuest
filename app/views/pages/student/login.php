<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/login.css">

<header class="header">

</header>

<body>
    <div class="main-container-without-side">
        <div class="container">
            <div class="left-side">
                <h2>Service Provider</h2>
                <a href  ="/uniquest/service_provider/login" >
                    <img src="<?php echo URLROOT; ?>/images/service-provider.png" alt="service-provider">
                </a>
            </div>
            <div class="right-side">
                <h2>Student</h2>
                <h3>Login</h3>
                <form action="login.php" method="POST">
                    <input type="email" name="email" placeholder="Enter Your Email" required>
                    <input type="password" name="password" placeholder="Enter Your Password" required>
                    <a href="#">Forgot password?</a>
                    <button type="submit">Log in</button>
                </form>
                <div class="register-link">
                    <span>Do not have an account?</span> <a href="/uniquest/student/register">Register now</a>
                </div>
            </div>
        </div>
    </div>

<?php require APPROOT . '/views/components/footer.php'; ?>


  





