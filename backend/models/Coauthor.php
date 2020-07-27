<?php

namespace backend\models;

use Yii;
use backend\vendors\Common;

/**
 * This is the model class for table "coauthor".
 *
 * @property integer $id
 * @property integer $article_id
 * @property string $name
 * @property string $org
 * @property string $email
 */
class Coauthor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coauthor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'name', 'org', 'email'], 'safe'],
            [['article_id', 'name'], 'required','on'=>'single'],
            [['article_id'], 'integer'],
            [['email'],'email'],
            [['name', 'org', 'email'], 'string', 'max' => 100]
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
            'name' => 'Name',
            'org' => 'Org',
            'email' => 'Email',
        ];
    }
    
}
