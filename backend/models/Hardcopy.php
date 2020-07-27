<?php

namespace backend\models;

use Yii;
use backend\vendors\Common;

/**
 * This is the model class for table "hardcopy".
 *
 * @property integer $id
 * @property integer $article_id
 * @property string $dispatched_date
 * @property integer $dispatched_by
 * @property string $courier_name
 * @property string $tracking_no
 * @property string $tracking_url
 * @property integer $detail_sent
 * @property string $created_dt
 * @property integer $created_by
 * @property string $updated_dt
 * @property integer $updated_by
 * @property integer $is_deleted
 */
class Hardcopy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hardcopy';
    }

    public function getArticle(){
        return $this->hasOne(Article::className(),['id'=>'article_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'dispatched_date', 'dispatched_by', 'courier_name', 'tracking_no', 'tracking_url'], 'required'],
            [['article_id', 'detail_sent', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['dispatched_date', 'created_dt', 'updated_dt'], 'safe'],
            [['courier_name', 'dispatched_by', 'tracking_no', 'tracking_url'], 'string', 'max' => 255]
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
            'dispatched_date' => 'Dispatched Date',
            'dispatched_by' => 'Dispatched By',
            'courier_name' => 'Courier Name',
            'tracking_no' => 'Tracking No',
            'tracking_url' => 'Tracking Url',
            'detail_sent' => 'Detail Sent',
            'created_dt' => 'Created Dt',
            'created_by' => 'Created By',
            'updated_dt' => 'Updated Dt',
            'updated_by' => 'Updated By',
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
}
