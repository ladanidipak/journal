<?php

namespace app\controllers;

use backend\models\PritMailer;
use Yii;
use backend\models\EditorialBoard;
use backend\models\search\EditorialBoardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\vendors\Common;
use app\components\BaseController;

/**
 * EditorialboardController implements the CRUD actions for EditorialBoard model.
 */
class EditorialboardController extends BaseController
{

    /**
     * Lists all EditorialBoard models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EditorialBoardSearch();
        $searchModel->is_deleted = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EditorialBoard model.
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
     * Creates a new EditorialBoard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new \backend\models\EditorialBoard();
        $model->scenario = "back_create";

        if ($model->load(Yii::$app->request->post())) {

            $model->cv = \yii\web\UploadedFile::getInstance($model, 'cv');
            $model->cv->name = time() . "_" . Common::clean($model->cv->name);
            $profile_pic = \yii\web\UploadedFile::getInstance($model, 'profile_pic');
            if ($profile_pic) {
                $model->profile_pic = $profile_pic;
                $model->profile_pic->name = time() . "_" . Common::clean($model->profile_pic->name);
            }
            $model->status = 0;

            if ($model->save()) {
                Common::checkAndCreateDirectory(DOCPATH . "/uploads/cv");
                Common::checkAndCreateDirectory(DOCPATH . "/uploads/reviewer_pic");
                $model->cv->saveAs(DOCPATH . "/uploads/cv/" . $model->cv->baseName . '.' . $model->cv->extension);
                if ($profile_pic) {
                    $model->profile_pic->saveAs(DOCPATH . "/uploads/reviewer_pic/" . $model->profile_pic->baseName . '.' . $model->profile_pic->extension);
                }

                Yii::$app->session->setFlash('success', 'Reviewer have been successfully registerd with us.');
                return $this->redirect(['index']);
            } else {
                ob_clean();
                echo "<pre>" . print_r($model->getErrors(), true);
                exit;
            }
        }
        return $this->render('_form', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EditorialBoard model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';

        if ($model->load(Yii::$app->request->post())) {

            $profile_pic = \yii\web\UploadedFile::getInstance($model, 'profile_pic');
            if ($profile_pic) {
                $model->profile_pic = $profile_pic;
                $model->profile_pic->name = time() . "_" . Common::clean($model->profile_pic->name);
            } else {
                unset($model->profile_pic);
            }
            $uploadedFile = \yii\web\UploadedFile::getInstance($model, 'cv');
            if ($uploadedFile) {
                $model->cv = $uploadedFile;
                $model->cv->name = time() . "_" . Common::clean($model->cv->name);
            } else {
                unset($model->cv);
            }

            if ($model->update()) {
                Common::checkAndCreateDirectory(DOCPATH . "/uploads/cv");
                Common::checkAndCreateDirectory(DOCPATH . "/uploads/reviewer_pic");
                if ($uploadedFile) {
                    $model->cv->saveAs(DOCPATH . "/uploads/cv/" . $model->cv->baseName . '.' . $model->cv->extension);
                }
                if ($profile_pic) {
                    $model->profile_pic->saveAs(DOCPATH . "/uploads/reviewer_pic/" . $model->profile_pic->baseName . '.' . $model->profile_pic->extension);
                }

                Yii::$app->session->setFlash('success', 'You have been successfully registerd with us.');
                return $this->redirect(['index']);
            }
        }
        return $this->render('_form', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EditorialBoard model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->is_deleted = 1;

        if ($model->update()) {
            Yii::$app->session->setFlash('success', common::translateText("DELETE_SUCCESS"));
        } else {
            Yii::$app->session->setFlash('error', common::translateText("DELETE_FAIL"));
        }
        return $this->redirect(['index']);
    }

    public function actionApprove($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->post()) {
            $model->status = 1;
            $zip = EditorialBoard::generateCertificates($model, '', $_POST['EditorialBoard']['CertificateText']);
            $root_path = DOCPATH . "/uploads/reviewer_certi/";
            $file_path = $root_path . "{$model->id}";
            $message = PritMailer::reviewerApproved(['model' => $model, 'zip' => $zip]);
            Common::rmdir_recursive($file_path);
            if ($message && $model->update() !== false) {
                Yii::$app->session->setFlash('success', 'Successfully Approved Reviewer.');
            } else {
                Yii::$app->session->setFlash('danger', 'Failed To Approved Reviewer.');
            }
            return $this->redirect(['index']);
        }
        return $this->render('certificate', [
            'model' => $model,
        ]);
    }

    public function actionPriority()
    {
        $response = ['result' => false, 'text' => ''];
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = $this->findModel($_POST['id']);
            $model->priority = $_POST['value'];
            if ($model->update() !== false) {
                $response['result'] = true;
                if ($model->priority == 1) {
                    $response['text'] = '<span class="label label-danger">Priority</span>';
                }
            }
            return $response;
        }
    }
    public function actionShow()
    {
        $response = ['result' => false, 'text' => ''];
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = $this->findModel($_POST['id']);
            $model->show_in_front = $_POST['value'];
            if ($model->update() !== false) {
                $response['result'] = true;
                if ($model->show_in_front == 1) {
                    $response['text'] = '<span class="label label-success">Show</span>';
                } else {
                    $response['text'] = '<span class="label label-danger">Hide</span>';
                }
            }
            return $response;
        }
    }

    public function actionReject($id)
    {
        $model = $this->findModel($id);
        $model->status = 2;
        $message = PritMailer::reviewerRejected(['model' => $model]);
        if ($message && $model->update() !== false) {
            Yii::$app->session->setFlash('success', 'Successfully Approved Reviewer.');
        } else {
            Yii::$app->session->setFlash('danger', 'Failed To Approved Reviewer.');
        }
        return $this->redirect(['index']);
    }

    public function actionNote()
    {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['pk'];
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = $this->findModel($id);
            $model->note = $_POST['value'];
            $response = [];
            if ($model->update() == false) {
                $response['success'] = false;
                $response['msg'] = "Unable to update value";
            } else {
                $response['success'] = true;
                $response['msg'] = $model->note;
            }
            return $response;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDownloadcerti($id)
    {
        $reviewer = $this->findModel($id);
        return $this->redirect(EditorialBoard::generateCertificates($reviewer, true));
    }

    /**
     * Finds the EditorialBoard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EditorialBoard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EditorialBoard::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
