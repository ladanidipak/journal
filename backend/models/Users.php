<?php

namespace app\models;

use backend\models\Conference;
use Yii;
use backend\vendors\Common;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $password
 * @property string $first_name
 * @property integer $user_group
 * @property string $last_name
 * @property string $email
 * @property string $profile_pic
 * @property string $company_name
 * @property string $contact_person
 * @property string $description
 * @property integer $created_by
 * @property string $created_dt
 * @property integer $updated_by
 * @property string $updated_dt
 * @property integer $status
 * @property integer $is_deleted
 * @property integer $conf_id
 */
class Users extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    /*public $statusArr = array(1 => 'Active', 0 => 'Inactive');*/
    public $isloginArr = array(1 => 'Yes', 0 => 'No');
    public $confirm_password, $full_name;
    /* THUMB OPTIONS */
    public $ThumbSize = array("0" => "48", "1" => "48");

    const THUMB_SMALL = "small_";

    /* THUMB OPTIONS */
    
    /** USER TYPE **/
    const ADMIN = 1;
    const CONFERENCE_USER = 2;
    const CUSTOMER = 3;
    /** USER TYPE **/

    public static function tableName() {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['password', 'confirm_password', 'user_group', 'status','first_name', 'last_name', 'email','status','type','phone'], 'required'],
            [['company_name','contact_person','description'],'required','on'=>'merchant'],
            [['conf_id','user_group', 'created_by', 'updated_by', 'status', 'is_deleted'], 'integer'],
            [['created_dt', 'updated_dt'], 'safe'],
            ['email', 'unique', 'targetAttribute' => 'email'],
            ['email', 'email'],
            ['profile_pic', 'image', 'extensions' => Yii::$app->params['allowedImages']],
            [['email', 'password', 'confirm_password', 'profile_pic'], 'string', 'max' => 255],
            [['first_name', 'last_name'], 'string', 'max' => 64],
            [['password', 'confirm_password'], 'string', 'min' => 6],
            ['confirm_password', 'match', 'pattern' => '/^[A-Za-z0-9_!@#$%^&*()+=?.,]+$/u', 'message' => 'Space are not allowed in password.'],
            ['confirm_password', 'compare', 'compareAttribute' => 'password']
        ];
    }
    
    public function datevalidation($attribute_name,$params){
        
        
        if (strtotime($this->dob) >= strtotime(date('d/m/Y'))) {
                $this->addError('dob','Please Enter Valid DOB');
        }
    }
    
    public function getRoles() {
        return $this->hasOne(RoleMaster::className(), ['id' => 'user_group']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'password' => 'Password',
            'first_name' => 'First Name',
            'user_group' => 'User Group',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'profile_pic' => 'Profile Image',
            'created_by' => 'Created By',
            'created_dt' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_dt' => 'Updated Date',
            'status' => 'Status',
            'is_deleted' => 'Is Deleted',
            'country_id' => 'Country',
            'state_id' => 'State',
            'city_id' => 'City',
            'company_name' => 'Company Name',
            'contact_person' => 'Contact Person',
            'description' => 'Description',
            'conf_id' => 'Conference',
        ];
    }
    
    public function getContinent() {
        return $this->hasOne(Location::className(), ['location_id' => 'continent_id'])->from(["M2" => Location::tableName()]);
    }
    public function getCountry() {
        return $this->hasOne(Location::className(), ['location_id' => 'country_id'])->from(["M2" => Location::tableName()]);
    }
    public function getState() {
        return $this->hasOne(Location::className(), ['location_id' => 'state_id'])->from(["M2" => Location::tableName()]);
    }
    public function getCity() {
        return $this->hasOne(Location::className(), ['location_id' => 'city_id'])->from(["M2" => Location::tableName()]);
    }

    public function getConference(){
        return $this->hasOne(Conference::className(), ['id' => 'conf_id'])->from(["Conference" => Conference::tableName()]);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->updated_dt = Common::datetimeTimestamp();
            $this->updated_by = Yii::$app->user->identity->id;
            if($insert){
                $this->created_dt = Common::datetimeTimestamp();
                $this->created_by = Yii::$app->user->identity->id;
            }
            return true;
        } else {
            
            return false;
        }
    }

    public function afterFind() {                
        $this->full_name = !empty($this->full_name)?$this->full_name: $this->first_name." ".$this->last_name;
        parent::afterFind();
    }

    /* Function For upload profile picture with thumb */

    public function uploadProfilePicture($model,$oldlogo=null) {
        $profile_pic = UploadedFile::getInstance($model, 'profile_pic');
        $directoryPath = Yii::$app->params['usersPath'] . $model->id . DIRECTORY_SEPARATOR;
        
        if (common::checkAndCreateDirectory($directoryPath) && !empty($profile_pic)) {
            $baseName = date('d-m-Y').$profile_pic->baseName;
            if(!empty($oldlogo) && file_exists($directoryPath.$oldlogo)){
                unlink($directoryPath.$oldlogo);
            }
            if(!empty($oldlogo) && file_exists($directoryPath.'small_'.$oldlogo)){
                unlink($directoryPath.'small_'.$oldlogo);
            }
            $profile_pic->saveAs($directoryPath . $baseName . "." . $profile_pic->extension);
            $origionalPath = $directoryPath . $baseName . "." . $profile_pic->extension;
            $thumbProfilePic = Users::THUMB_SMALL . $baseName . "." . $profile_pic->extension;
            $thumbPath = $directoryPath . $thumbProfilePic;
            $ThumbSize = $this->ThumbSize;
            common::resizeOriginalImage($origionalPath, $thumbPath, $ThumbSize);
            return $baseName . "." . $profile_pic->extension;
            
        } else {
            return $model->profile_pic;
        }
    }

    public static function getUsers() {
        return self::find()->where(["is_deleted" => 0, "status" => 1])->all();
    }

    public static function getUsersList() {
        return ArrayHelper::map(self::getUsers(), 'id', 'full_name');
    }
    
    public static function getAdmins($dropdown = true){
        $records =  self::find()->where(["is_deleted" => 0, "status" => 1, 'type'=>1])->all();
        if($dropdown == false){
            return $records;
        }else{
            return ArrayHelper::map($records, 'id', 'full_name');
        }
    }
    
    public static function getMerchant($dropdown = true){
        $records =  self::find()->where(["is_deleted" => 0, "status" => 1, 'type'=>2])->all();
        if($dropdown == false){
            return $records;
        }else{
            return ArrayHelper::map($records, 'id', 'full_name');
        }
    }
    
    public static function getCustomer($dropdown = true){
        $records =  self::find()->where(["is_deleted" => 0, "status" => 1, 'type'=>3])->all();
        if($dropdown == false){
            return $records;
        }else{
            return ArrayHelper::map($records, 'id', 'full_name');
        }
    }

}
