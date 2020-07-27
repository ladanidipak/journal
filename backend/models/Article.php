<?php

namespace backend\models;

use backend\components\PritSms;
use backend\components\PritWriteImage;
use backend\components\PritWriteImagick;
use backend\vendors\Common;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property integer $paper_id
 * @property integer $conf_id
 * @property integer $reviewer_id
 * @property string $article_title
 * @property string $research_area
 * @property integer $a_type_id
 * @property integer $branch_id
 * @property string $branch_name
 * @property string $keyword
 * @property string $abstract
 * @property string $author_name
 * @property string $a_org
 * @property string $a_email
 * @property string $a_phone
 * @property string $addr_1
 * @property string $addr_2
 * @property string $city
 * @property string $zip
 * @property string $state
 * @property string $country
 * @property string $article_file
 * @property string $article_review
 * @property string $plagiarism
 * @property string $payment_file
 * @property string $copyright_file
 * @property integer $hardcopy
 * @property integer $formatter_id
 * @property integer $formatted_file
 * @property integer $status
 * @property integer $file_path
 * @property integer $source
 * @property integer $source_specify
 * @property integer $r_request_sent
 * @property integer $sent_for_review
 * @property integer $reviewer_copy
 * @property integer $ar_id
 * @property integer $af_id
 * @property integer $is_submitted
 * @property integer $allow_certi
 * @property string $note
 * @property string $created_dt
 * @property integer $created_by
 * @property string $updated_dt
 * @property integer $updated_by
 * @property integer $is_deleted
 */
class Article extends \yii\db\ActiveRecord
{
    /* Status Array all are interconnected change in all if you need in one */
    public static $statusArray = ['1' => 'Received', '3' => 'Reviewed', '5' => 'Accepted', '6' => 'Rejected', '7' => 'Payment Done', '10' => 'Payment Accepted',
        '13' => 'Sent to Formatter', '15' => 'Format Done', '20' => 'Published'];
    public static $statusArrayToAuthor = ['1' => 'Received', '3' => 'Received', '5' => 'Accepted', '6' => 'Rejected', '7' => 'Accepted', '10' => 'Accepted',
        '13' => 'Accepted', '15' => 'Accepted', '20' => 'Published'];
    public static $confStatusArray = ['1' => 'Received', '13' => 'Sent to Formatter', '15' => 'Format Done', '20' => 'Published'];
    /* Status Array all are interconnected change in all if you need in one */


    public static $paymentMethod = [
        '0' => 'Upload payment proof <br>(if paid by deposit then receipt photo,if by NetBanking, Paytm or NEFT then screenshot of transaction )',
        '1' => 'Online <br>(if payment is not done and you want to make online payment right now)'
    ];
    //public static $sourceArray = ['Facebook', 'Google', 'Twitter', 'Reference by a Friend', 'Newspaper'];
    public static $sourceArray = ['Social media campaign (facebook, twitter, Google plus etc.)', 'Advertisements on the web', 'Reference by a friend', 'References by professor', 'Search engines (Google, Bing, Yahoo etc.)', 'Call for paper email, brochures', 'Other'];
    //public static $paymentMethod = ['1'=>'Online Payement', '0' => 'Upload Payment Receipt'];
    public $verifyCode;
    public $review_q;
    public $reviewer_sent_ids;
    public $formatter_sent_ids;

    public static function getStatusArray()
    {
        return self::$statusArray;
    }

    public static function getConfStatusArray(){
        return self::$confStatusArray;
    }

    public static function getPaymentMethod()
    {
        return self::$paymentMethod;
    }

    public static function getSourceArray($value)
    {
        $array = array_combine(self::$sourceArray,self::$sourceArray);
        if(!empty($value)) $array[$value] = $value;
        return $array;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    public static function createArticle($id = null, $type=null)
    {
        if ($id) {
            $model = Article::find()->where(['id' => $id])->one();
            $model->scenario = ($type == 'conf'?'updateConf':'updateVol');
            $oldFile = $model->article_file;
        } else {
            $model = new Article();
            $model->scenario = ($type == 'conf'?'createConf':"createVol");
        }

        if ($id) {
            $coaArray = \backend\models\Coauthor::find()->where(['article_id' => $id])->all();
            $coa = [
                'coa1' => new \backend\models\Coauthor(),
                'coa2' => new \backend\models\Coauthor(),
                'coa3' => new \backend\models\Coauthor(),
                'coa4' => new \backend\models\Coauthor(),
            ];
            $i = 0;
            foreach ($coaArray as $coau) {
                $i++;
                $coa['coa' . $i] = $coau;
            }
        } else {
            $coa = [
                'coa1' => new \backend\models\Coauthor(),
                'coa2' => new \backend\models\Coauthor(),
                'coa3' => new \backend\models\Coauthor(),
                'coa4' => new \backend\models\Coauthor(),
            ];
        }

        Model::loadMultiple($coa, Yii::$app->request->post()) && Model::validateMultiple($coa);

        if ($model->load(Yii::$app->request->post())) {
            if($type == 'conf' && !IS_GRD_ADMIN){
                $model->is_submitted = 0;
                $model->conf_id = $_SESSION['active_conf']['id'];
            }
            if ($id) {
                $uploadedFile = \yii\web\UploadedFile::getInstance($model, 'article_file');
                if ($uploadedFile) {
                    $filepath = substr($oldFile, 0, strrpos($oldFile, '/') + 1);
                    $model->article_file = $uploadedFile;
                    $model->article_file->name = $filepath . "{$model->paper_id}_received_file_". time() . '.' . $model->article_file->extension;
                } else {
                    unset($model->article_file);
                }
            } else {

                if($type == 'conf'){
                    $paperDetail = $model->generatePaperDetail('GRDCF',$model->conf_id);
                    $model->voliss_id = 0;
                    $conference = $paperDetail['conference'];
                } else {
                    $paperDetail = $model->generatePaperDetail();
                    $model->voliss_id = $paperDetail['voliss_id'];
                    $model->conf_id = 0;
                    $currentIssue = $paperDetail['currentIssue'];
                }
                $model->paper_id = $paperDetail['id'];
                $filepath = $paperDetail['filePath'];
                $model->file_path = $filepath;
                $model->article_file = \yii\web\UploadedFile::getInstance($model, 'article_file');
                $model->article_file->name = $filepath . time() . "_" . Common::clean($model->article_file->name);
            }

            $mReturn = $id ? $model->update() : $model->save();
            
            
            if ($mReturn) {
                foreach ($coa as $coap) {
                    $coap->article_id = $model->id;
                    $coap->scenario = 'single';
                    if ($coap->validate()) {
                        $coap->isNewRecord ? $coap->save() : $coap->update();
                    } elseif(empty($coap->name) && empty($coap->org) && empty($coap->email)){
                        $coap->delete();
                    }
                }
                if ($id) {
                    if ($uploadedFile) {
                        $uploadDir = ($type == 'conf')? "conference":"article";
                        $model->article_file->saveAs(DOCPATH . "/uploads/$uploadDir/" . $filepath . $model->article_file->baseName . '.' . $model->article_file->extension);
                    }
                    Yii::$app->session->setFlash('success', common::translateText("UPDATE_SUCCESS"));
                } else {
                    if($type =='conf'){
                        $updateArticleNo = Conference::udpateArticle($conference);
                        $updateArticleNo = sprintf("%03d", $updateArticleNo);
                        $model->paper_id = $model->paper_id.$updateArticleNo;
                        $filepath = $filepath.$updateArticleNo. "/";
                        $createDir = Common::checkAndCreateDirectory(DOCPATH . "/uploads/conference/" . $filepath);
                        $newFilePath = DOCPATH . "/uploads/conference/" . $filepath . "{$model->paper_id}_received_file_". time() . '.' . $model->article_file->extension;
                        $newFileUrl = $filepath . "{$model->paper_id}_received_file_". time() . '.' . $model->article_file->extension;
                        $model->article_file->saveAs($newFilePath);
                    } else {
                        $updateArticleNo = VolIss::udpateArticle($currentIssue);
                        $updateArticleNo = sprintf("%04d", $updateArticleNo);
                        $model->paper_id = $model->paper_id.$updateArticleNo;
                        $filepath = $filepath.$updateArticleNo. "/";
                        $createDir = Common::checkAndCreateDirectory(DOCPATH . "/uploads/article/" . $filepath);
                        $newFilePath = DOCPATH . "/uploads/article/" . $filepath . "{$model->paper_id}_received_file_". time() . '.' . $model->article_file->extension;
                        $newFileUrl = $filepath . "{$model->paper_id}_received_file_". time() . '.' . $model->article_file->extension;
                        $model->article_file->saveAs($newFilePath);
                    }


                    $model->article_file =$newFileUrl;
                    $model->file_path = $filepath;
                    $model->updateAttributes(['paper_id','article_file', 'file_path']);
                    if($type != 'conf'){
                        PritMailer::submitArticle(['model' => $model, 'coa' => $coa]);
                        @PritSms::submitted(['model' => $model]);
                    }
                    Yii::$app->session->setFlash('success', 'You have successfully submitted an Article');
                }
                return true;
            } else {
                $message = Yii::$app->mailer->compose()
                    ->setFrom(Yii::$app->params['fromEmail'])
                    ->setTo('pritesh966@gmail.com')
                    ->setSubject('GrdJournals: Article Submission Error')
                    ->setHtmlBody('<pre>'.print_r([$model->getErrors(), $_POST, $_FILES], true).'</pre>')
                    ->send();
            }
        }
        return ['model' => $model, 'coa' => $coa];
    }

    public static function generatePaperDetail($slug = "GRDJE", $conf_id = null)
    {

        if($slug == "GRDCF"){
            $confId = sprintf("%03d", $conf_id);
            if(strlen($conf_id) > 3){
                $confId = sprintf("%04d", $conf_id);
            }
            $paperId = $slug . $confId;
            $filepath = $slug . "/" . $confId . "/" ;
            $conference = Conference::findOne($conf_id);
            return ['id' => $paperId, 'filePath' => $filepath, 'conference' => $conference];
        }else{
            $currentIssue = VolIss::findCurrentIssue();
            $slug = "GRDJE";
            $volume = "V" . sprintf("%02d", $currentIssue->volume);
            $issue = "I" . sprintf("%02d", $currentIssue->issue);
            $paperId = $slug . $volume . $issue;
            $filepath = $slug . "/" . $volume . "/" . $issue . "/" ;
            return ['id' => $paperId, 'filePath' => $filepath, 'voliss_id' => $currentIssue->id, 'currentIssue' => $currentIssue];
        }

        /**
         * $updateArticleNo = \backend\models\VolIss::udpateArticle($currentIssue);
        $article = sprintf("%04d", $currentIssue->articles);
        $paperId = $slug . $volume . $issue . $article;
        $article = uniqid();
         **/
    }

    public static function generateCertificates($article,$url = false)
    {
        $title = $article->article_title;
        //$title = "Article Title is too long. Please manually create certificate and send to author. create certificate and send to author. ";
        $title = wordwrap($title,75,'@#@');
        $titleArray = explode('@#@',$title);
        $count = count($titleArray);
        $printTitle = [];
        if($count > 3){
            echo "Article Title is too long. Please manually create certificate and send to author.";exit;
        } elseif ($count == 1){
            $printTitle[] =['name'=>$title,'x'=>'center','y'=>1555,'font_size'=>80];
        }elseif($count == 2){
            /*$capLength =  strlen($titleArray[0]) - strlen(preg_replace('![A-Z]+!', '', $titleArray[0]));
            if($capLength > 25){ $f_size_2 = 50; }
            else{ $f_size_2 = 60; }
            $printTitle[] =['name'=>$titleArray[0],'x'=>'center','y'=>1525,'font_size'=>$f_size_2];
            $printTitle[] =['name'=>$titleArray[1],'x'=>'center','y'=>1605,'font_size'=>$f_size_2];*/
            $printTitle[] = ['name'=>[
                ['name'=>$titleArray[0],'y'=>1525],
                ['name'=>$titleArray[1],'y'=>1605]
            ],'x'=>'center','font_size'=>80];
        }elseif($count == 3){
            /*$printTitle[] =['name'=>$titleArray[0],'x'=>'center','y'=>1500,'font_size'=>45];
            $printTitle[] =['name'=>$titleArray[1],'x'=>'center','y'=>1580,'font_size'=>45];
            $printTitle[] =['name'=>$titleArray[2],'x'=>'center','y'=>1650,'font_size'=>45];*/
            $printTitle[] = ['name'=>[
                ['name'=>$titleArray[0],'y'=>1500],
                ['name'=>$titleArray[1],'y'=>1580],
                ['name'=>$titleArray[2],'y'=>1650]
            ],'x'=>'center','font_size'=>65];
        }
        $authors[] = $article->author_name;
        foreach($article->coauthors as $coa){
            if($coa->name)
                $authors[] = $coa->name;
        }
        $vol = "Volume {$article->voliss->volume}, Issue {$article->voliss->issue}, in {$article->voliss->detail}";
        $root_path = DOCPATH . "/uploads/article/" . $article->file_path;
        $rool_url = DOCURL . "uploads/article/" . $article->file_path;
        $file_path = $root_path."certificates";
        if(is_dir($file_path)){
            Common::removeDir($file_path);
            @unlink($file_path.".zip");
        }

        Common::checkAndCreateDirectory($file_path);
        $count = 1;
        foreach($authors as $author){
            $textArray = array_merge($printTitle,[
                ['name'=>'ISSN [ONLINE] : 2455 - 5703','x'=>2870,'y'=>330,'font_size'=>55],
                ['name'=>$article->paper_id,'x'=>2900,'y'=>580,'font_size'=>190, 'font'=>DOCPATH.'/uploads/certificate/barcode.ttf'],
                ['name'=>$author,'x'=>'center','y'=>1325,'font_size'=>80],
                ['name'=>$vol,'x'=>'center','y'=>1860,'font_size'=>95,'font'=>DOCPATH.'/uploads/certificate/impact.ttf']
            ]);
            $data = ['inputPath'=>DOCPATH."/uploads/certificate/author_feb_2_remove.jpg",'outputPath'=>$file_path."/".Common::clean($author).$count.".jpg",
                'text'=>$textArray];
            $image = new PritWriteImagick($data);
            $image->create_image();
            /*$fpath = $rool_url."certificates/".Common::clean($author).$count.".jpg";
            echo "<img src='$fpath'>";exit;*/
            $count++;
        }
        Common::directoryToZip($root_path.'certificates.zip',$file_path);
        if($url){
            return $rool_url.'certificates.zip';
        }else{
            return $root_path.'certificates.zip';
        }
    }

    public static function generateConfCertificates($article,$url = false)
    {
        $title = $article->article_title;
        //$title = "Article Title is too long. Please manually create certificate and send to ";
        $title = wordwrap($title,75,'@#@');
        $titleArray = explode('@#@',$title);
        $count = count($titleArray);
        $printTitle = [];
        if($count > 3){
            echo "Article Title is too long. Please manually create certificate and send to author.";exit;
        } elseif ($count == 1){
            $printTitle[] =['name'=>$title,'x'=>'center','y'=>1455,'font_size'=>80, 'font'=>DOCPATH.'/uploads/certificate/times_bold_italic.ttf'];
        }elseif($count == 2){
            /*$capLength =  strlen($titleArray[0]) - strlen(preg_replace('![A-Z]+!', '', $titleArray[0]));
            if($capLength > 25){ $f_size_2 = 50; }
            else{ $f_size_2 = 60; }
            $printTitle[] =['name'=>$titleArray[0],'x'=>'center','y'=>1425,'font_size'=>$f_size_2, 'font'=>DOCPATH.'/uploads/certificate/times_bold_italic.ttf'];
            $printTitle[] =['name'=>$titleArray[1],'x'=>'center','y'=>1505,'font_size'=>$f_size_2, 'font'=>DOCPATH.'/uploads/certificate/times_bold_italic.ttf'];*/
            $printTitle[] = ['name'=>[
                ['name'=>$titleArray[0],'y'=>1425],
                ['name'=>$titleArray[1],'y'=>1505],
            ],'x'=>'center','font_size'=>80, 'font'=>DOCPATH.'/uploads/certificate/times_bold_italic.ttf'];
        }elseif($count == 3){
            /*$printTitle[] =['name'=>$titleArray[0],'x'=>'center','y'=>1400,'font_size'=>45, 'font'=>DOCPATH.'/uploads/certificate/times_bold_italic.ttf'];
            $printTitle[] =['name'=>$titleArray[1],'x'=>'center','y'=>1480,'font_size'=>45, 'font'=>DOCPATH.'/uploads/certificate/times_bold_italic.ttf'];
            $printTitle[] =['name'=>$titleArray[2],'x'=>'center','y'=>1550,'font_size'=>45, 'font'=>DOCPATH.'/uploads/certificate/times_bold_italic.ttf'];*/
            $printTitle[] = ['name'=>[
                ['name'=>$titleArray[0],'y'=>1400],
                ['name'=>$titleArray[1],'y'=>1480],
                ['name'=>$titleArray[2],'y'=>1550]
            ],'x'=>'center','font_size'=>65, 'font'=>DOCPATH.'/uploads/certificate/times_bold_italic.ttf'];
        }
        $published = "Published In ".date('F, Y',strtotime($article->conference->pub_date));
        $confTitle = "In Conference, recognition and appreciation of research Contribution to";
        $authors[] = $article->author_name;
        foreach($article->coauthors as $coa){
            if($coa->name)
                $authors[] = $coa->name;
        }
        $conf = $article->conference->title;
        $confShort = $article->conference->short_name;
        $root_path = DOCPATH . "/uploads/conference/" . $article->file_path;
        $rool_url = DOCURL . "uploads/conference/" . $article->file_path;
        $file_path = $root_path."certificates";
        if(is_dir($file_path)){
            Common::removeDir($file_path);
            @unlink($file_path.".zip");
        }

        Common::checkAndCreateDirectory($file_path);
        $count = 1;
        foreach($authors as $author){
            $textArray = array_merge($printTitle,[
                ['name'=>'ISSN [ONLINE] : 2455 - 5703','x'=>600,'y'=>195,'font_size'=>55],
                ['name'=>$article->paper_id,'x'=>570,'y'=>440,'font_size'=>195, 'font'=>DOCPATH.'/uploads/certificate/barcode.ttf'],
                ['name'=>$author,'x'=>'center','y'=>1125,'font_size'=>90, 'font'=>DOCPATH.'/uploads/certificate/times_bold_italic.ttf'],
                ['name'=>$conf,'x'=>'center','y'=>1790,'font_size'=>85, 'font'=>DOCPATH.'/uploads/certificate/times_bold_italic.ttf'],
                ['name'=>"($confShort)",'x'=>'center','y'=>1880,'font_size'=>90, 'font'=>DOCPATH.'/uploads/certificate/times_bold_italic.ttf'],
                ['name'=>$published, 'x'=>'center','y'=>2100,'font_size'=>120, 'font'=>DOCPATH.'/uploads/certificate/times_bold_italic.ttf'],
                ['name'=>$confTitle, 'x'=>'center','y'=>1670,'font_size'=>90, 'font'=>DOCPATH.'/uploads/certificate/times_italic.ttf'],
            ]);
            $data = ['inputPath'=>DOCPATH."/uploads/certificate/conference_blank_remove.jpg",'outputPath'=>$file_path."/".Common::clean($author).$count.".jpg",
                'text'=>$textArray];
            $image = new PritWriteImagick($data);
            $image->create_image();
            /*$fpath = $rool_url."certificates/".Common::clean($author).$count.".jpg";
            echo "<img src='$fpath'>";exit;*/
            $count++;
        }
        Common::directoryToZip($root_path.'certificates.zip',$file_path);
        if($url){
            return $rool_url.'certificates.zip';
        }else{
            return $root_path.'certificates.zip';
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //general
            [[ 'paper_id',  'article_title', 'a_type_id', 'branch_id', 'author_name'], 'required'],
            ['branch_name', 'required', 'whenClient' => "function (attribute, value) {return $('#article-branch_id option:selected').text() == 'Other';}", 'when' => function ($model) {
                return false;
            }],
            [['!is_submitted','!allow_certi','a_type_id', 'reviewer_id', 'branch_id', 'status', 'created_by', 'updated_by', 'is_deleted', 'paid_online', 'hardcopy', 'formatter_id'], 'integer'],
            [['abstract','reference'], 'string'],
            [['created_dt', 'updated_dt', 'article_review', 'file_path', 'reviewer_copy', 'formatter_sent_ids'], 'safe'],
            [['note','article_title', 'research_area', 'branch_name', 'keyword', 'author_name', 'addr_1', 'addr_2'], 'string', 'max' => 255],
            [['a_org', 'a_email', 'city', 'state', 'country', 'source_specify'], 'string', 'max' => 100],
            [['paper_id'], 'string', 'max' => 50],
            [['a_email'], 'email'],
            [['a_phone'], 'string', 'max' => 10],
            [['zip'], 'string', 'max' => 6],
            [['a_phone'], 'match', 'pattern' => '/^[1-9][0-9]{9}$/', 'message' => "Author Phone will be 10 digit number without country code like '9876543210'. Do not start Author Phone with '0'."],

            //createConf
            [['conf_id','a_email'],'required','on'=>['createConf','updateConf']],
            //createVol
            [['source','voliss_id','a_phone','addr_1', 'addr_2', 'city', 'zip', 'state', 'country', 'a_email', 'keyword', 'abstract', 'a_org' , 'research_area'], 'required','on'=>['createVol','updateVol']],
            ['verifyCode', 'required', 'when'=>function($model){return APP_PANEL == "frontend";},'on' => ["createVol", "copyright","paper_status","getpaydetail"]],
            ['verifyCode', 'captcha', 'when'=>function($model){return APP_PANEL == "frontend";}, 'captchaAction' => 'page/captcha', 'on' => ["createVol", "copyright","paper_status","getpaydetail"]],

            //other
            [['article_file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'doc, docx', 'maxSize' => 1024 * 1024 * 5, 'on' => ['createConf','createVol']],
            [['article_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc, docx', 'maxSize' => 1024 * 1024 * 5, 'on' => ['updateConf','updateVol']],
            [['reviewer_copy'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc, docx', 'maxSize' => 1024 * 1024 * 5, 'on' => ['review_email']],
            [['reviewer_copy'], 'file', 'skipOnEmpty' => false, 'extensions' => 'doc, docx', 'maxSize' => 1024 * 1024 * 5, 'on' => ['review_request_file']],

            [['payment_file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'doc, docx, png, jpeg, jpg, pdf', 'maxSize' => 1024 * 1024 * 5, 'on' => 'copyright', 'when' => function ($model) {
                return $model->paid_online == '0';
            }],
            [['copyright_file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'doc, docx, png, jpeg, jpg, pdf', 'maxSize' => 1024 * 1024 * 5, 'on' => ['copyright','copyright_backend','copyright_only']],
            //['payment_file', 'required', 'when' => function ($model) {return $model->desigDrop == 'Other';}, 'whenClient' => "function (attribute, value) {return $('#editorialboard-desigdrop').val() == 'Other';}"],
            [['formatter_id'], 'required', 'on' => 'format'],
            [['formatter_sent_ids'], 'required', 'on' => 'format_email'],
            [['sent_for_review','reviewer_sent_ids'], 'required', 'on' => 'review_email'],
            [['formatted_file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'doc, docx', 'maxSize' => 1024 * 1024 * 5, 'on' => 'fupload'],
            [['article_review'], 'required', 'on' => 'review'],
            [['plagiarism'], 'required', 'on' => 'add_plagiarism'],
            [['r_request_sent'], 'required', 'on' => 'review_request'],
            [['formatted_file','formatted_date','af_id','formatter_id'], 'required', 'on' => 'accept_formatter'],
            [['paper_id','a_email'], 'required', 'on' => 'getpaydetail'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'paper_id' => 'Paper ID',
            'reviewer_id' => 'Reviewer',
            'voliss_id' => 'Volume-Issue',
            'article_title' => 'Article Title',
            'research_area' => 'Research Area',
            'a_type_id' => 'Article Type',
            'branch_id' => 'Branch',
            'branch_name' => 'Branch Name',
            'keyword' => 'Keyword',
            'abstract' => 'Abstract',
            'author_name' => 'Author Name',
            'a_org' => 'Author Institute/Organization',
            'a_email' => 'Author Email',
            'a_phone' => 'Author Phone',
            'addr_1' => 'Line 1',
            'addr_2' => 'Line 2',
            'city' => 'City',
            'zip' => 'Zip',
            'state' => 'State',
            'country' => 'Country',
            'article_file' => 'Article File',
            'article_review' => 'Article Review',
            'copyright_file' => 'Copyrights Soft Copy',
            'payment_file' => 'Payment Soft Copy',
            'paid_online' => 'Paid Online',
            'status' => 'Status',
            'hardcopy' => 'Hardcopy Needed?',
            'formatter_id' => 'Formatter',
            'file_path' => 'File Path',
            'source' => 'How do you came to know about us?',
            'source_specify' => 'Source Specify',
            'created_dt' => 'Created Dt',
            'created_by' => 'Created By',
            'updated_dt' => 'Updated Dt',
            'updated_by' => 'Updated By',
            'is_deleted' => 'Is Deleted',
            'allow_certi' => 'Allow Certificate',
        ];
    }

    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }

    public function getType()
    {
        return $this->hasOne(search\ArticleType::className(), ['id' => 'a_type_id']);
    }

    public function getFormatter()
    {
        return $this->hasOne(Formatter::className(), ['id' => 'formatter_id']);
    }

    public function getReviewer()
    {
        return $this->hasOne(EditorialBoard::className(), ['id' => 'reviewer_id']);
    }

    public function getCoauthors()
    {
        return $this->hasMany(Coauthor::className(), ['article_id' => 'id']);
    }

    public function getVoliss()
    {
        return $this->hasOne(VolIss::className(), ['id' => 'voliss_id']);
    }

    public function getConference()
    {
        return $this->hasOne(Conference::className(), ['id' => 'conf_id']);
    }

    public function getPublished()
    {
        return $this->hasOne(Published::className(), ['article_id' => 'id'])->where(['is_deleted'=>0]);
    }

    public function getReviewRequests(){
        return $this->hasMany(ReviewRequest::className(),['article_id'=>'id']);
    }

    public function getSentRequests(){
        return $this->hasMany(ArticleReview::className(),['article_id'=>'id']);
    }

    public function getFormatRequests(){
        return $this->hasMany(ArticleFormat::className(),['article_id'=>'id']);
    }

    public function getHardcopyRel(){
        return $this->hasOne(Hardcopy::className(),['article_id'=>'id'])->from(['hardcopyRel'=>'hardcopy']);
    }

    public function getRequestedReviewer(){
        $names = "";
        $reviewers = $this->reviewRequests;

        if($reviewers){
            $rIds = ArrayHelper::map($reviewers,'id','reviewer_id');
            $sIds = ArrayHelper::map($reviewers,'id','review_status');

            $r_names = EditorialBoard::find()->select('id,full_name')->where(['id'=>$rIds])->asArray()->all();
            $r_names = ArrayHelper::map($r_names,'id','full_name');
            $retName  = [];

            foreach($rIds as $rKey=>$reviewer){
                if($sIds[$rKey] == 1){
                    $retName []= $r_names[$reviewer]."(<i class='fa fa-check'></i>)";
                } elseif($sIds[$rKey] == 2){
                    $retName []= $r_names[$reviewer]."(<i class='fa fa-times'></i>)";
                } else {
                    $retName []= $r_names[$reviewer];
                }
            }

            if($retName){
                $names = implode(', ',$retName);
            }
        }
        return $names;
    }

    public function getSentReviewer(){
        $names = "";
        $reviewers = $this->sentRequests;
        if($reviewers){
            $rIds = [];
            $reviewCounter = 0;
            foreach($reviewers as $reviewer){
                $rIds[] = $reviewer->reviewer_id;
                if($reviewer->reviewed_date) $reviewCounter++;
            }
            $names = EditorialBoard::find()->select('full_name')->where(['id'=>$rIds])->column();
            if($names){
                $names = implode(', ',$names) . " (" . $reviewCounter ." / " . count($reviewers) . ")";
            }
        }
        return $names;
    }

    public function getSentFormatters(){
        $names = "";
        $formatters = $this->formatRequests;
        if($formatters){
            $fIds = [];
            $formatCount = 0;
            foreach($formatters as $formatter){
                $fIds[] = $formatter->formatter_id;
                if($formatter->formatted_date) $formatCount++;
            }
            $names = Formatter::find()->select('name')->where(['id'=>$fIds])->column();
            if($names){
                $names = implode(', ',$names) . " (" . $formatCount ." / " . count($formatters) . ")";;
            }
        }
        return $names;
    }

    public function beforeSave($insert)
    {
        $loggedIn = \Yii::$app->user->isGuest;
        if (parent::beforeSave($insert)) {
            $this->updated_dt = date('Y-m-d H:i:s');
            $this->updated_by = ($loggedIn) ? 0 : Yii::$app->user->identity->id;
            if ($insert) {
                $this->created_dt = date('Y-m-d H:i:s');
                $this->created_by = ($loggedIn) ? 0 : Yii::$app->user->identity->id;
            }
            return true;
        } else {
            return false;
        }
    }

    public static function generateStats(){

    }

}
