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
                <img src="<?php echo URLROOT; ?>/images/service-provider.png" alt="student">
            </div>
            <div class="form-side">
                <form action="<?php echo URLROOT ?>/user/reactivate_acc" method="POST">
                    <div class="form-row">
                        <h1>Reactivate Account</h1>
                    </div>
                    <div class="form-row">
                        <div class="input-container">
                            <p>Your account is deactivated and scheduled for deletion. Do you want to reactivate it?</p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-center">
                            <button class="yes" type="submit" name="yes" value="1">Yes</button>
                        </div>
                        <div class="input-center">
                            <button class="no" type="submit" name="no" value="1">No</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>