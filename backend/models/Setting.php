<?php

namespace backend\models;

use Yii;
use backend\vendors\Common;

/**
 * This is the model class for table "setting".
 *
 * @property string $name
 * @property string $value
 * @property string $updated_dt
 * @property integer $updated_by
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
            [['updated_dt'], 'safe'],
            [['updated_by'], 'integer'],
            [['name'], 'string', 'max' => 75],
            [['value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'value' => 'Value',
            'updated_dt' => 'Updated Dt',
            'updated_by' => 'Updated By',
        ];
    }
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->updated_dt = Common::datetimeTimestamp();
            $this->updated_by = Yii::$app->user->identity->id;
            return true;
        } else {
            return false;
        }
    }
}
