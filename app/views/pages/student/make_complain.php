<?php require APPROOT . '/views/components/header.php'; ?>
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
                <p>Let us know about any problem with this job</p>

                <!-- Form -->
                <form action="<?php echo URLROOT; ?>/student/make_complain/<?php echo $data['jobID'] ?>" method="POST" enctype="multipart/form-data">
                    <label for="title">Job Posting</label>
                    <div class="input-container">
                        <input type="text" id="title" name="title" placeholder="Enter job posting details" value="<?php echo $data['title']; ?>" readonly>
                    </div>
                    <label for="complaint">Complaint</label>
                    <div class="input-container">
                        <textarea id="complaint" name="complaint" rows="5" placeholder="Describe the complaint" required><?php echo $data['complaint']; ?></textarea>
                        <span class="error-msg"><?php echo !empty($data['complaint_err']) ? $data['complaint_err'] : ''; ?></span>
                    </div>
                    <label for="proof">Proof</label>
                    <div class="input-container">
                        <div class="file-drop-area">
                            <div class="file-content">
                                <span>Drag & Drop to Upload Business Registration Copy</span>
                                <button type="button" class="browse-btn">Browse File
                                    <input type="file" id="proof" name="proof" accept=".pdf,.doc,.docx,image/*" required>
                                </button>
                                <span class="file-name">No file selected</span>
                            </div>
                        </div>
                        <span class="req-msg">Only PDF, DOC, DOCX files are allowed, and maximum file size is 5MB</span>
                        <span class="error-msg"><?php echo !empty($data['proof_err']) ? $data['proof_err'] : ''; ?></span>
                    </div>

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
<script type="module" src="<?php echo URLROOT; ?>/public/js/register/fileUpload.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>