<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\vendors;

use Yii;
use yii\web\Session;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Common {

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    public $password_hash;

    public function __construct() {
        
    }

    /**
     * Get IP Address
     * @access  public
     * @return  string IP Address
     */
    public static function getIpAddress() {
        $ipaddress = "";
        if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != "") {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != "") {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (getenv('HTTP_X_FORWARDED_FOR') && trim(getenv('HTTP_X_FORWARDED_FOR')) != "") {
            $ipaddress = getenv('HTTP_X_FORWARD_FOR');
        }
        return $ipaddress;
    }

    /**
     * Get Mac address
     * @access  public
     * @return  string Mac Address
     */
    public static function getMacAddress() {
        $macAddress = "e0:69:95:f5:45:52";
        return $macAddress;
    }

    public static function checkLoggedIn() {
        $session = Yii::$app->session;
        if ($session->get('userId') && is_numeric($session->get('userId')) && !$session->get('isGuest')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if user is super admin
     */
    public static function isSuperAdmin() {
        return Yii::$app->user->isSuperAdmin();
    }

    /*     * *
     * Date-Time Functions
     */

    public static function getDateTime($date = "now", $format = "Y-m-d H:i:s") {
        return ($date != "" && ($date != "0000-00-00" && $date != "0000-00-00 00:00:00")) ? date($format, strtotime("$date")) : "";
    }

    public static function getFormatDateTime($date = "now", $format = "d M, Y   H:i:s") {
        return ($date != "" && ($date != "0000-00-00" && $date != "0000-00-00 00:00:00")) ? date($format, strtotime("$date")) : "";
    }

    public static function dmyToYmd($date, $formate = '-') {

        $dateObj = explode('/', $date);
        return !empty($date) ? $dateObj[2] . $formate . $dateObj[1] . $formate . $dateObj[0]: date('Y-m-d');
    }

    public static function ymdToDmy($date, $formate = '/') {

        $dateObj = explode('-', $date);
        return !empty($date) ? $dateObj[2] . $formate . $dateObj[1] . $formate . $dateObj[0]: date('d/m/Y');
    }

    public static function getDateTimeFromTimeStamp($timeStamp, $format = "Y-m-d H:i:s") {

        return (!empty($timeStamp) && is_numeric($timeStamp)) ? date($format, $timeStamp) : "";
    }

    /*
     * $futureday = (365 day) or (1 year) or (1 month)
     */

    public static function getFutureDate($date, $dateformat = 'd/m/Y', $futureday = '365 day') {

        return (!empty($date) ? date($dateformat, strtotime('+' . $futureday, strtotime($date))) : date('d/m/Y'));
    }

    public static function getTimeStamp($date = "", $format = "Y-m-d") {
        if ($date != "" && !is_numeric($date)) {
            @list($day, $month, $year) = explode(DIRECTORY_SEPARATOR, $date);
            $date = @$month . DIRECTORY_SEPARATOR . @$day . DIRECTORY_SEPARATOR . @$year;
            return strtotime("$date");
        } else
            return strtotime(date($format));
    }

    /**
     * Format date
     *
     * @access  public
     * @return  string formatted date
     */
    public static function formatDate($date = "now", $format = "d M, Y") {
        return ($date != "" && ($date != "0000-00-00 00:00:00" && $date != "00-00-00")) ? date($format, strtotime("$date")) : "--";
    }

    /**
     *  Convert DB date 'Y-m-d' to date format defined in parameter
     */
    public static function dbTimestampToAppDate($timestamp){
        $appDateFormat = \Yii::$app->params['dateFormatPHP'];
        $dateObj = new \DateTime();
        $dateObj->setTimestamp($timestamp);
        return $dateObj->format($appDateFormat);
    }
    
    public static function appDateToDbTimestamp($date){
        $date = $date." 00:00:00"; //added 00 other wise it will add current time
        $appDateFormat = \Yii::$app->params['dateFormatPHP'] . " H:i:s";
        $dateObj = \DateTime::createFromFormat($appDateFormat, $date);
       
        return $dateObj->getTimestamp();
    }
    public static function dbTimestampToAppDateTime($timestamp){
        $appDateTimeFormat = \Yii::$app->params['dateTimeFormat'];
        $dateObj = new \DateTime();
        $dateObj->setTimestamp($timestamp);
        return $dateObj->format($appDateTimeFormat);
    }
    
    public static function appDateTimeToDbTimestamp($datetime){
        $appDateTimeFormat = \Yii::$app->params['dateTimeFormat'];
        $dateObj = \DateTime::createFromFormat($appDateTimeFormat, $datetime);
        return $dateObj->getTimestamp();
    }
    
    public static function datetimeTimestamp(){
        return (new \DateTime)->getTimestamp();
    }

    /*     * *
     * Date-Time Functions
     */

    public static function p($array = array(), $type = 0, $ip = NULL) {
        if ($ip) {
            if ($_SERVER['REMOTE_ADDR'] == $ip) {
                ob_clean();
                echo "<pre>" . print_r($array, true);
                exit;
            } else {
                return true;
            }
        }
        echo '<pre>';
        print_r($array);
        if ($type == 1) {
            exit;
        }
    } 
    public static function isDirectory($directoryPath) {
        return is_dir($directoryPath);
    }

    public static function makeDirectory($directoryPath) {
        return mkdir($directoryPath, 0777, TRUE);
    }

    public static function checkAndCreateDirectory($directoryPath) {
        
        if (!common::isDirectory($directoryPath)): 
            common::makeDirectory($directoryPath);
        endif;
        return true;
    }
    public static function isFileExists($filename){
        return file_exists($filename);
    }

    public static function checkActionAccess($pageUrl) {

        if (Yii::$app->user->isSuperAdmin()):
            return true;
        else:                        
            return in_array($pageUrl, Yii::$app->user->_permissions);
        endif;
    }

    public static function getTitle($pageUrl) {
        if (!empty(Yii::$app->user->_titles) && key_exists($pageUrl, Yii::$app->user->_titles)) {
            return Yii::$app->user->_titles[$pageUrl];
        } else {
            return "Title not defined";
        }
    }

    public static function translateText($keyword) {
        return Yii::t("app", $keyword);
    }
    
    public static function getDropDownText($text){
        return self::translateText("DROPDOWN_TEXT")." ".$text;
    }

    public static function getMessage($class, $message) {
        return '<div class="alert alert-dismissable alert-' . $class . '">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		' . $message . '
		</div>';
    }

    public static function getCurrentCompany() {
        $companyid = Yii::$app->session->get('company_id');
        return !empty($companyid) ? $companyid : '';
    }

    public static function getCurrentBranch() {
        $branchid = Yii::$app->session->get('branch_id');
        return !empty($branchid) ? $branchid : '';
    }

    public static function getCurrentUrl() {
        return trim(Yii::$app->controller->id . "/" . Yii::$app->controller->action->id);
    }

    public static function getCompanyName($id = '') {
        $companyid = !empty($id) ? $id : Yii::$app->session->get('company_id');
        $companydata = \app\models\CompanyMaster::find()->where(['id' => $companyid])->one();
        return !empty($companydata) ? $companydata->company_name : '';
    }

    public static function getBranchName($id = '') {
        $branchid = !empty($id) ? $id : Yii::$app->session->get('branch_id');
        $branchdata = \app\models\BranchMaster::find()->where(['id' => $branchid])->one();
        return !empty($branchdata) ? $branchdata->branch_name : '';
    }



    /**
     * Get encrypted string
     * @param   string  $string
     * @param   integer $lngth
     * @access  public
     * @return  string
     */
    public static function passencrypt($str, $lngth = 25) {
        $str = substr($str, 0, $lngth);
        $str = str_pad($str, $lngth, " ");
        $retstr = "";
        for ($i = 0; $i < $lngth; $i++) {
            $sch = substr($str, $i, 1);
            $iasc = ord($sch) + 2 * $i + 30;
            if ($iasc > 255)
                $iasc = $iasc - 255;
            $sch = chr($iasc);
            $retstr = $retstr . $sch;
        }
        $retstr = implode("*", unpack('C*', $retstr));
        return $retstr;
    }

    /**
     * Get decrypted string
     * @param   string  $pass
     * @access  public
     * @return  string
     */
    public static function passdecrypt($pass) {
        $retstr = "";
        $string = "";
        $data = explode('*', $pass);
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i] != '') {
                $string = $string . pack('C*', $data[$i]);
            }
        }
        $str = $string;
        $lngth = strlen($str);
        for ($i = 0; $i < $lngth; $i++) {
            $sch = substr($str, $i, 1);
            $iasc = ord($sch) - 2 * $i - 30;
            if ($iasc <= 0)
                $iasc = 255 + $iasc;
            $sch = chr($iasc);
            $retstr = $retstr . $sch;
        }
        return trim($retstr);
    }

    public static function getLookupValues($code = '', $selected = '') {
        $lookuparr = array();
        if (!empty($code)) {
            $data = \app\models\LookupIdentifier::find()->where(['and',['like', 'lookup_code', $code],['is_deleted'=>0,'status'=>1]])->with(['lookupmaster'=>function ($query) {$query->andWhere(['status' => 1, 'is_deleted'=>0]);}])->one();            
            foreach ($data->lookupmaster as $key => $value) {
                $lookuparr[$value->id] = $value->description;
            }
        }
        return $lookuparr;
    }

    public static function getStatusArray() {
        return ['1' => self::translateText('ENABLE_BTN_TEXT'), '0' => self::translateText('DISABLE_BTN_TEXT')];
    }

    /**
     *
     * @param type $FilePath
     * @param type $ThumbPath
     * @param type $ThumbSize
     */
    public static function resizeOriginalImage($FilePath, $ThumbPath, $ThumbSize) {
        $resize_type = 'thumb';
        $origImage = getimagesize($FilePath);
        if ($resize_type == 'thumb') {
            $resizeImage = $ThumbSize;
        } else if ($resize_type == 'medium') {
            //$resizeImage = $this->middleSize;
        } else if ($resize_type == 'big') {
            //$resizeImage = $this->bigSize;
        }
        if ($origImage[0] > $resizeImage[0] || $origImage[1] > $resizeImage[1]) {
            // image width
            $width = $resizeImage[0];
            // image height
            $height = $resizeImage[1];
            // Resize the image and save
            if ($origImage["mime"] == "image/jpeg" || $origImage["mime"] == "image/jpg") {
                $src_img = imagecreatefromjpeg($FilePath);
            } else if ($origImage["mime"] == "image/gif") {
                $src_img = imagecreatefromgif($FilePath);
            } else if ($origImage["mime"] == "image/png") {
                $src_img = imagecreatefrompng($FilePath);
            }
            $thumbnail = imagecreatetruecolor($width, $height);
            imagecopyresampled($thumbnail, $src_img, 0, 0, 0, 0, $width, $height, $origImage[0], $origImage[1]);
            if ($origImage["mime"] == "image/jpeg") {
                imagejpeg($thumbnail, $ThumbPath);
            } else if ($origImage["mime"] == "image/gif") {
                imagegif($thumbnail, $ThumbPath);
            } else if ($origImage["mime"] == "image/png") {
                imagepng($thumbnail, $ThumbPath);
            }
            imagedestroy($thumbnail);
        } else {
            copy($FilePath, $ThumbPath);
        }
        return;
    }

    public static function statusLables($model) {
        return ($model->status) ? '<span class="label label-primary">' . self::translateText('ENABLE_BTN_TEXT') . '</span>' : '<span class="label label-danger">' . self::translateText('DISABLE_BTN_TEXT') . '</span>';
    }
    
    public static function getCustomerIndividiualArr($value=''){
        $arr = ['1'=>'Individual','2'=>'Company'];
        if(!empty($value)){
            return isset($arr[$value])?$arr[$value]:'';
        }
        return $arr;
    }
    
    public static function GetCustomerTypeArr($value=''){
        $arr = [1=>'Customer', 2=>'Wholesaler', 3=>'Special Customer'];
        if(!empty($value)){
            return isset($arr[$value])?$arr[$value]:'';
        }
        return $arr;
    }
    
    public static function getCustomersImages($imgname='',$id='',$folder=''){
        $profile_pic = $thumbPrefix.$profile_pic;
        
        $PATH = Yii::$app->params['CustomerImage'].DIRECTORY_SEPARATOR. $id . DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.\app\models\CustomerMaster::THUMB_SMALL;
        $URL = Yii::$app->params['CustomerUrl'].DIRECTORY_SEPARATOR. $id . DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.\app\models\CustomerMaster::THUMB_SMALL;
       
        if ( !empty($imgname)) {
            return $URL . $imgname;
        } else {
            $genderImg = "no-image-male.png";
            return Yii::$app->params['designElementUrl'] . "img/".$genderImg;
        }
    }
    public static function getYesNoList(){
        return [true=>self::translateText("YES_LABEL"),false=>self::translateText("NO_LABEL")];
    }
    public static function getModuleList(){
        return Yii::$app->params["modulesList"];
    }
    public static function getModuleName($module_id){
        $moduleList = self::getModuleList();
        return !empty($moduleList["$module_id"])?strtolower($moduleList["$module_id"]):"";
    }
    public static function isNumeric($string){
        return is_numeric($string);
    }
    
    public static function gridViewButton($cont){
        return self::checkActionAccess("$cont/view")?"{view}":"";
    }
    
    public static function gridUpdateButton($cont){
        return self::checkActionAccess("$cont/update")?"{update}":"";
    }
    
    public static function gridDeleteButton($cont){
        return self::checkActionAccess("$cont/delete")?"{delete}":"";
    }
    
    public static function getDropDownOptions($model, $name){
        return ['class'=>'chosen-select-width','prompt'=> self::getDropDownText($model->getAttributeLabel($name))];
    }
    
    public static function g_curl_post($url, $fields){
        
        $url = $url;
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        $response = json_decode(curl_exec($ch));
        //echo curl_error($ch);exit;
        curl_close($ch);
        return $response;
    }
    
    public static function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
       $string = preg_replace('/[^A-Za-z0-9_\-\.]/', '', $string); // Removes special chars.

       return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }

    public static function directoryToZip($name,$path){
        $rootPath = $path;

        $zip = new \ZipArchive();
        $zip->open($name, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);


        /** @var SplFileInfo[] $files */
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($rootPath),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file)
        {
            if (!$file->isDir())
            {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();
    }

    public static function removeDir($dir){
        $it = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($it,
            \RecursiveIteratorIterator::CHILD_FIRST);
        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dir);
    }
    public static function rmdir_recursive($dir) {
    foreach(scandir($dir) as $file) {
        if ('.' === $file || '..' === $file) continue;
        if (is_dir("$dir/$file")){
            $this->rmdir_recursive("$dir/$file");
        }
        else {
            @unlink("$dir/$file");
        }
    }
    rmdir($dir);
    }
}
