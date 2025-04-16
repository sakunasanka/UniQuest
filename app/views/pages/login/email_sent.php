<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/login.css">
    <script src="<?php echo URLROOT; ?>/js/components/flash.js"></script>
</head>

<body>
    <div class="reg-container">
        <button class="back" onclick="window.history.back()">
            <span class="material-symbols-outlined">arrow_back</span>
        </button>
        <div class="container">
            <div class="image-side">
                <img src="<?php echo URLROOT; ?>/images/Mail sent2.png" alt="student">
            </div>
            <div class="form-side">
                <div>
                    <div class="form-row">
                        <h1>Reset Password</h1>
                    </div>
                    <div class="form-row">
                        <div class="input-container">
                            <p>An email has been sent to your email address. 
                                Please check your email and follow the link to reset your password.</p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-center">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-center">
                            <div class="reg">
                                <span>Go back to</span> <a href="/UniQuest"> Home Page</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>