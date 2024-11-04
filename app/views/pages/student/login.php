<?php

$emailError = '';
$passwordError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $emailError = 'Please enter a valid email.';
    }
    if (empty($_POST['password']) || strlen($_POST['password']) < 6) {
        $passwordError = 'Password must be at least 6 characters.';
    }
}
?>

<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/login.css">

<header class="header">

</header>

<body>
    <div class="container">
        <div class="left-side">
            <h2>Service Provider</h2>
            <a href="/uniquest/service_provider/login">
                <img src="<?php echo URLROOT; ?>/images/service-provider.png" alt="service-provider">
            </a>
        </div>
        <div class="right-side">
            <h2>Student</h2>
            <h3>Login</h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <input type="email" name="email" placeholder="Enter Your Email" required>
                <?php if (!empty($emailError)) : ?>
                    <p class="error"><?php echo $emailError; ?></p>
                <?php endif; ?>
                
                <input type="password" name="password" placeholder="Enter Your Password" required>
                <?php if (!empty($passwordError)) : ?>
                    <p class="error"><?php echo $passwordError; ?></p>
                <?php endif; ?>
                
                <a href="#">Forgot password?</a>
                <button type="submit">Log in</button>
            </form>
            <div class="register-link">
                <span>Do not have an account?</span> <a href="#">Register now</a>
            </div>
        </div>
    </div>
</body>
</html>

<?php require APPROOT . '/views/components/footer.php'; ?>
  





