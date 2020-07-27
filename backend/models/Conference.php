<?php

namespace backend\models;

use Yii;
use backend\vendors\Common;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "conf_pro".
 *
 * @property integer $id
 * @property string $conf_cor_name
 * @property string $email
 * @property string $org_name
 * @property string $phone
 * @property string $org_website
 * @property string $dept_name
 * @property string $aff_by
 * @property integer $conf_type
 * @property string $title
 * @property string $description
 * @property string $short_name
 * @property string $conf_date
 * @property string $specialization
 * @property string $venue
 * @property string $conf_website
 * @property string $brochure
 * @property string $college_logo
 * @property string $pub_date
 * @property integer $is_deleted
 * @property integer $created_dt
 * @property integer $updated_dt
 * @property integer $updated_by
 */
class Conference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $verifyCode;
    public static $conf_type_array = ['1' =>'National','2'=>'International'];

    public static function getConfTypeArray($id = null)
    {
        if($id){
            return self::$conf_type_array[$id];
        }else{
            return self::$conf_type_array;
        }
    }

    public static function tableName()
    {
        return 'conference';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['conf_cor_name', 'email', 'org_name', 'phone', 'org_website', 'dept_name', 'aff_by', 'title', 'description', 'short_name', 'conf_date', 'specialization', 'venue', 'conf_website','conf_type','pub_date'], 'required'],
            [['conf_type', 'is_deleted', 'updated_by'], 'integer'],
            [['description'], 'string', 'max'=>1000],
            [['email'],'email'],
            [['conf_cor_name', 'org_name','conf_date'], 'string', 'max' => 100],
            [['email', 'org_website', 'dept_name', 'aff_by', 'conf_website'], 'string', 'max' => 75],
            [['phone', 'short_name'], 'string', 'max' => 50],
            [['title', 'specialization', 'venue'], 'string', 'max' => 255],
            [['brochure'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg,jpeg,png,gif,pdf', 'maxSize' => 1024 * 1024 * 5, 'on' => 'create'],
            [['brochure'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg,jpeg,png,gif,pdf', 'maxSize' => 1024 * 1024 * 5, 'on' => 'update'],
            [['college_logo'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg,jpeg,png,gif', 'maxSize' => 1024 * 1024 * 5, 'on' => 'create'],
            [['college_logo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg,jpeg,png,gif', 'maxSize' => 1024 * 1024 * 2, 'on' => 'update'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'conf_cor_name' => 'Name of the Conference Coordinators',
            'email' => 'Email',
            'org_name' => 'University/College Name',
            'phone' => 'Contact Number',
            'org_website' => 'University/College Website',
            'dept_name' => 'Name of the Department',
            'aff_by' => 'Affiliation By',
            'conf_type' => 'National / International Conference',
            'title' => 'Title of the Conference',
            'description' => 'Description about conference',
            'short_name' => 'Short Name of conference',
            'conf_date' => 'Date of the Conference',
            'specialization' => 'Area of Specializations',
            'venue' => 'Venue',
            'conf_website' => 'Conference Website',
            'brochure' => 'Conference Brochure',
            'college_logo' => 'College Logo',
            'pub_date' => 'Publication Date',
            'is_deleted' => 'Is Deleted',
            'created_dt' => 'Created Dt',
            'updated_dt' => 'Updated Dt',
            'updated_by' => 'Updated By',
        ];
    }
    public function beforeSave($insert) {
        $loggedIn = \Yii::$app->user->isGuest;
        if (parent::beforeSave($insert)) {
            $this->updated_dt = date('Y-m-d H:i:s');
            $this->updated_by = ($loggedIn) ? 0 : Yii::$app->user->identity->id;
            if($insert){
                $this->created_dt = date('Y-m-d H:i:s');
            }
            return true;
        } else {
            return false;
        }
    }

    public static function udpateArticle($model){
        $counter = $model->articles;
        $success = 0;
        while($success == 0){
            $counter = $counter + 1;
            $success = self::updateAll(['articles'=>$counter],"articles < {$counter}");
        }
        return $counter;
    }

    public static function getList(){
        $conference = self::find()->where(['is_deleted'=>0])->orderBy('id desc')->all();
        return ArrayHelper  ::map($conference,'id',function($data){return "{$data->short_name} - ".sprintf("GRDCF%03d", $data->id);});
    }
}
