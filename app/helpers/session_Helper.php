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
        Flash.show("Please upgrade to Enterprise plan to post more than 20 jobs.<br>Or wait for <?php echo $_SESSION['remaining_days']; ?>.", "error");
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

