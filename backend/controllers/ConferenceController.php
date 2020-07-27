<?php

namespace app\controllers;

use app\components\BaseController;
use backend\models\Conference;
use backend\models\search\ConferenceSearch;
use backend\vendors\Common;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ConferenceController implements the CRUD actions for Conference model.
 */
class ConferenceController extends BaseController
{

    /**
     * Lists all Conference models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConferenceSearch();
        $searchModel->is_deleted = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Conference model.
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
     * Finds the Conference model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Conference the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Conference::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Conference model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id = null)
    {
        if($id){
            $model = $this->findModel($id);
            $model->scenario = "update";
            if($model->pub_date){
                $model->pub_date = Common::ymdToDmy($model->pub_date);
            }
        }else{
            $model = new Conference();
            $model->scenario = "create";
        }


        if ($model->load(Yii::$app->request->post())) {
            if($model->pub_date){
                $model->pub_date = Common::dmyToYmd($model->pub_date);
            }
            $path_suffix = date('Y') . "/";
            $model->brochure = UploadedFile::getInstance($model, 'brochure');
            if($model->brochure){
                $model->brochure->name = $path_suffix . time() . "_" . Common::clean($model->brochure->name);
            }else{
                unset($model->brochure);
            }

            $model->college_logo = UploadedFile::getInstance($model, 'college_logo');
            if($model->college_logo){
                $model->college_logo->name = $path_suffix . time() . "_" . Common::clean($model->college_logo->name);
            }else{
                unset($model->college_logo);
            }

            if ($model->save()) {

                $b_path = DOCPATH . "/uploads/brochure/$path_suffix";
                $c_path = DOCPATH . "/uploads/college_logo/$path_suffix";
                if($model->brochure){
                    Common::checkAndCreateDirectory($b_path);
                    $model->brochure->saveAs($b_path . $model->brochure->baseName . '.' . $model->brochure->extension);
                    chmod($b_path . $model->brochure->baseName . '.' . $model->brochure->extension, 0777);
                }
                if($model->college_logo){
                    Common::checkAndCreateDirectory($c_path);
                    $model->college_logo->saveAs($c_path . $model->college_logo->baseName . '.' . $model->college_logo->extension);
                    chmod($c_path . $model->college_logo->baseName . '.' . $model->college_logo->extension, 0777);
                }

                Yii::$app->session->setFlash('success', 'You have successfully created a Conference Proposal.');
                return $this->redirect(['index']);
            }
        }
        return $this->render('_form', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing Conference model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        return $this->actionCreate($id);
    }

    /**
     * Deletes an existing Conference model.
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
}
