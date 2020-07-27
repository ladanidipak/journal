<?php

namespace backend\models;

use Yii;
use backend\vendors\Common;

/**
 * This is the model class for table "contact_list".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_by
 * @property string $created_dt
 * @property integer $updated_by
 * @property string $updated_dt
 * @property integer $is_deleted
 */
class ContactList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['created_dt', 'updated_dt'], 'safe'],
            [['name'], 'string', 'max' => 255]
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
            'created_by' => 'Created By',
            'created_dt' => 'Created Dt',
            'updated_by' => 'Updated By',
            'updated_dt' => 'Updated Dt',
            'is_deleted' => 'Is Deleted',
        ];
    }
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->updated_dt = date('Y-m-d H:i:s');
            $this->updated_by = Yii::$app->user->identity->id;
            if($insert){
                $this->created_dt = date('Y-m-d H:i:s');
                $this->created_by = Yii::$app->user->identity->id;
            }
            return true;
        } else {
            return false;
        }
    }

    public static function getList(){
        return \yii\helpers\ArrayHelper::map(self::find()->where(['is_deleted'=>0])->orderBy('name ASC')->all(), 'id', 'name');
    }
}
