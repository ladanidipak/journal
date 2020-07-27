<?php

namespace backend\models;

use Yii;
use backend\vendors\Common;

/**
 * This is the model class for table "contact_us".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $subject
 * @property string $message
 * @property string $created_dt
 * @property string $updated_dt
 * @property integer $updated_by
 * @property integer $is_deleted
 */
class ContactUs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $verifyCode;
    public static function tableName()
    {
        return 'contact_us';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'subject', 'message'], 'required'],
            [['message'], 'string'],
            [['email'],'email'],
            [['created_dt', 'updated_dt'], 'safe'],
            [['updated_by','is_deleted'], 'integer'],
            [['name', 'email', 'subject'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 15],
            ['verifyCode', 'required','on'=>"create"],
            ['verifyCode', 'captcha','captchaAction'=>'page/captcha','on'=>"create"],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'subject' => 'Subject',
            'message' => 'Message',
            'created_dt' => 'Created Dt',
            'updated_dt' => 'Updated Dt',
            'updated_by' => 'Updated By',
            'is_deleted' => 'Is Deleted',
        ];
    }
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->updated_dt = Common::datetimeTimestamp();
            $this->updated_by = Yii::$app->user->isGuest?0:Yii::$app->user->identity->id;
            if($insert){
                $this->created_dt = Common::datetimeTimestamp();
            }
            return true;
        } else {
            return false;
        }
    }
}
