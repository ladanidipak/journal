<?php

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
$baseDesignPath = getBaseScriptUrl();
//define('DOCURL', $baseDesignPath);

$basePath = $baseDesignPath."/";
define('DOCURL', $basePath);
$productName = 'GrdJournals';
if ($hostName == "localhost" || $hostName == "conference.localjournal.com" || $hostName == "localjournal.com" ) {
	$dbHost = "localhost";
	$dbUser = "root";
	$dbPass = "";
	$dbPort = "3306";
	$dbName = "journal";
	$insta_key = "08dca171193a663d0f997a89faa3d7b9";
	$insta_token = "ced90bb02bb260486d58a988af75a898";
	$insta_end_point = "https://test.instamojo.com/api/1.1/";
} else {
	$dbHost = "localhost";
	$dbUser = "journal";
	$dbPass = "C{k-P)gFchs+";
	$dbPort = "3306";
	$dbName = "journal";
    $insta_key = "281af0c6b077e904514a2177e29e6471";
    $insta_token = "989cc9b6fbb6040ca84ceda5d0c1a385";
    $insta_end_point = "https://www.instamojo.com/api/1.1/";
}

$serverProtocol   = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == "on")?"https://":"http://";
$webUrl           = $serverProtocol . $hostName . $baseDesignPath; 
$designElementUrl = $baseDesignPath . '/design_elements/';
define("BASEURL", $designElementUrl);
define('DOCPATH',  dirname(__DIR__));
define('APP_PANEL', 'frontend');
$documentPath     = $docRoot . $basePath;
$tempPath = $docRoot . $basePath . 'temp/';
$imageUrl = $webUrl . '/design_elements/images/';

$uploadUrl = $webUrl.'/uploads/';
$uploadPath = dirname($documentPath).'/uploads/';
$reviewerpath = $documentPath.'/uploads/';$defaultMainLayout = "//layouts/columnMain";
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

$COMPANY_NAME = $productName;
$COMPANY_ADDRESS = "India";

$ERROR_USER = array('info@grdjournals.com' => 'Pritesh Khetani');
// Assign constants to array, this array will be passed to params variable of application.config.main.php
