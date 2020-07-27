<?php

namespace backend\models;

use Yii;
use backend\vendors\Common;

/**
 * This is the model class for table "review_request_old".
 *
 * @property integer $id
 * @property integer $article_id
 * @property string $reviewer_ids
 * @property string $sent_ids
 * @property string $rejected_ids
 * @property string $created_dt
 * @property integer $created_by
 * @property integer $t_status
 */
class ReviewRequestOld extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static $statusArray = [0 => "", 1=>'Approved', 2 => 'Rejected'];
    public static function tableName()
    {
        return 'review_request_old';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id'], 'required'],
            [['article_id', 'created_by'], 'integer'],
            [['created_dt','t_status'], 'safe'],
            [['reviewer_ids', 'sent_ids', 'rejected_ids'], 'string', 'max' => 255]
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
            'reviewer_ids' => 'Reviewer Ids',
            'created_dt' => 'Created Dt',
            'created_by' => 'Created By',
            'sent_ids' => 'Review Sent Ids',
            'rejected_ids' => 'Rejected Ids',
            't_status' => 't_status',
        ];
    }
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
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
