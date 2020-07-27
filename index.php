<?php
//die('here');
/*if($_SERVER['REMOTE_ADDR'] != "43.250.165.172"){
    echo file_get_contents('maintenance.html');exit;
}*/

/* Set timezone and time limit */
date_default_timezone_set('Asia/Kolkata');

// display all errors except notices
set_time_limit(0); // 0:Infinite time
ini_set("display_errors", 1);
ini_set("memory_limit", "512M");

if($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'grdjournals.local'){
    defined('ENVIRONMENT') or define('ENVIRONMENT', 'dev'); // DEVELOPMENT, PRODUCTION
    error_reporting(E_ALL);
}else{
  	defined('ENVIRONMENT') or define('ENVIRONMENT', 'prod'); // DEVELOPMENT, PRODUCTION
    error_reporting(E_ALL ^ E_NOTICE);
}
/* Define environment */

if($_SERVER['HTTP_HOST'] == 'conference.grdjournals.com'){
    header('Location: http://conference.grdjournals.com/admin');
    exit;
    defined('CONF_WEB_PANEL') or define('CONF_WEB_PANEL', true);
} else {
    defined('CONF_WEB_PANEL') or define('CONF_WEB_PANEL', false);
}

/* Define debug mode here */
(ENVIRONMENT == "dev") ? defined('DEBUG') or define('DEBUG', FALSE) : defined('DEBUG') or define('DEBUG', FALSE);

defined('YII_DEBUG') or define('YII_DEBUG', DEBUG);
defined('YII_ENV') or define('YII_ENV', ENVIRONMENT);

require( 'vendor/autoload.php');
if(in_array($_SERVER['SERVER_ADDR'], array("192.168.0.103","180.211.110.195"))){
    require( '/../yii_src/yii-2.0.3/framework/Yii.php');
}else{
    require( 'vendor/yiisoft/yii2/Yii.php');
}
    
require( 'common/config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require( 'common/config/main.php'), require( 'common/config/main-local.php'), require(__DIR__ . '/config/main.php'), require(__DIR__ . '/config/main-local.php')
);
//die('asdf');
$application = new yii\web\Application($config);
$application->run();
