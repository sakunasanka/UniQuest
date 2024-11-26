<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/admin/job_detail.css">

<!-- Sidebar and Content Layout -->
<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="content-header">
            <button class="back-btn" onclick="window.location.href='<?php echo URLROOT; ?>/admin/ptjobs_mng'">
                <span class="material-symbols-outlined">arrow_back_ios</span>
                <h1>Jobs Management</h1>
            </button>
        </div>
        <div class="view-card">
            <div class="view-card-pic">
                <img src="<?php echo URLROOT; ?>/images/Burger-logo.png" alt="company logo" onclick="window.location.href='<?php echo URLROOT; ?>/admin/com_detail'">
            </div>

            <div class="view-card-content">
                <h1>Delivery Rider</h1>
                <p>Negombo / Ja Ela / Kiribathgoda</p>
                <div class="view-card-info">
                    <div>
                        <h3>Qualifications:</h3>
                        <ul>
                            <li>Age Between 18 - 40</li>
                            <li>With a valid driver's license</li>
                            <li>Should own a Motorbike</li>
                        </ul>
                    </div>
                    <div>
                        <h3>Benefits:</h3>
                        <ul>
                            <li>Highest salary in the industry</li>
                            <li>Special Extra Allowances</li>
                            <li>Meals during service hours</li>
                            <li>Accommodation is provided</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>