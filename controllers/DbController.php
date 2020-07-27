<?php

namespace app\controllers;

use backend\components\IssuuClient;
use backend\components\PritSms;
use backend\models\Article;
use backend\models\PritMailer;
use backend\models\Published;
use backend\models\ReviewRequest;
use backend\models\ReviewRequestNew;
use Yii;
//use app\models\Cms;
//use app\models\search\CmsSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\vendors\Common;
use app\components\BaseController;
use app\components\PritWriteImage;
use backend\models\EditorialBoard;

/**
 * CmsController implements the CRUD actions for Cms model.
 */
class DbController extends Controller {
    /* public function actionImport(){
      $data   = file_get_contents(\Yii::$app->basePath."/data/journal.sql");
      $result = \Yii::$app->db->createCommand($data)->execute();
      echo " :) Done";exit;
      } */

    public function actionClean() {
        $dir = '/xampp/htdocs/journal/uploads/'; //yii::$app->params['usersPath'];
        $files1 = scandir($dir);
        echo '<pre>' . print_r($files1, true) . '</pre>';
        exit();
    }

    public function actionChecksms() {
        $article = \backend\models\Article::findOne(['id'=>11]);
        $article->a_phone = 9898937716;
        $article->author_name = 'Ladani dipak';
        $test = PritSms::confpublished($article);
        ob_clean();
        echo '<pre>' . print_r($test, true) . '</pre>';
        exit();
//       $test = PritSms::review_request($data);
        ob_clean();
        echo '<pre>' . print_r($test, true) . '</pre>';
        exit();
    }

    public function actionIssuu() {
        $publish = Published::findOne(3);
        $article = $publish->article;

        $issuu = new IssuuClient(Yii::$app->params['issuu-api-key'], Yii::$app->params['issuu-api-secret'], 'http://api.issuu.com/1_0');
        $issuu->openAction('issuu.document.url_upload');
        if ($article->conf_id == 0) {
            $fileDir = "article";
        } else {
            $fileDir = "conference";
        }
        $issuu->slurpUrl = Url::base(true) . "/uploads/$fileDir/" . $publish->pdf;
        $issuu->slurpUrl = 'http://grdjournals.com/uploads/article/GRDJE/V01/I09/0005/GRDJEV01I090005.pdf';
        $issuu->name = strtolower($publish->paper_id);
        $issuu->title = htmlentities($publish->title);
        if (strlen($publish->title) > 100) {
            $issuu->title = substr($publish->title, 0, strpos($publish->title, ' ', 85));
        } else {
            $issuu->title = $publish->title;
        }

        $issuu->tags = htmlentities($publish->keywords);
        $issuu->description = htmlentities($publish->abstract);
        $issuu->description = trim(preg_replace('/\s+/', ' ', $issuu->description));
//        $issuu->description = "test";
        if (strlen($issuu->description) > 300) {
            $issuu->description = substr($issuu->description, 0, strpos($issuu->description, ' ', 290));
        } else {
            $issuu->description = $issuu->description;
        }
        //var_dump($issuu->description);exit;
        $issuu->category = "007000";
        $issuu->type = "004000";
        $issuu->publishDate = $publish->pub_date;
        $issuu->executeAction();
        $response = $issuu->getResponse();
        $issuu->closeAction();
        if (is_array($response) && !empty($response["rsp"]) && $response['rsp']['stat'] == "ok") {
            echo "success";
            exit;
        } else {
            if (!empty($response["rsp"]) && $response['rsp']['stat'] == "fail") {
                echo $errorMessage = $response["rsp"]["_content"]["error"]["message"];
                exit;
                ;
            } else {
                echo $errorMessage = "Failed to upload article on ISSUU with unknown error.";
                exit;
            }
        }
    }

    public function actionSlideshare() {
        Published::uploadToSlideshare();
    }

    public function actionTest() {
        $article = Article::findOne(6);
        Article::generateCertificates($article);
    }

    public function actionMail() {
        //phpinfo();exit;
        //http://grdjournals.com
        $mailData = [
            'from' => \Yii::$app->params['fromEmail'],
            'to' => 'pritesh966@gmail.com',
            'subject' => 'Certificate for your review on article',
            'body' => "This is just a test mail to send ..",
        ];
        return PritMailer::mailer($mailData);
        //$article = \backend\models\Article::findOne(['id'=>669]);
        //$model = Published::findOne(['paper_id'=>$article->paper_id]);
        //$message = PritMailer::submitArticle(['model'=>$article]);
    }

    public function actionReview() {
        exit;
        ini_set('display_errors', 'on');
        error_reporting(E_ALL);
        ini_set('max_execution_time', 0);
        $requests = ReviewRequest::find()->all();
        $count = 0;
        foreach ($requests as $req) {
            $article_id = $req->article_id;
            $reviewer_ids = explode(",", $req->reviewer_ids);
            $accept_ids = ($req->sent_ids) ? explode(",", $req->sent_ids) : [];
            $reject_ids = ($req->rejected_ids) ? explode(",", $req->rejected_ids) : [];
            foreach ($reviewer_ids as $reviewer_id) {
                $new_rr = new ReviewRequestNew();
                $new_rr->article_id = $article_id;
                $new_rr->reviewer_id = $reviewer_id;
                $new_rr->created_by = 1;
                $new_rr->created_dt = $req->created_dt;
                if ($req->id < 256) {
                    $new_rr->review_status = 5;
                } else {
                    if (in_array($reviewer_id, $accept_ids)) {
                        $new_rr->review_status = 1;
                    } elseif (in_array($reviewer_id, $reject_ids)) {
                        $new_rr->review_status = 2;
                    } else {
                        $new_rr->review_status = 0;
                    }
                }

                if ($new_rr->save()) {
                    $req->t_status = 1;
                    $req->update(false, ['t_status']);
                    $count++;
                }
            }
        }
        echo $count;
        exit;
    }

}
