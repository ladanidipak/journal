<?php

namespace backend\models;

use Yii;
use backend\vendors\Common;

/**
 * This is the model class for table "email_master".
 *
 * @property integer $id
 * @property string $from_name
 * @property string $from_email
 * @property string $reply_to
 * @property string $subject
 * @property string $content
 * @property integer $created_by
 * @property string $created_dt
 * @property integer $updated_by
 * @property string $updated_dt
 * @property integer $is_deleted
 */
class EmailMaster extends \yii\db\ActiveRecord
{

    public $temp_subject;
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'email_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_name', 'from_email', 'subject', 'content'], 'required'],
            [['content'], 'string'],
            [['created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['created_dt', 'updated_dt'], 'safe'],
            [['from_name'], 'string', 'max' => 75],
            [['from_email', 'reply_to'], 'string', 'max' => 255],
            [['subject'], 'string', 'max' => 500],
            [['temp_subject'],'required','on'=>'author_mail'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_name' => 'From Name',
            'from_email' => 'From Email',
            'reply_to' => 'Reply To',
            'subject' => 'Subject',
            'content' => 'Content',
            'created_by' => 'Created By',
            'created_dt' => 'Created Dt',
            'updated_by' => 'Updated By',
            'updated_dt' => 'Updated Dt',
            'is_deleted' => 'Is Deleted',
            'temp_subject' => 'Subject',
        ];
    }
    public function beforeSave($insert) {
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
}
