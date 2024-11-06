<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/styles.css">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/register/register.css">

<div class="reg-background">
    <button class="back" onclick="window.history.back()">
        <span class="material-symbols-outlined">arrow_back</span>
    </button>
    <button class="reg-btn" onclick="window.location.href='<?php echo URLROOT; ?>/register/student';">
        <div class="image-section">
            <img src="<?php echo URLROOT; ?>/images/college students-amico.png" alt="Student Registration">
            <h1>Student</h1>
        </div>
    </button>
    <button class="reg-btn" onclick="window.location.href='<?php echo URLROOT; ?>/register/company';">
        <div class="image-section">
            <img src="<?php echo URLROOT; ?>/images/service.png" alt="Student Registration">
            <h1>Company</h1>
        </div>
    </button>
</div>