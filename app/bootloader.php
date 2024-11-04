<?php
//load config
require_once 'config/config.php';

//load libraries
require_once 'libraries/Core.php';
require_once 'libraries/Controller.php';
require_once 'libraries/Database.php';

//load helpers
require_once 'helpers/Redirect.php';
require_once 'helpers/Validator.php';
require_once 'helpers/ImageUploadHelper.php';

$init = new Core();
