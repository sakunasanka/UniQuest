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

// function setFlash($name, $message, $type = 'success') {
//     if (!isset($_SESSION['flash_messages'])) {
//         $_SESSION['flash_messages'] = [];
//     }
//     $_SESSION['flash_messages'][$name] = [
//         'message' => $message,
//         'type' => $type
//     ];
// }

// function showFlashMessages() {
//     if (!empty($_SESSION['flash_messages'])) {
//         foreach ($_SESSION['flash_messages'] as $name => $flash) {
//             echo renderFlashMessage($flash['message'], $flash['type']);
//             unset($_SESSION['flash_messages'][$name]);
//         }
//     }
// }

// function renderFlashMessage($message, $type = 'success') {
//     $icons = array(
//         'success' => 'check-circle',
//         'error' => 'exclamation-circle',
//         'warning' => 'exclamation-triangle',
//         'info' => 'info-circle'
//     );
    
//     $icon = isset($icons[$type]) ? $icons[$type] : 'info-circle';
    
//     return <<<HTML
//     <div class="flash-message {$type}" data-flash>
//         <i class="fas fa-{$icon}"></i>
//         <span>{$message}</span>
//         <button class="flash-close">&times;</button>
//     </div>
// HTML;
// }
?>

<script src="<?php echo URLROOT; ?>/js/components/flash.js"></script>