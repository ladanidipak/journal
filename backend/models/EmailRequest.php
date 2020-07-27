<?php

namespace backend\models;

use Yii;
use backend\vendors\Common;

/**
 * This is the model class for table "email_request".
 *
 * @property integer $id
 * @property integer $message_id
 * @property string $send_to_ids
 * @property integer $id_from
 * @property integer $id_to
 * @property integer $id_ended
 * @property integer $list_id
 * @property integer $send_time
 * @property string $created_dt
 * @property integer $created_by
 * @property integer $send_status
 * @property integer $is_deleted
 */
class EmailRequest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static $statusArray = array(1=>"Under Process", 2 => "Started", 3=>"Sent",4=>"Cancelled");

    public static function tableName()
    {
        return 'email_request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_id'], 'required'],
            [['message_id', 'id_from', 'id_to', 'id_ended', 'created_by', 'send_status', 'is_deleted', 'list_id'], 'integer'],
            [['send_to_ids'], 'string'],
            [['created_dt', 'send_to_ids'], 'safe'],
            [['id_from','id_to'],'required','on'=>['send_email']],
            [['list_id'],'required','on'=>['send_list']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message_id' => 'Message ID',
            'send_to_ids' => 'Send To Ids',
            'id_from' => 'Contact ID - Start',
            'id_to' => 'Contact ID - End',
            'id_ended' => 'Id Ended',
            'list_id' => 'List',
            'send_time' => 'Schedule Time',
            'created_dt' => 'Created Dt',
            'created_by' => 'Created By',
            'send_status' => 'Send Status',
            'is_deleted' => 'Is Deleted',
        ];
    }

    public function getMessage(){
        return $this->hasOne(EmailMaster::className(),['id'=>'message_id']);
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {

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
