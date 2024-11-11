<?php require APPROOT . '/views/components/stu_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/make_complain.css">

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
    <div class="complaint-container">
        <!-- Complaint Form Section -->
            <div class="complaint-form-container">
                <h2>Report an Issue</h2>
                <p>Let us know about any problem with Providers</p>
        
                <!-- Form -->
                <form action="<?php echo URLROOT; ?>/submit_report" method="POST">
                    <label for="company">Company</label>
                    <input type="text" id="company" name="company" placeholder="Enter Company name" required>
            
                    <label for="job_posting">Job Posting</label>
                    <input type="text" id="job_posting" name="job_posting" placeholder="Enter job posting details" required>
            
                    <label for="issue">Issue</label>
                    <textarea id="issue" name="issue" rows="5" placeholder="Describe the issue" required></textarea>
            
                    <!-- Submit Button -->
                    <button type="submit" class="complaint-submit-btn">Submit Report</button>
                </form>
            </div>

        <!-- Image Section -->
        <div class="complaint-image-container">
            <img src="<?php echo URLROOT; ?>/public/images/complain.png" alt="Report Issue Image">
        </div>
    </main>
</div>


<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminBackButton.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>