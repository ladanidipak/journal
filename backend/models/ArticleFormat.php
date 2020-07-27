<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_format".
 *
 * @property integer $id
 * @property integer $article_id
 * @property integer $formatter_id
 * @property string $formatted_file
 * @property string $formatted_date
 * @property string $created_dt
 * @property integer $created_by
 * @property integer $is_deleted
 */
class ArticleFormat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_format';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'formatter_id'], 'required','on'=>['create']],
            [['formatted_file', 'formatted_date'], 'required','on'=>['submit_file']],
            [['article_id', 'formatter_id', 'created_by', 'is_deleted'], 'integer'],
            [['formatted_file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'doc, docx', 'maxSize' => 1024 * 1024 * 5, 'on' => 'submit_file'],
            [['formatted_date', 'created_dt'], 'safe']
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
            'formatter_id' => 'Formatter ID',
            'formatted_file' => 'Formatted File',
            'formatted_date' => 'Formatted Date',
            'created_dt' => 'Created Dt',
            'created_by' => 'Created By',
            'is_deleted' => 'Is Deleted',
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

    public function getFormatter(){
        return $this->hasOne(Formatter::className(),['id'=>'formatter_id']);
    }

    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    public static function acceptArticle($ar, $article){

        $article->scenario = 'accept_formatter';
        if($article->conf_id == 0){
            $fileDir = "article";
        } else {
            $fileDir = "conference";
        }
        $position = strrpos($ar->formatted_file,".");
        $fileExtension = substr($ar->formatted_file,$position);
        $fileName = $article->paper_id."_formatted_file_". time() .$fileExtension;
        if(copy(DOCPATH."/uploads/format_request/".$ar->formatted_file, DOCPATH."/uploads/$fileDir/".$article->file_path.$fileName)){
            chmod(DOCPATH."/uploads/$fileDir/".$article->file_path.$fileName,0777);
            $article->formatted_file = $article->file_path.$fileName;
            if(in_array($article->status,[13,15])){
                $article->status = 15;
            }else{
                $article->status = $article->status;
            }

            $article->formatter_id = $ar->formatter_id;
            $article->formatted_date = $ar->formatted_date;
            $article->af_id = $ar->id;
            if($article->update() !== false){
                return true;
            }
        }
        return false;
    }


}
