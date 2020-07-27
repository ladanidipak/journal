<?php

namespace app\controllers;

use backend\models\Article;
use backend\models\PritMailer;
use Yii;
use backend\models\ArticleReview;
use backend\models\search\ArticleReviewSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\vendors\Common;
use app\components\BaseController;

/**
 * ArController implements the CRUD actions for ArticleReview model.
 */
class ArController extends BaseController
{
    
    /**
     * Lists all ArticleReview models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $article = Article::findOne($id);
        if($article){
            $searchModel = new ArticleReviewSearch();
            $searchModel->article_id= $id;
            $searchModel->is_deleted= 0;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'article' => $article,
            ]);
        }
    }

    /**
     * Displays a single ArticleReview model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionShowreview($id){
        $article = ArticleReview::findOne(['id'=>$id]);
        return $this->renderPartial('_showreview',['article'=>$article]);
    }

    public function actionAccept($id){
        $ar = $this->findModel($id);
        $article = Article::findOne($ar->article_id);
        $article->scenario = 'review';
        $article->article_review = $ar->article_review;
        if(in_array($article->status,[1,3])){
            $article->status = 3;
        }else{
            $article->status = $article->status;
        }

        $article->reviewer_id = $ar->reviewer_id;
        $article->reviewed_date = $ar->reviewed_date;
        $article->ar_id = $ar->id;
        if($article->update() !== false){
            Yii::$app->session->setFlash('success', 'Review Submitted Successfully');
            $ar->status  = 3;
            $ar->update(false,['status','ar_id']);
            Yii::$app->session->set('aid_highlight',$article->id);
            return $this->redirect(['article/index','ArticleSearch[voliss_id]'=>$article->voliss_id]);
        }
    }


    /**
     * Deletes an existing ArticleReview model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        $model->is_deleted = 1;
        
        if($model->update()){
            Yii::$app->session->setFlash('success', common::translateText("DELETE_SUCCESS"));
        }else{
            Yii::$app->session->setFlash('error', common::translateText("DELETE_FAIL"));
        }
        return $this->redirect(['index']);
    }

    public function actionSendcertificate($id){
        
        /*Yii::$app->session->setFlash('error', 'Certificate Penindexnding.');
        return $this->redirect(['ar/index','id'=>$id]);*/
        if(!empty($_POST['rid'])){
            $arIds = explode(",",$_POST['rid']);
            $articleReview = ArticleReview::findAll(['article_id'=>$id, 'id'=>$arIds]);
            if($articleReview){
                $successName = [];
                $failedName = [];
                foreach($articleReview as $ar){
                    if($ar->reviewed_date){
                        $zip = ArticleReview::generateCertificates($ar);
                        $root_path = DOCPATH . "/uploads/ar_certi/";
                        $file_path = $root_path."{$ar->id}";
                        $model = $ar->reviewer;
                        if($zip === false){
                            $failedName[] = $model->full_name;
                        }else{
                            $article = $ar->article;
                            $message = PritMailer::arCertificate(['model' => $model, 'zip'=>$zip, 'article'=>$article]);
                            $ar->certi_status = 1;
                            if($message && $ar->update() !== false){
                                $successName[] = $model->full_name;
                            }
                        }
                        common::rmdir_recursive($file_path);
                    }
                }
                if($successName){
                    $successName = implode(", ",$successName);
                    if($failedName){
                        $failedName = implode(", ",$failedName);
                        $failedName = "Unable to Generate certificate for $failedName . Please send them manually.";
                    }else{
                        $failedName ="";
                    }
                    Yii::$app->session->setFlash('success', "Review Certificate successfully sent to $successName . $failedName");
                } else {
                    Yii::$app->session->setFlash('danger', 'Failed to send certificate.');
                }
            }
        }else{
            Yii::$app->session->setFlash('error', 'Please select at least one reviewer.');
        }
        return $this->redirect(['ar/index','id'=>$id]);
    }

    /**
     * Finds the ArticleReview model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ArticleReview the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArticleReview::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
