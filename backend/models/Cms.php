<?php

namespace app\models;

use Yii;
use backend\vendors\Common;

/**
 * This is the model class for table "cms".
 *
 * @property string $id
 * @property string $page_title
 * @property string $page_name
 * @property string $content
 * @property string $slug
 * @property string $meta_key
 * @property string $meta_description
 * @property integer $status
 * @property integer $is_deleted
 * @property integer $created_by
 * @property integer $created_dt
 * @property integer $updated_by
 * @property integer $updated_dt
 */
class Cms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $zero = 0;
    public static function tableName()
    {
        return 'cms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','page_title', 'content', 'slug', 'meta_key', 'meta_description'], 'required'],
            [['content'], 'string'],
            ['slug', 'match', 'pattern'=>'/^[a-z0-9-\/]+$/'],
            ['slug', 'unique', 'targetAttribute' => ['zero'=>'is_deleted','slug'=>'slug']],
            [['status', 'is_deleted', 'created_by', 'created_dt', 'updated_by', 'updated_dt'], 'integer'],
            [['page_title', 'page_name', 'slug', 'meta_key', 'meta_description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Do_Not_Change_This',
            'page_title' => 'Page Title',
            'page_name' => 'Page Name',
            'content' => 'Content',
            'slug' => 'Slug',
            'meta_key' => 'Meta Key',
            'meta_description' => 'Meta Description',
            'status' => 'Status',
            'is_deleted' => 'Is Deleted',
            'created_by' => 'Created By',
            'created_dt' => 'Created Dt',
            'updated_by' => 'Updated By',
            'updated_dt' => 'Updated Dt',
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
    
    public static function getContent($id,$cat = 0){
        $content = self::find()->where(['id'=>$id])->one();
        switch ($cat) {
            case 1:
                $content->content = '<div><div class="col-sm-12">'.$content->content.'</div></div>';
                break;
            default:
                $content->content = '<div class="row blog-post-area"><div class="col-sm-12 single-blog-post">'.$content->content.'</div></div>';
                break;
        }
        
        return $content;
    }
}


namespace backend\models;
class cms extends \app\models\Cms {};
