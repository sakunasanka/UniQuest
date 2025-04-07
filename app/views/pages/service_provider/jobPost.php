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
                            <label for="jobName" class="required">Job Name:</label>
                            <input type="text" id="jobName" name="jobName" placeholder="Job Name" value="<?php echo isset($data['job_name']) ? $data['job_name'] : ''; ?>">

                            <span class="form-invalid"><?php echo $data['job_name_err']; ?></span>

                            <label for="jobDescription">Job Description:</label>
                            <textarea id="jobDescription" name="jobDescription" placeholder="Job Description"><?php echo isset($data['Description']) ? $data['Description'] : ''; ?></textarea>
                            <span class="form-invalid"><?php echo $data['Description_err']; ?></span>

                            <label for="jobBenefits">Job Benefits:</label>
                            <textarea id="jobBenefits" name="jobBenefits" placeholder="Job Benefits"><?php echo isset($data['job_benifits']) ? $data['job_benifits'] : ''; ?></textarea>
                            <span class="form-invalid"><?php echo $data['job_benifits_err']; ?></span>

                            <label for="jobPostDate" class="required">Job Post Date:</label>
                            <input type="date" id="jobPostDate" name="publishDate" 
                                value="<?php echo $data['publish_date']; ?>">
                            <span class="form-invalid"><?php echo $data['publish_date_err']; ?></span>

                        </div>

                        <div class="form-right">
                            <label for="salaryRange" class="required">Salary (Rs.):</label>
                            <div class="salary-container">
                                <input type="text" id="salaryRange" name="salaryRange" placeholder="Salary in Rs." value="<?php echo isset($data['salary_range']) ? $data['salary_range'] : ''; ?>">
                                <select name="salaryType" id="salaryType">
                                    <option value="Per Hour" <?php echo ($data['salary_type'] === 'Per Hour') ? 'selected' : ''; ?>>Per Hour</option>
                                    <option value="Per Day" <?php echo ($data['salary_type'] === 'Per Day') ? 'selected' : ''; ?>>Per Day</option>
                                    <option value="Per Week" <?php echo ($data['salary_type'] === 'Per Week') ? 'selected' : ''; ?>>Per Week</option>
                                    <option value="Per Month" <?php echo ($data['salary_type'] === 'Per Month' || empty($data['salary_type'])) ? 'selected' : ''; ?>>Per Month</option>
                                </select>
                            </div>
                            <span class="form-invalid"><?php echo $data['salary_range_err']; ?></span>

                            <label for="qualifications">Required Qualifications:</label>
                            <textarea id="qualifications" name="qualifications" placeholder="Required Qualifications"><?php echo isset($data['required_skills']) ? $data['required_skills'] : ''; ?></textarea>
                            <span class="form-invalid"><?php echo $data['required_skills_err']; ?></span>

                            <label for="jobLocation" class="required">Job Location:</label>
                            <input type="text" id="jobLocation" name="jobLocation" placeholder="Job Location" value="<?php echo isset($data['job_location']) ? $data['job_location'] : ''; ?>">
                            <span class="form-invalid"><?php echo $data['job_location_err']; ?></span>

                            <label for="jobType" class="required">Job Type:</label>
                            <div class="employment-types">
                                <label><input type="radio" name="jobType" value="Part-time" required> Part-time</label>
                                <label><input type="radio" name="jobType" value="Internship" required> Internship</label>
                            </div>

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
                        
                        <div class="field-table">
                            <div class="field-header">
                                <div class="field-col field-col-include">Include</div>
                                <div class="field-col field-col-name">Field Name</div>
                                <div class="field-col field-col-required">Required Field</div>
                            </div>
                            
                            <!-- Full Name -->
                            <div class="field-row">
                                <div class="field-col field-col-include">
                                    <input type="checkbox" id="name" name="app_fullname" value="yes" class="field-checkbox">
                                </div>
                                <div class="field-col field-col-name">
                                    <label for="name">Full Name</label>
                                </div>
                                <div class="field-col field-col-required">
                                    <input type="checkbox" id="name_req" name="app_fullname_req" value="yes" class="required-checkbox" disabled>
                                    <label for="name_req">Required</label>
                                </div>
                            </div>
                            
                            <!-- Photo -->
                            <div class="field-row">
                                <div class="field-col field-col-include">
                                    <input type="checkbox" id="photo" name="app_photo" value="yes" class="field-checkbox">
                                </div>
                                <div class="field-col field-col-name">
                                    <label for="photo">Photo</label>
                                </div>
                                <div class="field-col field-col-required">
                                    <input type="checkbox" id="photo_req" name="app_photo_req" value="yes" class="required-checkbox" disabled>
                                    <label for="photo_req">Required</label>
                                </div>
                            </div>
                            
                            <!-- Email -->
                            <div class="field-row">
                                <div class="field-col field-col-include">
                                    <input type="checkbox" id="email" name="app_email" value="yes" class="field-checkbox">
                                </div>
                                <div class="field-col field-col-name">
                                    <label for="email">Email</label>
                                </div>
                                <div class="field-col field-col-required">
                                    <input type="checkbox" id="email_req" name="app_email_req" value="yes" class="required-checkbox" disabled>
                                    <label for="email_req">Required</label>
                                </div>
                            </div>
                            
                            <!-- Contact Number -->
                            <div class="field-row">
                                <div class="field-col field-col-include">
                                    <input type="checkbox" id="contactNo" name="app_contact" value="yes" class="field-checkbox">
                                </div>
                                <div class="field-col field-col-name">
                                    <label for="contactNo">Contact Number</label>
                                </div>
                                <div class="field-col field-col-required">
                                    <input type="checkbox" id="contactNo_req" name="app_contact_req" value="yes" class="required-checkbox" disabled>
                                    <label for="contactNo_req">Required</label>
                                </div>
                            </div>
                            
                            <!-- Address -->
                            <div class="field-row">
                                <div class="field-col field-col-include">
                                    <input type="checkbox" id="address" name="app_address" value="yes" class="field-checkbox">
                                </div>
                                <div class="field-col field-col-name">
                                    <label for="address">Address</label>
                                </div>
                                <div class="field-col field-col-required">
                                    <input type="checkbox" id="address_req" name="app_address_req" value="yes" class="required-checkbox" disabled>
                                    <label for="address_req">Required</label>
                                </div>
                            </div>
                            
                            <!-- NIC Number -->
                            <div class="field-row">
                                <div class="field-col field-col-include">
                                    <input type="checkbox" id="nic-no" name="app_nic" value="yes" class="field-checkbox">
                                </div>
                                <div class="field-col field-col-name">
                                    <label for="nic-no">NIC Number</label>
                                </div>
                                <div class="field-col field-col-required">
                                    <input type="checkbox" id="nic-no_req" name="app_nic_req" value="yes" class="required-checkbox" disabled>
                                    <label for="nic-no_req">Required</label>
                                </div>
                            </div>
                            
                            <!-- NIC Copy -->
                            <div class="field-row">
                                <div class="field-col field-col-include">
                                    <input type="checkbox" id="nic-copy" name="app_nic_copy" value="yes" class="field-checkbox">
                                </div>
                                <div class="field-col field-col-name">
                                    <label for="nic-copy">NIC Copy</label>
                                </div>
                                <div class="field-col field-col-required">
                                    <input type="checkbox" id="nic-copy_req" name="app_nic_copy_req" value="yes" class="required-checkbox" disabled>
                                    <label for="nic-copy_req">Required</label>
                                </div>
                            </div>
                            
                            <!-- Gender -->
                            <div class="field-row">
                                <div class="field-col field-col-include">
                                    <input type="checkbox" id="gender" name="app_gender" value="yes" class="field-checkbox">
                                </div>
                                <div class="field-col field-col-name">
                                    <label for="gender">Gender</label>
                                </div>
                                <div class="field-col field-col-required">
                                    <input type="checkbox" id="gender_req" name="app_gender_req" value="yes" class="required-checkbox" disabled>
                                    <label for="gender_req">Required</label>
                                </div>
                            </div>
                            
                            <!-- Date of Birth -->
                            <div class="field-row">
                                <div class="field-col field-col-include">
                                    <input type="checkbox" id="dob" name="app_dob" value="yes" class="field-checkbox">
                                </div>
                                <div class="field-col field-col-name">
                                    <label for="dob">Date of Birth</label>
                                </div>
                                <div class="field-col field-col-required">
                                    <input type="checkbox" id="dob_req" name="app_dob_req" value="yes" class="required-checkbox" disabled>
                                    <label for="dob_req">Required</label>
                                </div>
                            </div>
                            
                            <!-- Qualifications -->
                            <div class="field-row">
                                <div class="field-col field-col-include">
                                    <input type="checkbox" id="qualification" name="app_qualifications" value="yes" class="field-checkbox">
                                </div>
                                <div class="field-col field-col-name">
                                    <label for="qualification">Qualifications</label>
                                </div>
                                <div class="field-col field-col-required">
                                    <input type="checkbox" id="qualification_req" name="app_qualifications_req" value="yes" class="required-checkbox" disabled>
                                    <label for="qualification_req">Required</label>
                                </div>
                            </div>
                            
                            <!-- Experience -->
                            <div class="field-row">
                                <div class="field-col field-col-include">
                                    <input type="checkbox" id="experience" name="app_experience" value="yes" class="field-checkbox">
                                </div>
                                <div class="field-col field-col-name">
                                    <label for="experience">Experience</label>
                                </div>
                                <div class="field-col field-col-required">
                                    <input type="checkbox" id="experience_req" name="app_experience_req" value="yes" class="required-checkbox" disabled>
                                    <label for="experience_req">Required</label>
                                </div>
                            </div>
                            
                            <!-- Skills -->
                            <div class="field-row">
                                <div class="field-col field-col-include">
                                    <input type="checkbox" id="skills" name="app_skills" value="yes" class="field-checkbox">
                                </div>
                                <div class="field-col field-col-name">
                                    <label for="skills">Skills</label>
                                </div>
                                <div class="field-col field-col-required">
                                    <input type="checkbox" id="skills_req" name="app_skills_req" value="yes" class="required-checkbox" disabled>
                                    <label for="skills_req">Required</label>
                                </div>
                            </div>
                            
                            <!-- CV -->
                            <div class="field-row">
                                <div class="field-col field-col-include">
                                    <input type="checkbox" id="cv" name="app_cv" value="yes" class="field-checkbox">
                                </div>
                                <div class="field-col field-col-name">
                                    <label for="cv">CV</label>
                                </div>
                                <div class="field-col field-col-required">
                                    <input type="checkbox" id="cv_req" name="app_cv_req" value="yes" class="required-checkbox" disabled>
                                    <label for="cv_req">Required</label>
                                </div>
                            </div>
                            
                            <!-- LinkedIn -->
                            <div class="field-row">
                                <div class="field-col field-col-include">
                                    <input type="checkbox" id="linkedin" name="app_linkedin" value="yes" class="field-checkbox">
                                </div>
                                <div class="field-col field-col-name">
                                    <label for="linkedin">LinkedIn</label>
                                </div>
                                <div class="field-col field-col-required">
                                    <input type="checkbox" id="linkedin_req" name="app_linkedin_req" value="yes" class="required-checkbox" disabled>
                                    <label for="linkedin_req">Required</label>
                                </div>
                            </div>
                            
                            <!-- Custom Field 1 -->
                            <div class="field-row custom-field">
                                <div class="field-col field-col-include">
                                    <input type="checkbox" id="other1" name="app_other1" value="yes" class="field-checkbox">
                                </div>
                                <div class="field-col field-col-name field-col-custom">
                                    <label for="other1">Custom Field 1</label>
                                    <input type="text" id="other1_name" name="app_other1_name" placeholder="Field Name *">
                                    <select name="app_other1_type" id="other1_type" class="field-type-select">
                                        <option value="Text">Text</option>
                                        <option value="File Upload">File Upload</option>
                                        <option value="Date">Date</option>
                                    </select>
                                </div>
                                <div class="field-col field-col-required">
                                    <input type="checkbox" id="other1_req" name="app_other1_req" value="yes" class="required-checkbox" disabled>
                                    <label for="other1_req">Required</label>
                                </div>
                            </div>
                            
                            <!-- Custom Field 2 -->
                            <div class="field-row custom-field">
                                <div class="field-col field-col-include">
                                    <input type="checkbox" id="other2" name="app_other2" value="yes" class="field-checkbox">
                                </div>
                                <div class="field-col field-col-name field-col-custom">
                                    <label for="other2">Custom Field 2</label>
                                    <input type="text" id="other2_name" name="app_other2_name" placeholder="Field Name *">
                                    <select name="app_other2_type" id="other2_type" class="field-type-select">
                                        <option value="text">Text</option>
                                        <option value="file">File Upload</option>
                                        <option value="date">Date</option>
                                    </select>
                                </div>
                                <div class="field-col field-col-required">
                                    <input type="checkbox" id="other2_req" name="app_other2_req" value="yes" class="required-checkbox" disabled>
                                    <label for="other2_req">Required</label>
                                </div>
                            </div>
                            
                            <!-- Custom Field 3 -->
                            <div class="field-row custom-field">
                                <div class="field-col field-col-include">
                                    <input type="checkbox" id="other3" name="app_other3" value="yes" class="field-checkbox">
                                </div>
                                <div class="field-col field-col-name field-col-custom">
                                    <label for="other3">Custom Field 3</label>
                                    <input type="text" id="other3_name" name="app_other3_name" placeholder="Field Name *">
                                    <select name="app_other3_type" id="other3_type" class="field-type-select">
                                        <option value="text">Text</option>
                                        <option value="file">File Upload</option>
                                        <option value="date">Date</option>
                                    </select>
                                </div>
                                <div class="field-col field-col-required">
                                    <input type="checkbox" id="other3_req" name="app_other3_req" value="yes" class="required-checkbox" disabled>
                                    <label for="other3_req">Required</label>
                                </div>
                            </div>
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
<script src="<?php echo URLROOT; ?>/js/service_provider/date_time_validate.js"></script>
<script src="<?php echo URLROOT; ?>/js/service_provider/jobPostValidation.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>