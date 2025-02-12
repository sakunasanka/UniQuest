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
                <form action="<?php echo URLROOT ?>/user/reset_password/?token=<?php echo $_GET['token'] ?? '' ; ?>" method="POST">
                    <div class="form-row">
                        <h1>Reset Password</h1>
                    </div>
                    <div class="form-row">
                        <div class="input-container">
                            <label for="password">Password</label>
                            <input type="password" name="password" placeholder="Enter Your Password" required>
                            <span class="error-msg"><?php echo $data['password_err']; ?></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-container">
                            <label for="password">Confirm Password</label>
                            <input type="password" name="confirm_password" placeholder="Enter Your Confirm Password" required>
                            <span class="error-msg"><?php echo $data['confirm_password_err']; ?></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-container">
                            <span class="error-msg"><?php echo $data['error']; ?></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-center">
                            <button type="submit">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>