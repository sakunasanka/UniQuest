<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/make_complain.css">

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>

    <!-- Content Area -->
     <div class="content-area">
    <div class="complaint-form-container">
            <h2>Report an Issue</h2>
            <p>Let us know about any problem with Providers</p>

            <form action="submit_complaint.php" method="post">
                <label for="company-name">Company</label>
                <input type="text" id="company-name" name="company" placeholder="Enter Company name" required>

                <label for="job-posting">Job Posting</label>
                <input type="text" id="job-posting" name="job_posting" placeholder="Enter job posting details" required>

                <label for="issue-description">Issue</label>
                <textarea id="issue-description" name="issue" rows="4" placeholder="Describe the issue" required></textarea>

                <button type="submit" class="complaint-submit-btn">Submit Report</button>
            </form>
        </div>

        <div class="complaint-image-container">
            <img src="report_icon.png" alt="Report Icon">
        </div>
    </div>
</div>
</div>



<footer class="footer">

</footer>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>    <main class="content-area">