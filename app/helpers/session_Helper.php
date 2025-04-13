<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/flash.css">
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

<!-- Premium error -->
<?php if(isset($_SESSION['show_premium_error'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Flash.show("Please upgrade to a premium plan to access this feature.", "error");
    });
</script>
<?php unset($_SESSION['show_premium_error']); ?>
<?php endif; ?>

<!-- Report error -->
<?php if(isset($_SESSION['show_report_error'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Flash.show("Please upgrade to a premium plan to access this feature.", "error");
    });
</script>
<?php unset($_SESSION['show_report_error']); ?>
<?php endif; ?>

<script src="<?php echo URLROOT; ?>/js/components/flash.js"></script>