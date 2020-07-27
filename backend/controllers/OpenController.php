<?php

namespace app\controllers;


use Yii;
use yii\filters\VerbFilter;
use app\components\BaseController;

class OpenController extends BaseController
{
    public $layout = '/open';
    public function init() {
        $get  = Yii::$app->request->get();
	echo "<script>location.href = '".Yii::$app->urlManagerFrontend->createAbsoluteUrl([$this->module->requestedRoute, 'id'=>$get['id']])."'</script>";exit;
        return $this->redirect(Yii::$app->urlManagerFrontend->createAbsoluteUrl([$this->module->requestedRoute, 'id'=>$get['id']]));
    }
    
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

}
