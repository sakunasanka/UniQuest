<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/premiumFeatures.css">

<?php 
    if(($data['companyInfo']-> subscription_plan == 'professional' || $data['companyInfo']-> subscription_plan == 'enterprise')) {
        $currentDateTime = date('Y-m-d H:i:s');
        $remainingDays = converttimetodays(strtotime($data['companyInfo']->subscription_end_date) - strtotime($currentDateTime));
    }
    else {
        $remainingDays = 0;  
    }
?>

<div class="main-container">
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>
    <div class="content-area">
        <h1>Upgrade to a Premium Plan</h1>
        <p>Take your job posting experience to the next level with our premium plans.</p>
        

        <?php if(isset($_SESSION['payment_message'])): ?>
            <div class="alert <?php echo strpos($_SESSION['payment_message'], 'successful') !== false ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo $_SESSION['payment_message']; ?>
                <?php unset($_SESSION['payment_message']); ?>
            </div>
        <?php endif; ?>
        

        <div class="plan-cards">
            <div class="plan-card">
                <h2>Starter</h2>
                <p class="plan-subtitle">Perfect for small businesses</p>
                <hr class="option-bar">
                <ul>
                    <li>✓ Post up to 2 job listings</li>
                    <li>✓ 20 candidate applications</li>
                </ul>
                <hr class="option-bar">
                <div class="plan-price">Free</div>
                <?php if($data['companyInfo']->subscription_plan == 'free'):?>
                <button class="current-plan-btn">Current Plan</button>
                <?php else:?>
                <button class="upgrade-btn" onclick="RemainingDaysAlert('<?php echo $data['companyInfo']->subscription_plan?>')">Upgrade to Starter</button>
                <?php endif;?>
            </div>
            
            <div class="plan-card">
                <h2>Professional</h2>
                <p class="plan-subtitle">For growing businesses</p>
                <hr class="option-bar">
                <ul>
                    <li>✓ Post up to 20 job listings</li>
                    <li>✓ 50 candidate applications</li>
                    <li>✓ Generate Job Report</li>
                    <li>✓ Edit Active Jobs</li>
                </ul>
                <hr class="option-bar">
                <div class="plan-price">LKR 3000 <span>per month</span></div>
                <?php if($data['companyInfo']->subscription_plan == 'professional'):?>
                <button class="current-plan-btn">Current Plan</button>
                <?php else:?>
                <button class="upgrade-btn" onclick="RemainingDaysAlert('<?php echo $data['companyInfo']->subscription_plan?>', 'professional')", onclick="initiatePayment('professional', 3000, <?php echo $_SESSION['user_id']; ?>);">Upgrade to Professional</button>
                <?php endif;?>
            </div>
            
            <div class="plan-card">
                <h2>Enterprise</h2>
                <p class="plan-subtitle">For large businesses</p>
                <hr class="option-bar">
                <ul>
                    <li>✓ Unlimited job listings</li>
                    <li>✓ Unlimited candidate applications</li>
                    <li>✓ Generate Job Report</li>
                    <li>✓ Edit Active Jobs</li>
                    <li>✓ Prioritize Posts</li>
                </ul>
                <hr class="option-bar">
                <div class="plan-price">LKR 5000 <span> per month</span></div>
                <?php if($data['companyInfo']->subscription_plan == 'enterprise'):?>
                <button class="current-plan-btn">Current Plan</button>
                <?php else:?>
                <button class="upgrade-btn" onclick="RemainingDaysAlert('<?php echo $data['companyInfo']->subscription_plan?>', 'enterprise')">Upgrade to Enterprise</button>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>

<script>
    function RemainingDaysAlert(plan, req_plan) {

        const remainingDays = <?php echo json_encode($remainingDays); ?>;
        let planPrice;
        if (req_plan == 'professional') {
            planPrice = 3000;
        }
        else if (req_plan == 'enterprise') {
            planPrice = 5000;
        }

        if (plan == 'professional' && status == 'active') {
            Flash.show("You are currently on the Professional plan.<br>" + remainingDays +" until your plan expires.", "error");
        }
        else if (plan == 'enterprise' && status == 'active') {
            Flash.show("You are currently on the Enterprise plan.<br>" + remainingDays +" until your plan expires.", "error");
        }
        else {
            initiatePayment(req_plan, planPrice, <?php echo $_SESSION['user_id']; ?>);
        }
    }
</script>

<?php require APPROOT . '/views/components/footer.php'; ?>    

<script src="https://www.payhere.lk/lib/payhere.js"></script>
<script src="<?php echo URLROOT; ?>/js/service_provider/payhere.js"></script>