<?php

namespace app\controllers;

use Yii;
use app\models\Cms;
use app\models\search\CmsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\vendors\Common;
use app\components\BaseController;

/**
 * CmsController implements the CRUD actions for Cms model.
 */
class CmsController extends BaseController
{
    
    /**
     * Lists all Cms models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CmsSearch();
        $searchModel->is_deleted= 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cms model.
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
     * Creates a new Cms model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cms();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', common::translateText("ADD_SUCCESS"));
            if(!$this->actionCmsupdated()){
                Yii::$app->session->setFlash('danger', 'Slug Updation Faild. Contact Developer');
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Cms model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', common::translateText("UPDATE_SUCCESS"));
            if(!$this->actionCmsupdated()){
                Yii::$app->session->setFlash('danger', 'Slug Updation Faild. Contact Developer');
            }
            return $this->refresh();
        } else {
            return $this->render('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Cms model.
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
     * Finds the Cms model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cms the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cms::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionCmsupdated(){
        $cms = Cms::find()->select(['id','slug'])->where(['is_deleted'=>0,'status'=>1])->all();
        $cms  = \yii\helpers\ArrayHelper::map($cms, 'slug', 'id');
        array_walk($cms, function(&$value, &$key) { $value = 'page/'.$value;});
        $status = file_put_contents(DOCPATH."/config/menu.php", "<?php \n return ".  var_export($cms,true).";");
        return $status;
    }
}
