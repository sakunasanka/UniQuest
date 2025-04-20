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

<?php if(isset($_SESSION['show_job_edit_error'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Flash.show("Please upgrade to a premium plan to access this feature.", "error");
    });
</script>
<?php unset($_SESSION['show_job_edit_error']); ?>
<?php endif; ?>
