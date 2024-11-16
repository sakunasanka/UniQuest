<?php require APPROOT . '/views/components/ser_header.php'; ?>

<body>

    <div class="job-post-form-container">
        <h2>Add New Job Post</h2>

        <form action="<?php echo URLROOT; ?>/service_provider/jobpost" method="post" class="job-post-form">
            <div class="form-left">
                <label for="jobName">Job Name:</label>
                <input type="text" id="jobName" name="jobName" placeholder="Job Name"   value="<?php  $data['job_name']; ?>">

                <span class="form-invalid"><?php echo $data['job_name_err']; ?></span>

                <label for="jobDescription">Job Description:</label>
                <textarea id="jobDescription" name="jobDescription" placeholder="Job Description" value="<?php echo $data['Description']; ?>"></textarea>
                <span class="form-invalid"><?php echo $data['Description_err']; ?></span>

                <label for="jobBenefits">Job Benefits:</label>
                <input type="text" id="jobBenefits" name="jobBenefits" placeholder="Job Benefits" value="<?php  $data['job_benifits']; ?>">
                <span class="form-invalid"><?php echo $data['job_benifits_err']; ?></span>

                <label for="jobLocation">Job Location:</label>
                <input type="text" id="jobLocation" name="jobLocation" placeholder="Job Location" value="<?php  $data['job_location']; ?>">
                <span class="form-invalid"><?php echo $data['job_location_err']; ?></span>

                <label for="salaryRange">Salary Range:</label>
                <input type="text" id="salaryRange" name="salaryRange" placeholder="Salary Range" value="<?php  $data['salary_range']; ?>">
                <span class="form-invalid"><?php echo $data['salary_range_err']; ?></span>
            </div>

            <div class="form-right">
                <label for="qualifications">Required Qualifications:</label>
                <input type="text" id="qualifications" name="qualifications" placeholder="Required Qualifications" value="<?php $data['required_skills']; ?>">
                <span class="form-invalid"><?php echo $data['required_skills_err']; ?></span>

                <label for="address">Address:</label>
                <textarea id="address" name="address" placeholder="Address" value="<?php  $data['adress']; ?>"></textarea>
                <span class="form-invalid"><?php echo $data['adress_err']; ?></span>

                <label for="jobType">Job Type:</label>
                <select id="jobType" name="jobType" required>
                    <option value="Full-time">Full-time</option>
                    <optivon value="Part-time">Part-time</optivon>
                    <option value="Internship">Internship</option>
                </select>

                <!-- <label for="contactNo">Contact No:</label>
                <input type="tel" id="contactNo" name="contactNo" placeholder="Contact No" >

                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" placeholder="Email Address" > -->
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-btn"  value="post">Post Job</button>
            </div>
        </form>
    </div>
</body>

<?php require APPROOT . '/views/components/footer.php'; ?>

