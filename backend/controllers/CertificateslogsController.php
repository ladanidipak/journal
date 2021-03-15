<?php

namespace app\controllers;

use Yii;
use backend\models\BoardCertificatesLogs;
use backend\models\search\BoardCertificatesLogsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\vendors\Common;
use app\components\BaseController;
use backend\components\PritWriteImagick;
use backend\models\EditorialBoard;
use backend\models\PritMailer;

/**
 * CertificateslogsController implements the CRUD actions for BoardCertificatesLogs model.
 */
class CertificateslogsController extends BaseController
{

    /**
     * Lists all BoardCertificatesLogs models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BoardCertificatesLogsSearch();
        $searchModel->is_deleted = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BoardCertificatesLogs model.
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
     * Creates a new BoardCertificatesLogs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BoardCertificatesLogs();

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            // certificate send logic start
            $name = $model->name;
            $root_path = DOCPATH . "/uploads/reviewer_certi/logs/";
            $rool_url = DOCURL . "uploads/reviewer_certi/logs/";
            $file_path = $root_path . "{$model->id}";
            if (is_dir($file_path)) {
                Common::removeDir($file_path);
                @unlink($file_path . ".zip");
            }
            $reviewer_id = sprintf("GRDRW%04d", $model->id);
            Common::checkAndCreateDirectory($file_path);
            $count = 1;
            $textArray = [
                //['name' => 'ISSN [ONLINE] : 2455 - 5703', 'x' => 4400, 'y' => 460, 'font_size' => 55, 'font' => DOCPATH . '/uploads/certificate/times_bold.ttf'],
                ['name' => $reviewer_id, 'x' => 4400, 'y' => 700, 'font_size' => 195, 'font' => DOCPATH . '/uploads/certificate/barcode.ttf'],
                ['name' => $name, 'x' => 2800, 'y' => 1850, 'font_size' => 110, 'font' => DOCPATH . '/uploads/certificate/times_bold.ttf'],
                ['name' => $model->recognize, 'x' => 2800, 'y' => 2300, 'font_size' => 105, 'font' => DOCPATH . '/uploads/certificate/times_bold_italic.ttf'],
                ['name' => date("d/m/Y"), 'x' => 4150, 'y' => 2820, 'font_size' => 105, 'font' => DOCPATH . '/uploads/certificate/times.ttf']
            ];
            //reviewer_feb_2_remove
            $data = [
                'inputPath' => DOCPATH . "/uploads/certificate/reviewer_certificate.jpg", 'outputPath' => $file_path . "/" . Common::clean($name) . ".jpg",
                'text' => $textArray
            ];
            $image = new PritWriteImagick($data);
            $image->create_image();
            Common::directoryToZip($root_path . "{$model->id}/certificates.zip", $file_path);
            $url = '';
            if ($url) {
                $zip =  $rool_url . "{$model->id}/certificates.zip";
            } else {
                $zip =  $root_path . "{$model->id}/certificates.zip";
            }

            // Certificate logic end
            $root_path = DOCPATH . "/uploads/reviewer_certi/logs/";
            $file_path = $root_path . "{$model->id}";
            //send mail logic start
            $mailData = ['from' => \Yii::$app->params['fromEmail'], 'to' => $model->to, 'subject' => $model->subject, 'body' => $model->body, 'attachment' => $zip];
            $message = PritMailer::mailer($mailData);
            //send mail logic end
            Common::rmdir_recursive($file_path);
            Yii::$app->session->setFlash('success', common::translateText("ADD_SUCCESS"));
            return $this->redirect(['index']);
        } else {
            return $this->render('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BoardCertificatesLogs model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
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
     * Deletes an existing BoardCertificatesLogs model.
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

    /**
     * Finds the BoardCertificatesLogs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BoardCertificatesLogs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BoardCertificatesLogs::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
