<?php

namespace backend\models;

use backend\components\PritWriteImage;
use backend\components\PritWriteImagick;
use Yii;
use backend\vendors\Common;

/**
 * This is the model class for table "article_review".
 *
 * @property integer $id
 * @property integer $article_id
 * @property integer $reviewer_id
 * @property integer $status
 * @property string $article_review
 * @property string $reviewed_date
 * @property string $created_date
 * @property integer $created_by
 * @property integer $is_deleted
 * @property integer $certi_status
 */
class ArticleReview extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_review';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'reviewer_id'], 'required','on'=>['create']],
            [['article_review', 'reviewed_date'], 'required','on'=>['submit_review']],
            [['article_id', 'reviewer_id', 'created_by', 'is_deleted','status', 'certi_status'], 'integer'],
            [['article_review'], 'string'],
            [['reviewed_date', 'created_dt','status'], 'safe']
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
            'article_review' => 'Article Review',
            'reviewed_date' => 'Reviewed Date',
            'created_dt' => 'Sent Date',
            'created_by' => 'Created By',
            'is_deleted' => 'Is Deleted',
            'certi_status' => 'Certificate Status',
        ];
    }
    public function beforeSave($insert) {
        $loggedIn = \Yii::$app->user->isGuest;
        if (parent::beforeSave($insert)) {
            if($insert){
                $this->created_dt = date('Y-m-d H:i:s');
                $this->created_by = ($loggedIn) ? 0 : Yii::$app->user->identity->id;
            }
            return true;
        } else {
            return false;
        }
    }

    public function getReviewer()
    {
        return $this->hasOne(EditorialBoard::className(), ['id' => 'reviewer_id']);
    }

    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    public static function generateCertificates($ar,$url = false)
    {
        $article = $ar->article;
        $reviewer = $ar->reviewer;
        $name = ucwords(strtolower($reviewer->full_name));
        $review_text = "for providing contribution in review of the article entitled";
        $vol = "in {$article->voliss->detail}";
        $title = $article->article_title;
        //$title = "Article Title is too long. Please manually create certificate and send to author. create certificate and send to author. ";
        $title = wordwrap($title,75,'@#@');
        $titleArray = explode('@#@',$title);
        $count = count($titleArray);
        $printTitle = [];
        if($count > 3){
            //echo "Article Title is too long. Please manually create certificate and send to reviewer. If you are a reviewer,then inform us about this issue.";exit;
            return false;
        } elseif ($count == 1){
            $printTitle[] =['name'=>$title, 'x'=>'center','y'=>1850,'font_size'=>95,'font'=>DOCPATH.'/uploads/certificate/times_bold.ttf'];
        }elseif($count == 2){
            /*$capLength =  strlen($titleArray[0]) - strlen(preg_replace('![A-Z]+!', '', $titleArray[0]));
            if($capLength > 25){ $f_size_2 = 85; }
            else{ $f_size_2 = 95; }
            $printTitle[] =['name'=>$titleArray[0],'x'=>'center','y'=>1810,'font_size'=>$f_size_2,'font'=>DOCPATH.'/uploads/certificate/times_bold.ttf'];
            $printTitle[] =['name'=>$titleArray[1],'x'=>'center','y'=>1890,'font_size'=>$f_size_2,'font'=>DOCPATH.'/uploads/certificate/times_bold.ttf'];*/
            $printTitle[] = ['name'=>[
                ['name'=>$titleArray[0],'y'=>1810],
                ['name'=>$titleArray[1],'y'=>1890]
            ],'x'=>'center','font_size'=>95,'font'=>DOCPATH.'/uploads/certificate/times_bold.ttf'];
        }elseif($count == 3){
            /*$capLength =  strlen($titleArray[0]) - strlen(preg_replace('![A-Z]+!', '', $titleArray[0]));
            if($capLength > 25){ $f_size_3 = 85; }
            else{ $f_size_3 = 95; }
            $printTitle[] =['name'=>$titleArray[0],'x'=>'center','y'=>1770,'font_size'=>$f_size_3,'font'=>DOCPATH.'/uploads/certificate/times_bold.ttf'];
            $printTitle[] =['name'=>$titleArray[1],'x'=>'center','y'=>1860,'font_size'=>$f_size_3,'font'=>DOCPATH.'/uploads/certificate/times_bold.ttf'];
            $printTitle[] =['name'=>$titleArray[2],'x'=>'center','y'=>1950,'font_size'=>$f_size_3,'font'=>DOCPATH.'/uploads/certificate/times_bold.ttf'];*/
            $printTitle[] = ['name'=>[
                ['name'=>$titleArray[0],'y'=>1770],
                ['name'=>$titleArray[1],'y'=>1860],
                ['name'=>$titleArray[2],'y'=>1950]
            ],'x'=>'center','font_size'=>95,'font'=>DOCPATH.'/uploads/certificate/times_bold.ttf'];
        }

        $root_path = DOCPATH . "/uploads/ar_certi/";
        $rool_url = DOCURL . "uploads/ar_certi/";
        $file_path = $root_path."{$ar->id}";
        if(is_dir($file_path)){
            Common::removeDir($file_path);
            @unlink($file_path.".zip");
        }
        Common::checkAndCreateDirectory($file_path);
        $textArray = array_merge($printTitle,[
            //['name'=>'ISSN [ONLINE] : 2455 - 5703','x'=>2530,'y'=>330,'font_size'=>40],
            //['name'=>$reviewer_id,'x'=>2720,'y'=>570,'font_size'=>160, 'font'=>DOCPATH.'/uploads/certificate/barcode.ttf'],
            ['name'=>$name,'x'=>'center','y'=>1400,'font_size'=>200,'font'=>DOCPATH.'/uploads/certificate/Ephesis.ttf','angle'=>30],
            ['name'=>$review_text,'x'=>'center','y'=>1600,'font_size'=>120,'font'=>DOCPATH.'/uploads/certificate/times.ttf'],
            ['name'=>$vol,'x'=>'center','y'=>2200,'font_size'=>120,'font'=>DOCPATH.'/uploads/certificate/FLAMENN.ttf']
        ]);
        $data = ['inputPath'=>DOCPATH."/uploads/certificate/review_certi.jpg",'outputPath'=>$file_path."/".Common::clean($name).".jpg",
            'text'=>$textArray];
        $image = new PritWriteImagick($data);
        //$image = new PritWriteImage($data);
        $image->create_image();
        /*$fpath = $rool_url."{$ar->id}/".Common::clean($name).".jpg";
        echo "<img src='$fpath'>";exit;*/

        Common::directoryToZip($root_path."{$ar->id}/certificates.zip",$file_path);
        if($url){
            return $rool_url."{$ar->id}/certificates.zip";
        }else{
            return $root_path."{$ar->id}/certificates.zip";
        }
    }
}
