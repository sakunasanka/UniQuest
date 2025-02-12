<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/login.css">
</head>

<body>
    <div class="reg-container">
        <button class="back" onclick="window.history.back()">
            <span class="material-symbols-outlined">arrow_back</span>
        </button>
        <div class="container">
            <div class="image-side">
                <img src="<?php echo URLROOT; ?>/images/service-provider.png" alt="student">
            </div>
            <div class="form-side">
                <div>
                    <div class="form-row">
                        <h1>Reset Password</h1>
                    </div>
                    <div class="form-row">
                        <div class="input-container">
                            <span class="success-msg">Email sent successfully</span>
                            <span class="success-msg">Please check your email for the reset link</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-center">
                            <div class="reg">
                                <span>Do not have an account?</span> <a href="/uniquest/register"> Register now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>