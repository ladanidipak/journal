<?php

namespace app\controllers;

use Yii;
use backend\models\ConfPro;
use backend\models\search\ConfProSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\vendors\Common;
use app\components\BaseController;

/**
 * ConfproController implements the CRUD actions for ConfPro model.
 */
class ConfproController extends BaseController
{
    
    /**
     * Lists all ConfPro models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConfProSearch();
        $searchModel->is_deleted= 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ConfPro model.
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
     * Deletes an existing ConfPro model.
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
     * Finds the ConfPro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ConfPro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ConfPro::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
