<?php 
    //DB Params
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '1234');
    define('DB_NAME', 'uniquest');
    
    //App Root
    define('APPROOT', dirname(dirname(__FILE__)));

    //URL Root
    define('URLROOT', 'http://localhost/UniQuest');

    //public Root
    define('PUBROOT', dirname(dirname(dirname(__FILE__))) . '/public');

    //uploads Root
    define('UPLOADROOT', 'http://localhost/UniQuest/public/uploads');

    //template Root
    define('TEMPLATEROOT', dirname(dirname(dirname(__FILE__))) . '/templates');

    //PHPMailer Root
    define('PHPMAILERROOT', dirname(dirname(dirname(__FILE__))) . '/PHPMailer');

    //Site Name
    define('SITENAME', 'UniQuest');

    // Enable error displaying (for development only, consider disabling in production)
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    // ini_set('log_errors', 1);

    // Define paths for other log files
    define('ERROR_LOG', APPROOT . '/logs/error.log');
    define('MAIL_LOG', APPROOT . '/logs/mail.log');
    define('DEBUG_LOG', APPROOT . '/logs/debug.log');

    session_start();

    //mail config
    define('SMTP_SETTINGS', [
        'smtp_host' => 'smtp.gmail.com',
        'smtp_auth' => true,
        'smtp_username' => 'pkmsakiththewmikasl@gmail.com', // Your Gmail address
        'smtp_password' => 'tivk biwx biqm bxai',   // Use Gmail App Password
        'smtp_secure' => 'tls',  // Encryption method (TLS/SSL)
        'smtp_port' => 587,  // Port (TLS = 587, SSL = 465)
        'from_email' => 'pkmasakiththewmikasl@gmail.com',
        'from_name' => 'UniQuest',
    ]);
    
?>