<?php

namespace app\controllers;

use app\models\Users;
use Yii;
use app\components\BaseController;


/**
 * Dashboard display and management
 *
 * @name    DashboardController.php
 * @package application.controllers
 * @author  Ravi Dhavlesha
 * @since   1.0
 */
class DashboardController extends BaseController {

    public $layout = "noHeaderColumn";    

    /**
     * Action   Display dashboard
     */
    public function actionIndex() {
        if(Yii::$app->user->identity->type == Users::CONFERENCE_USER){
            return $this->redirect(Yii::$app->getUrlManager()->createUrl('article/conference'));
        } else {
            return $this->redirect(Yii::$app->getUrlManager()->createUrl('article/index'));
        }
    }
    
}
