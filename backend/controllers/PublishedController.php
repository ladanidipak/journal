<?php

namespace app\controllers;

use backend\components\PritSms;
use backend\models\PritMailer;
use Yii;
use backend\models\Published;
use backend\models\search\PublishedSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\vendors\Common;
use app\components\BaseController;

/**
 * PublishedController implements the CRUD actions for Published model.
 */
class PublishedController extends BaseController {

    /**
     * Lists all Published models.
     * @return mixed
     */
    public function actionIndex() {
        ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

        $searchModel = new PublishedSearch();
        $searchModel->v_conf_id = 0;
        $type = 'article';
        $searchModel->is_deleted = 0;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'type' => $type
        ]);
    }

    /**
     * Lists all Published models.
     * @return mixed
     */
    public function actionConference() {
        $searchModel = new PublishedSearch();
        $searchModel->v_voliss_id = 0;
        $type = 'conference';
        $searchModel->is_deleted = 0;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'type' => $type
        ]);
    }

    /**
     * Displays a single Published model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Published model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id) {
       // ini_set('display_errors', 1);
       // ini_set('display_startup_errors', 1);   
       // error_reporting(E_ALL);
        $article = \backend\models\Article::findOne(['id' => $id]);
        if ($article) {
            $model = new Published();
            $model->scenario = 'create';
            $model->article_id = $article->id;
            $model->paper_id = $article->paper_id;
            $model->title = $article->article_title;
            $model->country = $article->country;
            $model->abstract = $article->abstract;
            $model->reference = $article->reference;
            $model->keywords = $article->keyword;
            $model->pub_date = date('d/m/Y');

            $model->authors = ucfirst($article->author_name) . ", " . ucfirst($article->a_org);
            if ($article->coauthors) {
                foreach ($article->coauthors as $coauthor) {
                    $model->authors .= "; " . ucfirst($coauthor->name) . " ," . ucfirst($coauthor->org);
                }
            }

            $filepath = $article->file_path;
            if ($model->load(Yii::$app->request->post())) {
                $model->pub_date = Common::dmyToYmd($model->pub_date);
                $model->pdf = \yii\web\UploadedFile::getInstance($model, 'pdf');
                $model->pdf->name = $filepath . "{$article->paper_id}." . $model->pdf->extension;
                //$model->pdf->name = $filepath . "Published_file_" . date('Y_m_d_H_i_s') . "." .$model->pdf->extension;

                if ($model->save()) {
                    $message = PritMailer::articlePublished(['model' => $article, 'published' => $model]);
                    if ($article->conf_id == 0) {
                        @PritSms::published(['model' => $article, 'published' => $model]);
                        $fileDir = "article";
                        $redirect = "index";
                    } else {
                        @PritSms::confpublished(['model' => $article, 'published' => $model]);
                        $fileDir = "conference";
                        $redirect = "conference";
                    }
                    $published = $model->pdf->saveAs(DOCPATH . "/uploads/$fileDir/" . $filepath . $model->pdf->baseName . '.' . $model->pdf->extension);
                    Yii::$app->session->setFlash('success', common::translateText("ADD_SUCCESS"));
                    //return $this->redirect([$redirect]);
                    return "<script>history.go(-2);</script>";
                }
            }
            return $this->render('_form', [
                        'model' => $model,
                        'article' => $article,
            ]);
        } else {
            Yii::$app->session->setFlash('danger', 'Unable to find Article');
        }
    }

    /**
     * Updates an existing Published model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $article = $model->article;
        $model->pub_date = Common::ymdToDmy($model->pub_date);
        if ($model->load(Yii::$app->request->post())) {
            $model->pub_date = Common::dmyToYmd($model->pub_date);
            $pdf = \yii\web\UploadedFile::getInstance($model, 'pdf');
            if ($pdf) {
                $filepath = $article->file_path;
                $model->pdf = $pdf;
                $model->pdf->name = $filepath . "{$model->paper_id}." . $model->pdf->extension;
            }

            if ($model->update() !== false) {
                if ($article->conf_id == 0) {
                    $fileDir = "article";
                    $redirect = "index";
                } else {
                    $fileDir = "conference";
                    $redirect = "conference";
                }
                if ($pdf) {
                    $model->pdf->saveAs(DOCPATH . "/uploads/$fileDir/" . $filepath . $model->pdf->baseName . '.' . $model->pdf->extension);
                    chmod(DOCPATH . "/uploads/$fileDir/" . $filepath . $model->pdf->baseName . '.' . $model->pdf->extension, 0777);
                }
                Yii::$app->session->setFlash('success', common::translateText("UPDATE_SUCCESS"));
                return $this->redirect([$redirect]);
            }
        }

        return $this->render('_form', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Published model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        
        $model = $this->findModel($id);
        $model->is_deleted = 1;
        $article = $model->article;
        if ($article->conf_id == 0) {
            $fileDir = "article";
            $redirect = "index";
        } else {
            $fileDir = "conference";
            $redirect = "conference";
        }
        if ($model->update()) {
            Yii::$app->session->setFlash('success', common::translateText("DELETE_SUCCESS"));
        } else {
            Yii::$app->session->setFlash('error', common::translateText("DELETE_FAIL"));
        }
        return $this->redirect([$redirect]);
    }

    /**
     * Finds the Published model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Published the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Published::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
