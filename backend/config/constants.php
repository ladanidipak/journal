<?php
require_once(dirname(__FILE__) . '/language/en/app.php');

function getBaseScriptUrl()
{
    	$scriptUrl = "";
        $scriptName=basename($_SERVER['SCRIPT_FILENAME']);
        if(basename($_SERVER['SCRIPT_NAME'])===$scriptName)
            $scriptUrl=$_SERVER['SCRIPT_NAME'];
        elseif(basename($_SERVER['PHP_SELF'])===$scriptName)
            $scriptUrl=$_SERVER['PHP_SELF'];
        elseif(isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME'])===$scriptName)
            $scriptUrl=$_SERVER['ORIG_SCRIPT_NAME'];
        elseif(($pos=strpos($_SERVER['PHP_SELF'],'/'.$scriptName))!==false)
            $scriptUrl=substr($_SERVER['SCRIPT_NAME'],0,$pos).'/'.$scriptName;
        elseif(isset($_SERVER['DOCUMENT_ROOT']) && strpos($_SERVER['SCRIPT_FILENAME'],$_SERVER['DOCUMENT_ROOT'])===0)
            $scriptUrl=str_replace('\\','/',str_replace($_SERVER['DOCUMENT_ROOT'],'',$_SERVER['SCRIPT_FILENAME']));
        else
            throw new CException('CHttpRequest is unable to determine the entry script URL.');

    return rtrim(dirname($scriptUrl),'\\/');;
}
$hostName = $_SERVER['HTTP_HOST'];
$docRoot  = $_SERVER['DOCUMENT_ROOT'];
define('DOCPATH',  dirname(dirname(__DIR__)));

$baseDesignPath = getBaseScriptUrl();
$basePath = $baseDesignPath."/../";
define('DOCURL', $basePath);
define('APP_PANEL', 'admin');

$productName = 'GrdJournals Admin Panel';
if ($hostName == "localhost" || $hostName == "conference.localjournal.com" || $hostName == "localjournal.com" ) {
	$dbHost = "localhost";
	$dbUser = "root";
	$dbPass = "";
	$dbPort = "3306";
	$dbName = "journal";
} else {
	$dbHost = "localhost";
	$dbUser = "journal";
	$dbPass = "C{k-P)gFchs+";
	$dbPort = "3306";
	$dbName = "journal";
}

$Thumbwidth = '48';
$Thumbheight = '48';
$serverProtocol   = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == "on")?"https://":"http://";
$webUrl           = $serverProtocol . $hostName . $basePath; 
$designElementUrl = $serverProtocol . $hostName . $baseDesignPath . '/design_elements/';
$documentPath     = $docRoot . $basePath;
$tempPath = $docRoot . $basePath . 'temp/';
$imageUrl = $webUrl . 'design_elements/img/';

$uploadUrl = dirname(dirname($webUrl)).'/uploads/';
$uploadPath = dirname(dirname($documentPath)).'/uploads/';


$defaultMainLayout = "//layouts/columnMain";
$superAdminName = 'super';
$superAdminId = 1;
$inactiveStatus = 0;
$activeStatus = 1;
$defaultPageSize = 100;
$tempPageSize = 10;
$gridNameLimit = 50;
$ADMIN_EMAIL_FROM = "info@grdjournals.com";
$DATE_FORMAT = "dd/mm/yyyy"; // Please don't change it.
$DATE_FORMAT_PHP = "d/m/Y";   // Please don't change it.
$DATE_TIME_FORMAT = $DATE_FORMAT_PHP . " h:i A";

/** need to ask */
$MAX_FILE_SIZE = "48"; //Always Use MB
$ALLOWED_IMAGES = array('jpeg', 'jpg', 'gif', 'png');
$ALLOWED_FILES = array('txt', 'pdf', 'doc', 'docx', 'ppt', 'pptx', 'rtf', 'xls', 'xlsx');

$COMPANY_NAME = "GRD Journals";
$COMPANY_ADDRESS = "India";

$ERROR_USER = array('info@grdjournals.com' => 'Pritesh Khetani');
// Assign constants to array, this array will be passed to params variable of application.config.main.php
