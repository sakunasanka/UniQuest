<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/studentPopups.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/student/active_job.css">
<div class="popup-container">
    <div class="popup" id="popup-active">
        <div class="overlay"></div>
        <div class="content">
            <div class="close-btn-container">
                <button class="close-btn" onclick="closeActiveJobConfirm()">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <h2>Activate Job Post</h2>
            <input type="hidden" id="jobID">
            <form action="<?php echo URLROOT; ?>/service_provider/activate" id="activate-job-form" method="POST">
                <input type="hidden" id="jobID">
                <div class="confirmation">
                    <p>Are you sure you want to activate this job post?<br>
                    This will make the job visible to all users.</p>
                </div>
                <label>
                    <input type="checkbox" name="confirm" value="yes" required>
                    <div class="label-text">I confirm I want to activate this job post</div>
                </label>
                <div class="buttons">
                    <a onclick="cancelActiveJobConfirm()" href="#" class="cancel-btn">Cancel</a>
                    <button type="submit" class="activate-btn">Activate Job</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo URLROOT; ?>/public/js/student/active_jobpost.js"></script>