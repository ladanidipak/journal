<?php

namespace backend\models;

use Yii;
use backend\vendors\Common;

/**
 * This is the model class for table "review_request_new".
 *
 * @property integer $id
 * @property integer $article_id
 * @property integer $reviewer_id
 * @property integer $review_status
 * @property string $created_dt
 * @property integer $created_by
 * @property string $reply_dt
 */
class ReviewRequest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static $statusArray = [0 => "", 1=>'Approved', 2 => 'Rejected'];
    public static function tableName()
    {
        return 'review_request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'reviewer_id'], 'required'],
            [['article_id', 'reviewer_id', 'review_status', 'created_by'], 'integer'],
            [['created_dt','reply_dt'], 'safe']
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
            'reviewer_id' => 'Reviewer ID',
            'review_status' => 'Review Status',
            'created_dt' => 'Created Dt',
            'created_by' => 'Created By',
            'reply_dt' => 'Reply Date',
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
