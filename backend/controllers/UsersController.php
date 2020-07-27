<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use app\models\search\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\vendors\Common;
use app\components\BaseController;
use app\models\UserRoleDetail;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends BaseController {

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UsersSearch();
        $searchModel->is_deleted = 0;
        $searchModel->type = Users::ADMIN;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) { 
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Users();

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $model->type=1;
            if ($model->validate()) {
                $model->password = Common::passencrypt($model->password);
                $model->confirm_password = common::passencrypt($model->confirm_password);
                
                
                if ($model->save()) {
                    $model->profile_pic = $model->uploadProfilePicture($model);
                    $model->save(); // update profile pic after upload
                    Yii::$app->session->setFlash('success', common::translateText("ADD_SUCCESS"));
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('error', common::translateText("ADD_FAIL"));
                }
            }
        }
        return $this->render('_form', [
                    'model' => $model,
        ]);
    }
    
    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->password = \common\models\User::passdecrypt($model->password);
        $model->confirm_password = $model->password;
        $oldlogo = $model->profile_pic;
        

        if (isset($_POST['Users'])) {               
            $model->attributes = $_POST['Users'];
            
            if ($model->validate()) {
            
                $profilpic = $model->uploadProfilePicture($model,$oldlogo);
                $model->profile_pic = !empty($profilpic)?$profilpic:$oldlogo;
                $model->password = \common\models\User::passencrypt($model->password);
                $model->confirm_password = \common\models\User::passencrypt($model->confirm_password);
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', common::translateText("UPDATE_SUCCESS"));
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('error', common::translateText("UPDATE_FAIL"));
                }
            }
        }
        return $this->render('_form', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->is_deleted = 1;
        $model->confirm_password = $model->password;
        if ($model->update()) {
            Yii::$app->session->setFlash('success', common::translateText("DELETE_SUCCESS"));
        } else {
            Yii::$app->session->setFlash('error', common::translateText("DELETE_FAIL"));
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDeletecompany() {
        $model = UserRoleDetail::findOne($_REQUEST['id']);
        $model->is_deleted = 1;
        if ($model->save()) {
            echo '1';
        } else {
            echo '0';
        }
        exit;
    }

}
