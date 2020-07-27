<?php

namespace app\controllers;

use backend\models\Article;
use backend\models\ArticleFormat;
use backend\models\ArticleReview;
use backend\models\Contact;
use backend\models\EditorialBoard;
use backend\models\PritMailer;
use backend\models\ReviewRequest;
use backend\models\ReviewRequestOld;
use Yii;
use yii\filters\VerbFilter;
use backend\vendors\Common;
use app\components\BaseController;
use yii\helpers\Json;
/**
 * SettingController implements the CRUD actions for Setting model.
 */
class OpenController extends BaseController
{
    public $layout = '/open';
    public function init() {
       
    }
    
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    
    /**
     * Lists all Setting models.
     * @return mixed
     */
    public function actionAfeedback($id)
    {
        $id  = Common::passdecrypt($id);
        if(is_numeric($id)){
            $article = \backend\models\Article::findOne(['id'=>$id]);
            $article->scenario = 'review';
            if($article->load(Yii::$app->request->post())){
                $comment = $article->article_review;
                $review = $_POST['review_q'];
                $review['comment'] = $comment;
                $article->article_review = Json::encode($review);
                $article->status = 3;
                if($article->update()){
                    Yii::$app->session->setFlash('success', 'Review Submitted Successfully');
                    return $this->refresh();
                }
            }
            return $this->render('afeedback', [
                'id' => $id,
                'article' => $article,
            ]);
        }
    }

    public function actionRfeedback($id)
    {
        $id  = Common::passdecrypt($id);
        $ids = explode("_",$id);
        $article_review = null;
        if(count($ids) == 2){
            $reviewer_id = $ids[0];
            $article_id = $ids[1];
            $article_review = ArticleReview::findOne(['reviewer_id'=>$reviewer_id, 'article_id'=>$article_id, 'is_deleted'=>0]);
        }else{
            $article_review = ArticleReview::findOne($id);
        }
        if($article_review){
            $article_review->scenario = 'submit_review';
            if($article_review->load(Yii::$app->request->post())){
                $comment = $article_review->article_review;
                $review = [];
                $review['que_1'] = $_POST['review_q'];
                $review['que_2'] = $_POST['que_2'];
                $review['comment'] = $comment;
                $article_review->article_review = Json::encode($review);
                $article_review->reviewed_date = date('Y-m-d H:i:s');
                //$article->status = 3;
                if($article_review->update()){
                    $sMessage = "";
                    $model = $article_review->reviewer;
                    $article = $article_review->article;
                    $zip = ArticleReview::generateCertificates($article_review);
                    $root_path = DOCPATH . "/uploads/ar_certi/";
                    $file_path = $root_path."{$article_review->id}";
                    if($zip !== false){
                        $message = PritMailer::arCertificate(['model' => $model, 'zip'=>$zip, 'article'=>$article]);
                        $article_review->certi_status = 1;
                        if($message && $article_review->update() !== false){
                            $sMessage = " We have sent a review certificate to you.";
                        }
                      
                    }
                    common::rmdir_recursive($file_path);
                    Yii::$app->session->setFlash('success', 'Review Submitted Successfully.'.$sMessage);
                    return $this->refresh();
                }
            }
            return $this->render('rfeedback', [
                'id' => $id,
                'article_review' => $article_review,
            ]);
        }
    }
    
    public function actionFupload($id){
        $id  = Common::passdecrypt($id);
        $article = \backend\models\Article::findOne(['id'=>$id]);
        $article->scenario = 'fupload';
        if($article->load(Yii::$app->request->post())){
            if($article->conf_id != 0){
                $fileDir = "conference";
            }else{
                $fileDir = "article";
            }
            $article->formatted_date = date('Y-m-d H:i:s');
            $article->status = 15;
            $filepath = $article->file_path;
            $article->formatted_file = \yii\web\UploadedFile::getInstance($article, 'formatted_file');
            $article->formatted_file->name = $filepath . "{$article->paper_id}_formatted_file_" . time() . "." .$article->formatted_file->extension;

            if($article->update()){
                $formatted = $article->formatted_file->saveAs(DOCPATH . "/uploads/$fileDir/" . $filepath . $article->formatted_file->baseName . '.' . $article->formatted_file->extension);
                Yii::$app->session->setFlash('success', 'File Submitted Successfully');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('danger', 'Failed to upload file. Please contact us about the issue.');
            }
        }
        return $this->render('fupload', [
            'id' => $id,
            'article' => $article,
        ]);
    }

    public function actionFormatted($id){
        $id  = Common::passdecrypt($id);
        $format = ArticleFormat::findOne($id);
        if($format){
            $format->scenario = 'submit_file';
            if($format->load(Yii::$app->request->post())){
                $format->formatted_date = date('Y-m-d H:i:s');
                $filepath = date('Y')."/";
                $format->formatted_file = \yii\web\UploadedFile::getInstance($format, 'formatted_file');
                $format->formatted_file->name = $filepath . "{$format->id}_" . uniqid() . "." .$format->formatted_file->extension;

                if($format->update()){
                    Common::checkAndCreateDirectory(DOCPATH . "/uploads/format_request/$filepath/");
                    chmod(DOCPATH . "/uploads/format_request/$filepath/",0777);
                    $f_file = DOCPATH . "/uploads/format_request/$filepath/" . $format->formatted_file->baseName . '.' . $format->formatted_file->extension;
                    $formatted = $format->formatted_file->saveAs($f_file);
                    chmod($f_file,0777);

                    $article = Article::findOne($format->article_id);
                    if(empty($article->formatted_file)){
                        ArticleFormat::acceptArticle($format, $article);
                    }

                    Yii::$app->session->setFlash('success', 'File Submitted Successfully');
                    return $this->refresh();
                } else {
                    Yii::$app->session->setFlash('danger', 'Failed to upload file. Please contact us about the issue.');
                }
            }
            return $this->render('formatted', [
                'id' => $id,
                'format' => $format,
            ]);
        }
    }

    public function actionReviewaccept($id){
        $id  = Common::passdecrypt($id);
        $ids = explode("_",$id);
        if(count($ids) == 2){
            $request_id = $ids[0];
            $reviewer_id = $ids[1];
            $requestOld = ReviewRequestOld::findOne($request_id);
            $request = ReviewRequest::findOne(['reviewer_id'=>$reviewer_id,'article_id'=> $requestOld->article_id,'review_status'=>0]);
            $reviewer = EditorialBoard::findOne($reviewer_id);
        }else{
            $request_id = $id;

            $request = ReviewRequest::findOne($request_id);
            $reviewer_id = $request->reviewer_id;
            $reviewer = EditorialBoard::findOne($reviewer_id);
        }



        if($request && $reviewer){

            if($request->review_status == 2){
                    $message = "You rejected this article previously. Please contact us on info@grdjournals.com if you want to review this article.";
                    Yii::$app->session->setFlash('danger',$message);
                    return $this->render('review_request');
            }
            if($request->review_status == 1){
                $message = "We have already sent you this article for review. Please contact us on info@grdjournals.com if any issue.";
                Yii::$app->session->setFlash('success',$message);
                return $this->render('review_request');
            }
            $request->review_status = 1;
            $request->reply_dt = date('Y-m-d H:i:s');
            $article = Article::findOne($request->article_id);
            $r_request = new ArticleReview();
            $r_request->scenario = 'create';
            $r_request->article_id = $request->article_id;
            $r_request->reviewer_id = $reviewer->id;
            if($r_request->save()){
                if(!empty($article->reviewer_copy)){
                    $file = DOCPATH . "/uploads/article/" .$article->reviewer_copy;
                } else {
                    $file = DOCPATH . "/uploads/article/" .$article->article_file;
                }
                $message = PritMailer::sendToReview(['reviewer'=>$reviewer,'article'=>$article , 'file'=>$file,'rid'=>$r_request->id]);
                if($message){
                    $article->sent_for_review = 1;
                    $article->update(false,['sent_for_review']);
                    if($request->update() !== false){
                        $message = "Thank you for accepting article for review.<br>We will be sending you the email with article in attachment in a while. "
                            ."<br> As per our reviewer's guidelines, please submit the review in 3 days, or let us know if more time is needed. <br> In case, if you don't receive the email containing paper or any queries you have, please let us know on info@grdjournals.com";
                        Yii::$app->session->setFlash('success',$message);
                        return $this->render('review_request');
                    }
                }else{
                    $r_request->delete();
                }
            }
            /**/
        }
        $message = "You are not authorized to access this page.";
        Yii::$app->session->setFlash('danger',$message);
        return $this->render('review_request');
    }

    public function actionReviewreject($id){
        $id  = Common::passdecrypt($id);
        $ids = explode("_",$id);
        if(count($ids) == 2){
            $request_id = $ids[0];
            $reviewer_id = $ids[1];
            $requestOld = ReviewRequestOld::findOne($request_id);
            $request = ReviewRequest::findOne(['reviewer_id'=>$reviewer_id,'article_id'=> $requestOld->article_id,'review_status'=>0]);
            $reviewer = EditorialBoard::findOne($reviewer_id);
        }else{
            $request_id = $id;
            $request = ReviewRequest::findOne($request_id);
            $reviewer_id = $request->reviewer_id;
            $reviewer = EditorialBoard::findOne($reviewer_id);
        }

        if($request && $reviewer){

            if($request->review_status == 2){
                $message = "You rejected this article previously. Please contact us on info@grdjournals.com if you want to review this article.";
                Yii::$app->session->setFlash('danger',$message);
                return $this->render('review_request');
            }
            if($request->review_status == 1){
                $message = "We have already sent you this article for review. Please contact us on info@grdjournals.com if any issue.";
                Yii::$app->session->setFlash('success',$message);
                return $this->render('review_request');
            }
            $request->review_status = 2;
            $request->reply_dt = date('Y-m-d H:i:s');

            if($request->update() !== false){
                $message = "Thanks for your response.<br>We will not send this article to you. However, we will be sending you the review requests for upcoming articles if we find them relevant to your specialization & branch."
                    ."<br> In case if you want to review this article or you have any queries, please let us know on infor@grdjournals.com";
                Yii::$app->session->setFlash('success',$message);
                return $this->render('review_request');
            }
            /**/
        }
        $message = "You are not authorized to access this page.";
        Yii::$app->session->setFlash('danger',$message);
        return $this->render('review_request');

    }

    public function actionMail(){
        for($i = 0 ;$i < 10;$i++){
            echo uniqid()."-".time()."<br>";
        }
//        $article = Article::findOne(['id'=>8]);
//        $zip = Article::generateCertificates($article);
//        $message = PritMailer::paymentAccepted(['model'=>$article,'zip'=>$zip]);

    }

    public function actionUnsubscribe(){

        $model = new Contact();
        if(!empty($_POST['Contact']) && !empty($_POST['Contact']['email_id'])){
            Contact::updateAll(['unsubscribed'=>1],['email_id'=>$_POST['Contact']['email_id']]);
            Yii::$app->session->setFlash('success',"Successfully Unsubscribed.");
            return $this->render('unsubscribe',['model'=>$model,'hide'=>true]);
        }
        return $this->render('unsubscribe',['model'=>$model,'hide'=>false]);
    }

    public function actionPostpaydetail(){
        $file =DOCPATH . "/logs/instamojo.txt";
        file_put_contents($file,print_r($_POST,true), FILE_APPEND );
        Yii::$app->end();
    }

}
