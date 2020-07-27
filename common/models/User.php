<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\security;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface {

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    public $password_hash;
    public $auth_key;
    public $ThumbSize = array("0" => "48", "1" => "48");  // 0-Width,1-Height

    /**
     * @inheritdoc
     */

    public static function tableName() {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByEmail($username) {
        return static::findOne(['email' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        $encpassword = $this->passencrypt($password);
        return $this->password === $encpassword;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    /**
     * Get encrypted string
     * @param   string  $string
     * @param   integer $lngth
     * @access  public
     * @return  string
     */
    public static function passencrypt($str, $lngth = 16) {
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

    /**
     * @name createProfilePicture
     * @access Public
     * @author Alpesh Vaghela
     * @since 29th June 2015
     */
    public static function createProfilePicture($model) {

        $phptextObj = new \backend\vendors\phptextClass;	
        
        $ThumbSize = $model->ThumbSize;
        $text = strtoupper($model->first_name[0]);
        //Set the image width and height
        $width = $ThumbSize[0];
        $height = $ThumbSize[1];
        
        $usersPath = Yii::$app->params["usersPath"] . $model->id . DIRECTORY_SEPARATOR;
        if (!file_exists($usersPath)) {
            mkdir($usersPath, 0777);
        }
        $extension = ".jpg";
        $profile_pic = time() . "profile_pic".$extension;                        
        $imageName = \app\models\Users::THUMB_SMALL.$profile_pic;
        $phptextObj->phptext($text,'#FFF','',30,$height,$width,$usersPath,$imageName);
        return $profile_pic;
    }

}
