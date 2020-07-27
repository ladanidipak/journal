<?php

namespace app\controllers;

use backend\models\Article;
use Yii;
use backend\models\ArticleFormat;
use backend\models\search\ArticleFormatSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\vendors\Common;
use app\components\BaseController;

/**
 * AfController implements the CRUD actions for ArticleFormat model.
 */
class AfController extends BaseController
{
    
    /**
     * Lists all ArticleFormat models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $article = Article::findOne($id);
        if($article){
            $searchModel = new ArticleFormatSearch();
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

    public function actionAccept($id){
        $ar = $this->findModel($id);
        $article = Article::findOne($ar->article_id);
        $article->scenario = 'accept_formatter';
        if($article->conf_id == 0){
            $redirect = ['article/index','ArticleSearch[voliss_id]'=>$article->voliss_id];
        } else {
            $redirect = ['article/conference','ArticleSearch[conf_id]'=>$article->conf_id];
        }

        if(ArticleFormat::acceptArticle($ar, $article)){
                Yii::$app->session->setFlash('success', 'Formatter accepted successfully.');
                Yii::$app->session->set('aid_highlight',$article->id);
                return $this->redirect($redirect);
        }

    }

    /**
     * Displays a single ArticleFormat model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ArticleFormat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {exit;
        $model = new ArticleFormat();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', common::translateText("ADD_SUCCESS"));
            return $this->redirect(['index']);
        } else {
            return $this->render('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ArticleFormat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {exit;
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', common::translateText("UPDATE_SUCCESS"));
            return $this->redirect(['index']);
        } else {
            return $this->render('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ArticleFormat model.
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

    /**
     * Finds the ArticleFormat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ArticleFormat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArticleFormat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
