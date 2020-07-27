<?php

namespace backend\models;

use Yii;
use backend\vendors\Common;

/**
 * This is the model class for table "testimonials".
 *
 * @property integer $id
 * @property string $author
 * @property string $description
 * @property integer $status
 * @property string $created_dt
 * @property integer $created_by
 * @property string $updated_dt
 * @property integer $updated_by
 * @property integer $is_deleted
 */
class Testimonials extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'testimonials';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['description'], 'string'],
            [['status', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['created_dt', 'updated_dt'], 'safe'],
            [['author'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author' => 'Author',
            'description' => 'Description',
            'status' => 'Status',
            'created_dt' => 'Created Dt',
            'created_by' => 'Created By',
            'updated_dt' => 'Updated Dt',
            'updated_by' => 'Updated By',
            'is_deleted' => 'Is Deleted',
        ];
    }
    public static function getActiveTestimonials() {
            return self::findAll(['status'=>1,'is_deleted'=>0]);
     
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
