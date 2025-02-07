<?php
//load config
require_once 'config/config.php';

//load libraries
require_once 'libraries/Core.php';
require_once 'libraries/Controller.php';
require_once 'libraries/Database.php';
require_once 'libraries/Model.php';

//load helpers
require_once 'helpers/Redirect.php';
require_once 'helpers/Validator.php';
require_once 'helpers/FileUploadHelper.php';
require_once 'helpers/session_Helper.php';
require_once 'helpers/TimeConvert_Helper.php';
require_once 'helpers/Pager.php';
require_once 'helpers/Sorter.php';

//load middlewares
require_once 'middlewares/AuthMiddleware.php';
require_once 'middlewares/URLMiddleware.php';

$init = new Core();
?>