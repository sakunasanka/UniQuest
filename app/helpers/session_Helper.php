<?php

function flash($name) {
    if (isset($_SESSION['flash_messages'][$name])) {
        $flash = $_SESSION['flash_messages'][$name];
        unset($_SESSION['flash_messages'][$name]);
        return $flash;
    }
    return null;
}
?>

<?php if(isset($_SESSION['show_premium_error'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Flash.show("Please upgrade to a premium plan to access this feature.", "error");
    });
</script>
<?php unset($_SESSION['show_premium_error']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['show_report_error'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Flash.show("Please upgrade to a premium plan to access this feature.", "error");
    });
</script>
<?php unset($_SESSION['show_report_error']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['show_job_apply_error'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Flash.show("You have already applied for this job", "error");
    });
</script>
<?php unset($_SESSION['show_job_apply_error']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['show_internship_apply_error'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Flash.show("You have already applied for this internship", "error");
    });
</script>
<?php unset($_SESSION['show_internship_apply_error']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['show_job_post_error_free'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Flash.show("Please upgrade to a premium plan to post more than 2 jobs.<br>Or wait for <?php echo $_SESSION['remaining_days']; ?>.", "error");
    });
</script>
<?php unset($_SESSION['show_job_post_error_free']); 
    unset($_SESSION['remaining_days']); ?>

<?php endif; ?>

<?php if(isset($_SESSION['show_job_post_error_pro'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Flash.show("Please upgrade to Enterprise plan to post more than 5 jobs.<br>Or wait for <?php echo $_SESSION['remaining_days']; ?>.", "error");
    });
</script>
<?php unset($_SESSION['show_job_post_error_pro']); 
    unset($_SESSION['remaining_days']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['show_job_edit_error'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Flash.show("Please upgrade to a premium plan to access this feature.", "error");
    });
</script>
<?php unset($_SESSION['show_job_edit_error']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['job_send_to_verify'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Flash.show("Your job post has been sent for verification.", "success");
    });
</script>
<?php unset($_SESSION['job_send_to_verify']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['job_post_error'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Flash.show("Sorry, job post failed to publish.<br>Try again later.", "error");
    });
</script>
<?php unset($_SESSION['job_post_error']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['show_contact_us_success'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Flash.show("Your message has been sent successfully.", "success");
    });
</script>
<?php unset($_SESSION['show_contact_us_success']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['show_contact_us_error'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Flash.show("An error occurred while sending your message. Please try again later.", "error");
    });
</script>
<?php unset($_SESSION['show_contact_us_error']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['application_success'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Flash.show("Your application has been submitted successfully.", "success");
    });
</script>
<?php unset($_SESSION['application_success']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['application_error'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Flash.show("An error occurred while submitting your application. Please try again later.", "error");
    });
</script>
<?php unset($_SESSION['application_error']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['complaint_submit_success'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Flash.show("Your complaint has been submitted successfully.", "success");
    });
</script>
<?php unset($_SESSION['complaint_submit_success']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['complaint_submit_error'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Flash.show("An error occurred while submitting your complaint. Please try again later.", "error");
    });
</script>
<?php unset($_SESSION['complaint_submit_error']); ?>
<?php endif; ?>


<?php if(isset($_SESSION['existing_complaint'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Flash.show("You have already submitted a complaint. Please wait for a response.", "error");
    });
</script>
<?php unset($_SESSION['existing_complaint']); ?>
<?php endif; ?>