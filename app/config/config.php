<?php 
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
    define('DB_HOST', 'mysql-uniquestdb.alwaysdata.net');  //mysql-uniquestdb.alwaysdata.net
    define('DB_USER', '385988_sakuna');  //385988_sakuna
    define('DB_PASS', 'sakuna_1'); //sakuna_1
    define('DB_NAME', 'uniquestdb_uniquest');  //uniquestdb_uniquest

    // Enable error displaying (for development only, consider disabling in production)
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    
    
?>