<?php require APPROOT . '/views/components/ser_header.php'; ?>

<body>

    <div class="job-post-form-container">
        <h2>Add New Job Post</h2>
        <form action="submit-job-post.php" method="POST" class="job-post-form">
            <div class="form-left">
                <label for="jobName">Job Name:</label>
                <input type="text" id="jobName" name="jobName" placeholder="Job Name" required>

                <label for="jobDescription">Job Description:</label>
                <textarea id="jobDescription" name="jobDescription" placeholder="Job Description" required></textarea>

                <label for="jobBenefits">Job Benefits:</label>
                <input type="text" id="jobBenefits" name="jobBenefits" placeholder="Job Benefits">

                <label for="jobLocation">Job Location:</label>
                <input type="text" id="jobLocation" name="jobLocation" placeholder="Job Location">

                <label for="salaryRange">Salary Range:</label>
                <input type="text" id="salaryRange" name="salaryRange" placeholder="Salary Range">
            </div>

            <div class="form-right">
                <label for="qualifications">Required Qualifications:</label>
                <input type="text" id="qualifications" name="qualifications" placeholder="Required Qualifications">

                <label for="address">Address:</label>
                <textarea id="address" name="address" placeholder="Address" required></textarea>

                <label for="jobType">Job Type:</label>
                <select id="jobType" name="jobType" required>
                    <option value="Full-time">Full-time</option>
                    <option value="Part-time">Part-time</option>
                    <option value="Internship">Internship</option>
                </select>

                <label for="contactNo">Contact No:</label>
                <input type="tel" id="contactNo" name="contactNo" placeholder="Contact No" required>

                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" placeholder="Email Address" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-btn">Post Job</button>
            </div>
        </form>
    </div>
</body>

<?php require APPROOT . '/views/components/footer.php'; ?>

