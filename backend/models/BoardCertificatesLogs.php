<?php

namespace backend\models;

use Yii;
use backend\vendors\Common;

/**
 * This is the model class for table "board_certificates_logs".
 *
 * @property integer $id
 * @property string $name
 * @property integer $board_member
 * @property string $recognize
 * @property string $date_on_certificate
 * @property string $to
 * @property string $subject
 * @property string $body
 * @property integer $created_by
 * @property integer $created_dt
 * @property integer $updated_by
 * @property integer $updated_dt
 * @property integer $is_deleted
 *
 * @property Setting $name0
 * @property Setting $recognize0
 * @property Setting $dateOnCertificate
 */
class BoardCertificatesLogs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'board_certificates_logs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'recognize', 'date_on_certificate', 'to', 'subject', 'body'], 'required'],
            [['board_member', 'created_by', 'created_dt', 'updated_by', 'updated_dt', 'is_deleted'], 'integer'],
            [['name', 'recognize', 'date_on_certificate', 'to', 'subject', 'body'], 'string', 'max' => 75]
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
            'board_member' => 'Board Member',
            'recognize' => 'Recognize',
            'date_on_certificate' => 'Date On Certificate',
            'to' => 'To',
            'subject' => 'Subject',
            'body' => 'Body',
            'created_by' => 'Created By',
            'created_dt' => 'Created Dt',
            'updated_by' => 'Updated By',
            'updated_dt' => 'Updated Dt',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getName0()
    {
        return $this->hasOne(Setting::className(), ['name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecognize0()
    {
        return $this->hasOne(Setting::className(), ['name' => 'recognize']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDateOnCertificate()
    {
        return $this->hasOne(Setting::className(), ['name' => 'date_on_certificate']);
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
