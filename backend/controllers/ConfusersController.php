<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\search\UsersSearch;
use app\models\UserRoleDetail;
use app\models\Users;
use backend\vendors\Common;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class ConfusersController extends BaseController
{

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $searchModel = new UsersSearch();
        $searchModel->scenario = 'admin';
        $searchModel->is_deleted = 0;
        $searchModel->conf_id = $id;
        $searchModel->type = Users::CONFERENCE_USER;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('//users/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id' => $id
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('//users/view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Users();

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $model->type = 2;
            $model->user_group = 2;
            $model->status = 1;
            $model->conf_id = $id;
            if ($model->validate()) {
                $model->password = Common::passencrypt($model->password);
                $model->confirm_password = common::passencrypt($model->confirm_password);


                if ($model->save()) {
                    $model->profile_pic = $model->uploadProfilePicture($model);
                    $model->save(); // update profile pic after upload
                    Yii::$app->session->setFlash('success', common::translateText("ADD_SUCCESS"));
                    return $this->redirect(['index', 'id' => $id]);
                } else {
                    Yii::$app->session->setFlash('error', common::translateText("ADD_FAIL"));
                }
            } else {

            }
        }
        return $this->render('//users/_form', [
            'model' => $model,
            'id' => $id
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->password = \common\models\User::passdecrypt($model->password);
        $model->confirm_password = $model->password;
        $oldlogo = $model->profile_pic;


        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];

            if ($model->validate()) {

                $profilpic = $model->uploadProfilePicture($model, $oldlogo);
                $model->profile_pic = !empty($profilpic) ? $profilpic : $oldlogo;
                $model->password = \common\models\User::passencrypt($model->password);
                $model->confirm_password = \common\models\User::passencrypt($model->confirm_password);
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', common::translateText("UPDATE_SUCCESS"));
                    return $this->redirect(['index','id'=>$model->conf_id]);
                } else {
                    Yii::$app->session->setFlash('error', common::translateText("UPDATE_FAIL"));
                }
            }
        }
        return $this->render('//users/_form', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
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

    public function actionDeletecompany()
    {
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
