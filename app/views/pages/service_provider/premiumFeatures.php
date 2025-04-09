<?php require APPROOT . '/views/components/ser_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/premiumFeatures.css">

<div class="main-container">
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>
    <div class="content-area">
        <h1>Upgrade to a Premium Plan</h1>
        <p>Take your job posting experience to the next level with our premium plans.</p>
        
        <div class="plan-cards">
            <div class="plan-card">
                <h2>Starter</h2>
                <p class="plan-subtitle">Perfect for small businesses</p>
                <hr class="option-bar">
                <ul>
                    <li>✓ Post up to 2 job listings</li>
                    <li>✓ 20 candidate applications</li>
                    <li>✓ Generate Job Report</li>
                </ul>
                <hr class="option-bar">
                <div class="plan-price">Free</div>
                <button class="current-plan-btn">Current Plan</button>
            </div>
            
            <div class="plan-card">
                <h2>Professional</h2>
                <p class="plan-subtitle">For growing businesses</p>
                <hr class="option-bar">
                <ul>
                    <li>✓ Post up to 20 job listings</li>
                    <li>✓ 50 candidate applications</li>
                    <li>✓ Generate Job Report</li>
                </ul>
                <hr class="option-bar">
                <div class="plan-price">LKR 3000 <span>per month</span></div>
                <button class="upgrade-btn"  onclick="initiatePayment('professional', 3000);">Upgrade to Professional</button>
            </div>
            
            <div class="plan-card">
                <h2>Enterprise</h2>
                <p class="plan-subtitle">For large businesses</p>
                <hr class="option-bar">
                <ul>
                    <li>✓ Unlimited job listings</li>
                    <li>✓ Unlimited candidate applications</li>
                    <li>✓ Generate Job Report</li>
                </ul>
                <hr class="option-bar">
                <div class="plan-price">LKR 5000 <span> per month</span></div>
                <button class="upgrade-btn" onclick="initiatePayment('enterprise', 5000);">Upgrade to Enterprise</button>
            </div>
        </div>
    </div>
</div>

<script src="https://www.payhere.lk/lib/payhere.js"></script>
<script src="<?php echo URLROOT; ?>/js/service_provider/payhere.js"></script>
<?php require APPROOT . '/views/components/footer.php'; ?>