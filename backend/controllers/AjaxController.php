<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\vendors\Common;
use app\components\BaseController;
use app\models\Location;

/**
 * 
 * READ ME BEFORE USING THIS CONTROLLER ::
 * Ajax Controller implements the ajax operations that should be available to 
 * all the user without addding it to Roles. So if you need role base thing don't 
 * add your action here. General Data fetching operations like getting States, 
 * Country like dropdowns can be added here, but in general way to be used in 
 * multiple locations.
 * 
 */
class AjaxController extends BaseController
{
    
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [], /* Ajax controller used for allowing all the actions */
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    
    
    
    public function actionGetlocation($id = NULL,$type = NULL)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $options = ['prompt'=>  Common::getDropDownText((new \app\models\Location)->getAttributeLabel($type.'_id'))];
            $res = array(
                //'select'    => \yii\helpers\Html::renderSelectOptions(NULL, Location::getLocation($type,$id),$options),
                'select'    => \yii\helpers\Html::renderSelectOptions(NULL, (new \app\models\Location)->getLocation($type,$id) ,$options),
                'success' => true,
            );

            return $res;
        }
    } 
}
