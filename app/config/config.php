<?php 
    //DB Params
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'uniquest');
    
    //App Root
    define('APPROOT', dirname(dirname(__FILE__)));

    //URL Root
    define('URLROOT', 'http://localhost/UniQuest');

    //public Root
    define('PUBROOT', dirname(dirname(dirname(__FILE__))) . '/public');

    //uploads Root
    define('UPLOADROOT', 'http://localhost/UniQuest/public/uploads');

    //Site Name
    define('SITENAME', 'UniQuest');

    // Enable error displaying (for development only, consider disabling in production)
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
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