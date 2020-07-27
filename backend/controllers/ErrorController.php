<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\web\Cookie;
use app\components\BaseController;

/**
 * Error display and management
 *
 * @name    ErrorController.php
 * @package application.controllers
 * @author  Alpesh Vaghela
 * @since   26rd June 2015
 */
class ErrorController extends BaseController {

    public $layout = '/errorColumn';

    public function behaviors() {
        return array();
    }
    /**
     * Action   Display Error
     */
    public function actionIndex() {
        $message = Yii::$app->errorHandler->exception->getMessage();
        if(!$message){
            $message = "Invalid request, Please don't try it again.";
        }
        return $this->render('index',["statusCode"=>Yii::$app->errorHandler->exception->statusCode, "message"=>$message]);
    }

}
