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
                <img src="<?php echo URLROOT; ?>/images/college students-amico.png" alt="student">
            </div>
            <div class="form-side">
                <form action="<?php echo URLROOT ?>/user/sendStuVeriEmail" method="POST">
                <div class="form-row">
                        <h1>Verify Your Email</h1>
                    </div>
                     <div class="form-row">
                        <div class="input-container">
                            <p>Enter your University email address below to receive the verification link.
                                It will redirect you to the login page after successful verification.</p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-container">
                            <input type="email" name="email" placeholder="Enter Your University Email" value="<?php echo $data['email']; ?>" required>
                            <span class="error-msg"><?php echo $data['email_err']; ?></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-center">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-center">
                            <button type="submit">Send</button>
                        </div>
                    </div>
                    <div class="form-row">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>