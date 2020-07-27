<?php

namespace backend\models;

use Yii;
use backend\vendors\Common;

/**
 * This is the model class for table "branch".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property integer $is_deleted
 * @property integer $created_dt
 * @property integer $created_by
 * @property integer $updated_dt
 * @property integer $updated_by
 */
class Branch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'branch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status', 'is_deleted', 'created_dt', 'created_by', 'updated_dt', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 100]
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
            'status' => 'Status',
            'is_deleted' => 'Is Deleted',
            'created_dt' => 'Created Dt',
            'created_by' => 'Created By',
            'updated_dt' => 'Updated Dt',
            'updated_by' => 'Updated By',
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
    
    public static function getBranches(){
        return \yii\helpers\ArrayHelper::map(self::find()->where(['is_deleted'=>0, 'status'=>1])->orderBy('name ASC')->all(), 'id', 'name');
    }

    public static function getBrancheNames(){
        return \yii\helpers\ArrayHelper::map(self::find()->where(['is_deleted'=>0, 'status'=>1])->orderBy('name ASC')->all(), 'name', 'name');
    }
}
