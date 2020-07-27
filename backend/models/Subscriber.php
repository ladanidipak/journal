<?php

namespace backend\models;

use Yii;
use backend\vendors\Common;

/**
 * This is the model class for table "subscriber".
 *
 * @property integer $id
 * @property string $email
 * @property integer $status
 * @property integer $is_deleted
 */
class Subscriber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscriber';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['status', 'is_deleted'], 'integer'],
            [['email'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'status' => 'Status',
            'is_deleted' => 'Is Deleted',
        ];
    }
    
}
