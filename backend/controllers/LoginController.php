<?php

namespace app\controllers;

use app\models\Users;
use Yii;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\web\Controller;
use yii\web\Cookie;
use app\components\BaseController;
use backend\vendors\Common;

/**
 * Site controller
 */
class LoginController extends BaseController {

    public $layout = '/columnMain';

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'logout', 'back', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionLogin() {
        
        if (Common::checkLoggedIn()) {
            return $this->redirect(['dashboard/index']);
        } 
        /** @var LoginForm $model */
        $model = new LoginForm();
        if (isset($_POST['LoginForm']) && !empty($_POST['LoginForm'])) {
            $username = $_POST['LoginForm']['email'];
            $password = $_POST['LoginForm']['password'];
            
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                if(Yii::$app->user->identity->type == Users::CONFERENCE_USER){
                    return $this->redirect(Yii::$app->getUrlManager()->createUrl('article/conference'));
                } else {
                    return $this->redirect(Yii::$app->getUrlManager()->createUrl('article/index'));
                }

            }
        }
        $this->layout = '/main';
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    public function actionLogout() {
        if (Yii::$app->user->logout()) {  
            $session = Yii::$app->session;
            $session->remove('user_id');
            $session->remove('username');
            $session->remove('userEmailAddress');
            $session->remove('userFullName');
            $session->remove('userRoleId');
            $session->remove('role');
            $session->remove('defaultProjectId');
            return $this->goHome();
        }
    }

}
