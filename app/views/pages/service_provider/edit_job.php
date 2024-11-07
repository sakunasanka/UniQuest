<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/edit_job.css">

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?> 


    <div class="content-area">

        <div class= date >
        <h2>Job Post Date: <?php echo date('M-d-Y'); ?></h2>
        </div>

        <div class="form-container">
            <form action="submit.php" method="post" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label for="referral_id">Referral ID</label>
                    <span class="arrow">-></span>
                    <input type="text" id="referral_id" name="referral_id" value="23477" readonly>
                </div>
        
                <div class="form-group">
                    <label for="job_title">Job Title</label>
                    <span class="arrow">-></span>
                    <input type="text" id="job_title" name="job_title" value="Delivery Rider">
                </div>
        
                <div class="form-group">
                    <label for="job_description">Job Description</label>
                    <span class="arrow">-></span>
                    <textarea id="job_description" name="job_description">
                        We are looking for a reliable and punctual Delivery Rider to join our team. As a Delivery Rider, you will play a crucial role in ensuring timely and accurate delivery of goods to our customers. Your primary responsibility will be to pick up orders from our warehouse or partner locations and deliver them to customers' specified addresses while providing excellent customer service.
                    </textarea>
                </div>
        
                <div class="form-group">
                    <label for="job_location">Job Location</label>
                    <span class="arrow">-></span>
                    <input type="text" id="job_location" name="job_location" value="Colombo, Sri Lanka">
                </div>
        
                <div class="form-group">
                    <label for="salary_range">Salary Range</label>
                    <span class="arrow">-></span>
                    <input type="text" id="salary_range" name="salary_range" value="LKR 20000 per day">
                </div>
        
                <div class="form-group">
                    <label for="job_qualifications">Job Qualifications</label>
                    <span class="arrow">-></span>
                    <textarea id="job_qualifications" name="job_qualifications">
                        • Age Between 18 - 40
                        • With a valid driver's license
                        • Should own a Motorbike
                    </textarea>
                </div>
        
                <div class="form-group">
                    <label for="job_benefits">Job Benefits</label>
                    <span class="arrow">-></span>
                    <textarea id="job_benefits" name="job_benefits">
                        • Benefit 1
                        • Benefit 2
                        • Benefit 3
                    </textarea>
                </div>
        
                <div class="form-group">
                    <label for="job_icon">Job Icon</label>
                    <span class="arrow">-></span>
                    <input type="file" id="job_icon" name="job_icon">
                </div>
        
                <button type="submit" class="submit-btn">Done</button>
            </form>
        </div>
    </div>
</div>
<footer class="footer">

</footer>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>

<?php require APPROOT . '/views/components/footer.php';