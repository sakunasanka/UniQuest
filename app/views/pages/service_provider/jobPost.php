<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/jobPost.css">
<?php require APPROOT . '/views/components/ser_header.php'; ?>

<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <h1>Add New Job Post</h1>
        <div class="job-post-form-container">
            <form action="<?php echo URLROOT; ?>/service_provider/jobpost" method="post">
                <div class="form-step" id="step-1">
                    <div class="form-bottom">
                        <div class="form-head">
                            <h3>Job Details</h3>
                            <p>Fill in the details of the job you want to post</p>
                        </div>
                        <div class="form-left">
                            <label for="jobName">Job Name:</label>
                            <input type="text" id="jobName" name="jobName" placeholder="Job Name" value="<?php $data['job_name']; ?>">

                            <span class="form-invalid"><?php echo $data['job_name_err']; ?></span>

                            <label for="jobDescription">Job Description:</label>
                            <textarea id="jobDescription" name="jobDescription" placeholder="Job Description" value="<?php echo $data['Description']; ?>"></textarea>
                            <span class="form-invalid"><?php echo $data['Description_err']; ?></span>

                            <label for="jobBenefits">Job Benefits:</label>
                            <textarea id="jobBenefits" name="jobBenefits" placeholder="Job Benefits" value="<?php $data['job_benifits']; ?>"></textarea>
                            <span class="form-invalid"><?php echo $data['job_benifits_err']; ?></span>

                            <label for="jobType">Job Type:</label>
                            <div class="employment-types">
                                <label><input type="radio" name="jobType" value="Part-time" required> Part-time</label>
                                <label><input type="radio" name="jobType" value="Internship" required> Internship</label>
                            </div>
                        </div>

                        <div class="form-right">
                            <label for="salaryRange">Salary Range:</label>
                            <input type="text" id="salaryRange" name="salaryRange" placeholder="Salary Range" value="<?php $data['salary_range']; ?>">
                            <span class="form-invalid"><?php echo $data['salary_range_err']; ?></span>

                            <label for="qualifications">Required Qualifications:</label>
                            <textarea id="qualifications" name="qualifications" placeholder="Required Qualifications" value="<?php $data['required_skills']; ?>"></textarea>
                            <span class="form-invalid"><?php echo $data['required_skills_err']; ?></span>


                            <label for="jobLocation">Job Location:</label>
                            <input type="text" id="jobLocation" name="jobLocation" placeholder="Job Location" value="<?php $data['job_location']; ?>">
                            <span class="form-invalid"><?php echo $data['job_location_err']; ?></span>

                        </div>
                    </div>
                    <div class="form-actions">
                        <div></div>
                        <button type="button" class="next-btn" data-step="1">Next</button>
                    </div>
                </div>
                <div class="form-step" id="step-2">
                    <div class="form-bottom">
                        <div class="form-head">
                            <h3>Application Form Structure</h3>
                            <p>Select the fields you want to include in the application form</p>
                        </div>
                        <div class="checkbox-row">
                            <input type="checkbox" id="name" name="app_fullname" value="yes">
                            <label for="name">Full Name</label>
                        </div>
                        <div class="checkbox-row">
                            <input type="checkbox" id="photo" name="app_photo" value="yes">
                            <label for="photo">Photo</label>
                        </div>
                        <div class="checkbox-row">
                            <input type="checkbox" id="email" name="app_email" value="yes">
                            <label for="email">Email</label>
                        </div>
                        <div class="checkbox-row">
                            <input type="checkbox" id="contactNo" name="app_contact" value="yes">
                            <label for="contactNo">Contact Number</label>
                        </div>
                        <div class="checkbox-row">
                            <input type="checkbox" id="address" name="app_address" value="yes">
                            <label for="address">Address</label>
                        </div>
                        <div class="checkbox-row">
                            <input type="checkbox" id="nic-no" name="app_nic" value="yes">
                            <label for="nic-no">NIC Number</label>
                        </div>
                        <div class="checkbox-row">
                            <input type="checkbox" id="nic-copy" name="app_nic_copy" value="yes">
                            <label for="nic-copy">NIC Copy</label>
                        </div>
                        <div class="checkbox-row">
                            <input type="checkbox" id="gender" name="app_gender" value="yes">
                            <label for="gender">Gender</label>
                        </div>
                        <div class="checkbox-row">
                            <input type="checkbox" id="dob" name="app_dob" value="yes">
                            <label for="dob">Date of Birth</label>
                        </div>
                        <div class="checkbox-row">
                            <input type="checkbox" id="qualification" name="app_qualifications" value="yes">
                            <label for="qualification">Qualifications</label>
                        </div>
                        <div class="checkbox-row">
                            <input type="checkbox" id="experience" name="app_experience" value="yes">
                            <label for="experience">Experience</label>
                        </div>
                        <div class="checkbox-row">
                            <input type="checkbox" id="skills" name="app_skills" value="yes">
                            <label for="skills">Skills</label>
                        </div>
                        <div class="checkbox-row">
                            <input type="checkbox" id="cv" name="app_cv" value="yes">
                            <label for="cv">CV</label>
                        </div>
                        <div class="checkbox-row">
                            <input type="checkbox" id="linkedin" name="app_linkedin" value="yes">
                            <label for="linkedin">LinkedIn</label>
                        </div>
                        <div class="checkbox-row">
                            <input type="checkbox" id="other4" name="app_other" value="yes">
                            <label for="other4">Other</label>
                        </div>
                        <div class="checkbox-row">
                            <input type="checkbox" id="other1" name="app_other1" value="yes">
                            <label for="other1">Other</label>
                            <input type="text" id="other1" name="app_other1_name" placeholder="Field Name *">
                        </div>
                        <div class="checkbox-row">
                            <input type="checkbox" id="other2" name="app_other" value="yes">
                            <label for="other2">Other</label>
                            <input type="text" id="other2" name="app_other2_name" placeholder="Field Name *">
                        </div>
                        <div class="checkbox-row">
                            <input type="checkbox" id="other3" name="app_other3" value="yes">
                            <label for="other3">Other</label>
                            <input type="text" id="other3" name="app_other3_name" placeholder="Field Name *">
                        </div>

                    </div>
                    <div class="form-actions">
                        <button type="button" class="prev-btn" data-step="2">Previous</button>
                        <button type="submit" class="submit-btn" value="post">Post Job</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

<script src="<?php echo URLROOT; ?>/js/components/formPagination.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>