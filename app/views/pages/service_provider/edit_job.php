<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/edit_job.css">

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?> 

    <div class="content-area">
        <div class="date">
            <h2>Job Post Date: <?php echo date('M-d-Y'); ?></h2>
        </div>

        <div class="form-container">
            <form action="<?php echo URLROOT; ?>/service_provider/edit_job/<?php echo $data['job_id']; ?>" method="POST" enctype="multipart/form-data">
                <div class="form-column">

                    <div class="form-group">
                        <label for="job_title">Job Title:</label>
                        <input type="text" id="job_title" name="jobName" value="<?php echo $data['job_name']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="job_description">Job Description:</label>
                        <textarea id="job_description" name="jobDescription"><?php echo $data['Description']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="job_location">Job Location:</label>
                        <input type="text" id="jobLocation" name="jobLocation" value="<?php echo $data['job_location']; ?>">
                    </div>
                </div>

                <div class="form-column">
                    <div class="form-group">
                        <label for="salary_range">Salary Range:</label>
                        <input type="text" id="salary_range" name="salaryRange" value="<?php echo $data['salary_range']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="job_qualifications">Job Qualifications:</label>
                        <textarea id="job_qualifications" name="qualifications"><?php echo $data['required_skills']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="job_benefits">Job Benefits:</label>
                        <textarea id="job_benefits" name="jobBenefits"><?php echo $data['job_benifits']; ?></textarea>
                    </div>

                    <!-- <div class="form-group">
                        <label for="job_icon">Job Icon</label>
                        <input type="file" id="job_icon" name="job_icon">
                    </div> -->
                </div>

                <button type="submit" class="submit-btn">Done</button>
            </form>
        </div>
    </div>
</div>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>