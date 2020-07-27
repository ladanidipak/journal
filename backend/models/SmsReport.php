<?php

namespace backend\models;

use Yii;
use backend\vendors\Common;

/**
 * This is the model class for table "sms_report".
 *
 * @property integer $id
 * @property integer $article_id
 * @property string $data
 * @property string $ip
 * @property string $status
 * @property string $message
 * @property integer $created_dt
 */
class SmsReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sms_report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'data', 'ip', 'message'], 'required'],
            [['article_id', 'created_dt'], 'integer'],
            [['data'], 'string'],
            [['ip', 'status'], 'string', 'max' => 20],
            [['message'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
            'data' => 'Data',
            'ip' => 'Ip',
            'status' => 'Status',
            'message' => 'Message',
            'created_dt' => 'Created Dt',
        ];
    }
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if($insert){
                $this->created_dt = date('Y-m-d H:i;s');
            }
            return true;
        } else {
            return false;
        }
    }
}
