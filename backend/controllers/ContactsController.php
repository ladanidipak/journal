<?php

namespace app\controllers;

use backend\models\ContactList;
use Yii;
use backend\models\Contact;
use backend\models\search\ContactSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\vendors\Common;
use app\components\BaseController;

/**
 * ContactsController implements the CRUD actions for Contact model.
 */
class ContactsController extends BaseController
{
    
    /**
     * Lists all Contact models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContactSearch();
        $searchModel->is_deleted= 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $contact = new Contact();
        $contact->scenario = "import";

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'contact' => $contact
        ]);
    }

    public function actionImport(){

        $model = new Contact();
        $model->scenario = "import";
        $list_id = 0;
        if($model->load(Yii::$app->request->post())){
            if($model->list_drop == "Other"){
                if(!empty($model->list_input)){
                    $list_input = trim($model->list_input);
                    $list_exist = ContactList::findOne(['name'=>$list_input, 'is_deleted'=>0]);
                    if(!$list_exist){
                        $list = new ContactList();
                        $list->name = $list_input;
                        if($list->save()){
                            $list_id = $list->id;
                        }
                    }else{
                        $list_id = $list_exist->id;
                    }
                }
            }else{
                $list_id  = $model->list_drop;
            }
            if($list_id){
                $model->csv = \yii\web\UploadedFile::getInstance($model, 'csv');
                $model->csv->name = time()."_".Common::clean($model->csv->name);
                Common::checkAndCreateDirectory(DOCPATH . "/uploads/csv");

                $path = DOCPATH . "/uploads/csv/" . $model->csv->baseName . '.' . $model->csv->extension;
                $model->csv->saveAs($path);
                $count = $model->import($list_id,$path);
                Yii::$app->session->setFlash('success', "Total $count Contacts imported.");
                return $this->redirect(['index']);
            }
        }
        Yii::$app->session->setFlash('error', "Failed to import Contacts.");
        return $this->redirect(['index']);
    }

    /**
     * Displays a single Contact model.
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
     * Creates a new Contact model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Contact();

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
     * Updates an existing Contact model.
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
     * Deletes an existing Contact model.
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
     * Finds the Contact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contact::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
