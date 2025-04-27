<?php 
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'uniquest');
    
    define('APPROOT', dirname(dirname(__FILE__)));
    define('URLROOT', 'http://localhost/UniQuest');
    define('PUBROOT', dirname(dirname(dirname(__FILE__))) . '/public');
    define('UPLOADROOT', 'http://localhost/UniQuest/public/uploads');
    define('TEMPLATEROOT', dirname(dirname(dirname(__FILE__))) . '/templates');
    define('PHPMAILERROOT', dirname(dirname(dirname(__FILE__))) . '/PHPMailer');
    define('SITENAME', 'UniQuest');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    define('ERROR_LOG', APPROOT . '/logs/error.log');
    define('MAIL_LOG', APPROOT . '/logs/mail.log');
    define('DEBUG_LOG', APPROOT . '/logs/debug.log');

    session_start();

    define('SMTP_SETTINGS', [
        'smtp_host' => 'smtp.gmail.com',
        'smtp_auth' => true,
        'smtp_username' => 'pkmsakiththewmikasl@gmail.com', 
        'smtp_password' => 'tivk biwx biqm bxai',  
        'smtp_secure' => 'tls', 
        'smtp_port' => 587, 
        'from_email' => 'pkmasakiththewmikasl@gmail.com',
        'from_name' => 'UniQuest',
    ]);
    
?>