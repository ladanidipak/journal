<?php

namespace app\controllers;

use Yii;
use backend\models\VolIss;
use backend\models\search\VolIssSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\vendors\Common;
use app\components\BaseController;

/**
 * VolumeController implements the CRUD actions for VolIss model.
 */
class VolumeController extends BaseController
{
    
    /**
     * Lists all VolIss models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VolIssSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VolIss model.
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
     * Creates a new VolIss model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VolIss();
        
        if ($model->load(Yii::$app->request->post())) {
            if($model->last_date){
                $lastdate = \DateTime::createFromFormat('d/m/Y', $model->last_date);
                $model->last_date = $lastdate->format('Y-m-d');
            }
            if($model->publish_date){
                $publishdate = \DateTime::createFromFormat('d/m/Y', $model->publish_date);
                $model->publish_date = $publishdate->format('Y-m-d');
            }
            if($model->save()){
                Yii::$app->session->setFlash('success', common::translateText("ADD_SUCCESS"));
                return $this->redirect(['index']);
            }
        }
        return $this->render('_form', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing VolIss model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $lastdate = \DateTime::createFromFormat('Y-m-d', $model->last_date);
        $model->last_date = $lastdate->format('d/m/Y');
        $publishdate = \DateTime::createFromFormat('Y-m-d', $model->publish_date);
        $model->publish_date = $publishdate->format('d/m/Y');
        if ($model->load(Yii::$app->request->post())) {
            if($model->last_date){
                $lastdate = \DateTime::createFromFormat('d/m/Y', $model->last_date);
                $model->last_date = $lastdate->format('Y-m-d');
            }
            if($model->publish_date){
                $publishdate = \DateTime::createFromFormat('d/m/Y', $model->publish_date);
                $model->publish_date = $publishdate->format('Y-m-d');
            }
            if($model->save()){
                Yii::$app->session->setFlash('success', common::translateText("UPDATE_SUCCESS"));
                return $this->redirect(['index']);
            }
        }
        return $this->render('_form', [
            'model' => $model,
        ]);
        
    }

    /**
     * Deletes an existing VolIss model.
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
     * Finds the VolIss model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VolIss the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VolIss::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
