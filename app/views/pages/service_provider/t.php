<div class="card-stats">
    <span><?php echo $data['companyInfo']->TotalJobViewCount; ?></span>
    
    <?php 
        $change = $data['percentageIncreaseViews'] - $data['percentageDecreaseViews']; 
        $isIncrease = $change > 0;
        $icon = $isIncrease ? "▲" : ($change < 0 ? "▼" : "—");
        $class = $isIncrease ? "up" : ($change < 0 ? "down" : "neutral");
    ?>

    <span class="<?php echo $class; ?>">
        <?php echo $icon . " " . round(abs($change), 1); ?>%
    </span>
</div>