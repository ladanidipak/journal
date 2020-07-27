<?php

namespace backend\models;

use Yii;
use backend\vendors\Common;

/**
 * This is the model class for table "article_revision".
 *
 * @property integer $id
 * @property integer $article_id
 * @property integer $accept_type
 */
class ArticleRevision extends \yii\db\ActiveRecord
{
    public static $accept_type = ['1'=>'Accepted without revision', '2'=>'Minor revision required (Not mandatory)', '3'=>'Major Revision Required(Mandatory)'];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_revision';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'accept_type'], 'required'],
            [['article_id', 'accept_type'], 'integer']
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
            'accept_type' => 'Accept Type',
        ];
    }
    /*public function beforeSave($insert) {
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
    }*/
}
