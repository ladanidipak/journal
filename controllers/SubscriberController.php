<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\vendors\Common;
use app\components\BaseController;

/**
 * CmsController implements the CRUD actions for Cms model.
 */
class SubscriberController extends BaseController
{
    public function actionCreate(){
        
        $model = new \backend\models\Subscriber();

        if ($model->load(Yii::$app->request->post())) {
            if(\backend\models\Subscriber::find()->where(['status'=>1,'is_deleted'=>0,'email'=>$model->email])->one()){
                Yii::$app->session->setFlash('success', 'You are already Subscribed!!');
            }else if($model->save()){
                Yii::$app->session->setFlash('success', 'Successfully Subscribed!!');
            }
            return $this->redirect(['page/index']);
        } else {
            Yii::$app->session->setFlash('danger', 'Failed to subscribe');
            return $this->redirect(['page/index']);
        }
    }
}
    