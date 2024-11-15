<?php
    
        session_start();
   

    function flash($name = '', $message = '', $class = 'msg-flash') {
        if (!empty($name)) {
            if (!empty($message) && empty($_SESSION[$name])) {
                // Unsetting previous message and class if they exist
                if (!empty($_SESSION[$name])) {
                    unset($_SESSION[$name]);
                }
                if (!empty($_SESSION[$name . '_class'])) {
                    unset($_SESSION[$name . '_class']);
                }

                // Setting new message and class
                $_SESSION[$name] = $message;
                $_SESSION[$name . '_class'] = $class;
            } elseif (empty($message) && !empty($_SESSION[$name])) {
                // Displaying the flash message
                $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
                echo '<div class="' . $class . '" id="' . $class . '">' . $_SESSION[$name] . '</div>';
                unset($_SESSION[$name]);
                unset($_SESSION[$name . '_class']);
            }
        }
    }
?>