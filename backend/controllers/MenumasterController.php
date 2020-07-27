<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\web\Cookie;
use app\components\BaseController;
use app\models\MenuMaster;
use app\models\search\MenuMasterSearch;
use backend\vendors\Common;

/**
 * Menus display and management
 *
 * @name    MenuMasterController.php
 * @package application.controllers
 * @author  Alpesh Vaghela
 * @since   23rd June 2015
 */
class MenumasterController extends BaseController {

    /**
     * Action   Display Menus
     */
    public function actionIndex() {
        $searchModel = new MenuMasterSearch();  
        $searchModel->is_deleted= 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Action   Create Menus
     */
    public function actionCreate() {
        $model = new MenuMaster;
        $model->load(Yii::$app->request->post());
        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model, 'menu-master-form');

        if (Yii::$app->request->post() && $model->validate()) {
            $model->module_id = Yii::$app->request->post("MenuMaster")["module_id"];
            $model->save();
            Yii::$app->session->setFlash('success', common::translateText("ADD_SUCCESS"));
            return $this->redirect(['create']);
        }
        return $this->render('create', ['model' => $model]);
    }

    /**
     * Action   Update Menus
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        // Uncomment the following line if AJAX validation is needed
        $model->load(Yii::$app->request->post());
        //$this->performAjaxValidation($model, 'menu-master-form');
        if (Yii::$app->request->post() && $model->validate()) {
            if ($model->validate()) {                
                $model->module_id = Yii::$app->request->post("MenuMaster")["module_id"];
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', common::translateText("UPDATE_SUCCESS"));
                    return $this->redirect(['index']);
                }
            }
        }
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CompanyMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->is_deleted = true;
        if ($model->save()) {
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the CompanyMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CompanyMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = MenuMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
