<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/view_job.css">

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?> 

    <div class="job-container">
    <div class="job-header">
        <p>Job Post Date: <?php echo date('M-d-Y'); ?></p>
    </div>

    <div class="job-details">
        <div class="job-row">
            <span class="job-label">Referral ID</span>
            <span class="arrow">-></span>
            <span class="job-value">100</span>
        </div>

        <div class="job-row">
            <span class="job-label">Job Title</span>
            <span class="arrow">-></span>
            <span class="job-value">Delivery Rider</span>
        </div>

        <div class="job-row">
            <span class="job-label">Job Description</span>
            <span class="arrow">-></span>
            <span class="job-value">We are looking for a reliable and punctual Delivery Rider to join our team. As a Delivery Rider, you will play a crucial role in ensuring timely and accurate delivery of goods to our customers. Your primary responsibility will be to pick up orders from our warehouse or partner locations and deliver them to customers' specified addresses while providing excellent customer service.</span>
        </div>

        <div class="job-row">
            <span class="job-label">Job Location</span>
            <span class="arrow">-></span>
            <span class="job-value">Colombo, Sri Lanka</span>
        </div>

        <div class="job-row">
            <span class="job-label">Salary Range</span>
            <span class="arrow">-></span>
            <span class="job-value">LKR 2000 per day</span>
        </div>

        <div class="job-row">
            <span class="job-label">Job Qualifications</span>
            <span class="arrow">-></span>
            <span class="job-value">
                <ul>
                    <li>Age Between 18 - 40</li>
                    <li>With a valid driver's license</li>
                    <li>Should own a Motorbike</li>
                </ul>
            </span>
        </div>

        <div class="job-row">
            <span class="job-label">Job Benefits</span>
            <span class="arrow">-></span>
            <span class="job-value">
                <ul>
                    <li>Benefit 1</li>
                    <li>Benefit 2</li>
                    <li>Benefit 3</li>
                </ul>
            </span>
        </div>

        <div class="job-row">
            <span class="job-label">Job Icon</span>
            <span class="arrow">-></span>
            <span class="job-value">
                <div class="job-icon-placeholder"></div> <!-- Placeholder for icon -->
            </span>
        </div>
        <div class="job-footer">
            <button class="edit-btn">Edit Job</button>
        </div>
    </div>
    </div>

    
</div>
<footer class="footer">

</footer>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>

<?php require APPROOT . '/views/components/footer.php';