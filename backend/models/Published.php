<?php

namespace backend\models;

use Yii;
use backend\vendors\Common;

/**
 * This is the model class for table "published".
 *
 * @property integer $id
 * @property integer $article_id
 * @property string $paper_id
 * @property string $title
 * @property string $authors
 * @property string $country
 * @property string $abstract
 * @property string $reference
 * @property string $keywords
 * @property integer $start_page
 * @property integer $end_page
 * @property string $pub_date
 * @property string $pdf
 * @property string $google_scholar
 * @property integer $status
 * @property string $created_dt
 * @property integer $created_by
 * @property string $updated_dt
 * @property integer $updated_by
 * @property integer $is_deleted
 */
class Published extends \yii\db\ActiveRecord
{
    //If you want to make following questions fancy then think about edit review key option
    public static $reviewQuestions = [
        'Title construction of manuscript was good',
        'Introduction covers each part of work done area Introduction covers all required thorough',
        'Knowledge to understand the topic',
        'Material method was given with company detail',
        'All materials were covered which was used in that work',
        'Method was describe in details',
        'Method was describe with quantity of materials used in that work',
        'Result was discussed thoroughly to understand the effect of work',
        'Result was discussed with mathematical model Application',
        'Acknowledgement was described all help which was received during the work',
        'I do not have any objection if this work was published in this journal',
    ];
    public static $reviewAnswers = [
        'Fully Agree','Agree','Partial Agree', 'Disagree', 'Not Necessary'
    ];

    public static $recommendation = [
      'This paper represents a significant new contribution and should be published as is.',
      'This paper is publishable subject to minor revisions noted. Further review is not needed.',
      'This paper is probably publishable, but major revision is needed.',
      'This paper is not recommended because it does not provide new physical insights.',
    ];

    public static $article_ratting = [
        'Very significant (top 10%)',
        'Significant (top 10-25%)',
        'Routine (top 25-50%)',
        'Poor/Unacceptable (bottom 50%)',
    ];

    public static $re_review_question = "If you have indicated that the article should be reconsidered after revision, do you need to re-review the scientific aspect of the revised article?";

    public static $revision_text = [
        'Accept',
        'Minor Revision',
        'Major Revision',
        'Reject and Resubmit',
        'Reject',
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'published';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'authors', 'country', 'abstract', 'keywords', 'start_page', 'end_page', 'pub_date'], 'required'],
            [['pdf'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf','maxSize'=>1024*1024*5,'on'=>'create'],
            [['pdf'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf','maxSize'=>1024*1024*5,'on'=>'update'],
            [['start_page', 'end_page', 'status', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['abstract','reference'], 'string'],
            [['pub_date', 'created_dt', 'updated_dt'], 'safe'],
            [['title', 'keywords'], 'string', 'max' => 255],
            [['authors','google_scholar'], 'string', 'max' => 1000],
            [['country'], 'string', 'max' => 75]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article',
            'paper_id' => 'Paper ID',
            'title' => 'Title',
            'authors' => 'Authors',
            'country' => 'Country',
            'abstract' => 'Abstract',
            'reference' => 'Reference',
            'keywords' => 'Keywords',
            'start_page' => 'Start Page',
            'end_page' => 'End Page',
            'pub_date' => 'Publication Date',
            'pdf' => 'Pdf',
            'google_scholar' => 'Google Scholar Link',
            'status' => 'Status',
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
    
    public function getArticle(){
        return $this->hasOne(Article::className(), ['id'=>'article_id']);
    }
}
