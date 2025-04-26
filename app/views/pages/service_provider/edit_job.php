<?php require APPROOT . '/views/components/header.php'; ?>

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
                        <input type="text" id="job_title" name="jobName" value="<?php echo $data['job_name']; ?>" readonly>
                    </div>
                    <span class="form-invalid"><?php echo $data['job_name_err']; ?></span>

                    <div class="form-group">
                        <label for="job_description">Job Description:</label>
                        <textarea id="job_description" name="job_description"><?php echo $data['job_description']; ?></textarea>
                    </div>
                    <span class="form-invalid"><?php echo $data['Description_err']; ?></span>

                    <div class="form-group">
                        <label for="jobLocation" class="required">Job Location:</label>
                        <input type="text" id="jobDistrict" name="job_district" value="<?php echo $data['job_district']; ?>" style="margin-right : 40px;" readonly>
                        <input type="text" id="jobCity" name="job_city" value="<?php echo $data['job_city']; ?>" readonly>
                    </div>
                    <span class="form-invalid"><?php echo $data['job_location_err']; ?></span>

                </div>

                <div class="form-column">
                    <div class="form-group">
                        <label for="salary_range">Salary Range:</label>
                        <input type="text" id="salary_range" name="salaryRange" value="<?php echo $data['salary_range']; ?>" style="margin-right : 40px;">
                        <select name="salaryType" id="salaryType" disabled>
                            <option value="Per Hour" <?php echo ($data['salary_type'] === 'Per Hour') ? 'selected' : ''; ?>>Per Hour</option>
                            <option value="Per Day" <?php echo ($data['salary_type'] === 'Per Day') ? 'selected' : ''; ?>>Per Day</option>
                            <option value="Per Week" <?php echo ($data['salary_type'] === 'Per Week') ? 'selected' : ''; ?>>Per Week</option>
                            <option value="Per Month" <?php echo ($data['salary_type'] === 'Per Month' || empty($data['salary_type'])) ? 'selected' : ''; ?>>Per Month</option>
                        </select>
                    </div>
                    <span class="form-invalid"><?php echo $data['salary_range_err']; ?></span>

                    <div class="form-group">
                        <label for="job_qualifications">Job Qualifications:</label>
                        <textarea id="job_qualifications" name="qualifications"><?php echo $data['required_skills']; ?></textarea>
                    </div>
                    <span class="form-invalid"><?php echo $data['required_skills_err']; ?></span>

                    <div class="form-group">
                        <label for="job_benefits">Job Benefits:</label>
                        <textarea id="job_benefits" name="jobBenefits"><?php echo $data['job_benifits']; ?></textarea>
                    </div>
                    <span class="form-invalid"><?php echo $data['job_benifits_err']; ?></span>

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
<script type="module" src="<?php echo URLROOT; ?>/public/js/register/citiesForDistrict.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>