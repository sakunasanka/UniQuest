<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/styles.css">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/login.css">

<div class="reg-container">
    <button class="back" onclick="window.history.back()">
        <span class="material-symbols-outlined">arrow_back</span>
    </button>
    <div class="container">
        <div class="image-side">
            <img src="<?php echo URLROOT; ?>/images/service-provider.png" alt="student">
        </div>
        <div class="form-side">
            <form action="<?php echo URLROOT ?>/user/login" method="POST">
                <div class="form-row">
                    <h1>Login</h1>
                </div>
                <div class="form-row">
                    <div class="input-container">
                        <label for="email">Email</label>
                        <input type="email" name="email" placeholder="Enter Your Email" value="<?php echo $data['email']; ?>" required>
                        <span class="error-msg"><?php echo $data['email_err']; ?></span>
                    </div>
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
                        <a class="forget-password" href="#">Forgot password?</a>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-center">
                        <button type="submit">Log in</button>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-center">
                        <div class="reg">
                            <span>Do not have an account?</span> <a href="/uniquest/register"> Register now</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>