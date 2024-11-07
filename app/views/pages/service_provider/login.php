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
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/login.css">

    <div class="main-container-without-side">
        <div class="container">
        <div class="left-side">
            <h2>Service Provider</h2>
            <h3>Login</h3>
            <form action="login.php" method="POST">
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
            </div>
        </div>
        <div class="right-side">
            <h2>Student</h2>
            <a  href ="/uniquest/student/login" >
                <img src="<?php echo URLROOT; ?>/images/student.png" alt="student">
            </a>
        </div>
    </div>

    <?php require APPROOT . '/views/components/footer.php'; ?>