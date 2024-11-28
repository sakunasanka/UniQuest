<?php 
    //DB Params
    // define('DB_HOST', 'localhost');
    // define('DB_USER', 'root');
    // define('DB_PASS', '');
    // define('DB_NAME', 'uniquest');
    
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

    //DB Params
    // define('DB_HOST', 'localhost');
    // define('DB_USER', 'root');
    // define('DB_PASS', '');
    // define('DB_NAME', 'uniquest');

    // Enable error displaying (for development only, consider disabling in production)
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    
    
?>