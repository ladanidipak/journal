<?php

namespace app\components;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\web\Cookie;
use backend\vendors\Common;
use yii\widgets\ActiveForm;
use app\components\WebUser;

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class BaseController extends Controller {

    public $siteTitle="";
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '/columnMain';
    public $isSuperAdmin;
    public $sliderVisible = false;
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public function init() {
        $settings = \backend\models\Setting::find()->select(['name','value'])->all();
        $GLOBALS['settings']=  \yii\helpers\ArrayHelper::map($settings, 'name', 'value');
    }

    public function behaviors() {
        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        //'actions' => AccessRules::getAccessRules(),
//                        'allow' => true,
//                        'roles' => ['*'],
//                    ]
//                ],
//            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    protected function performAjaxValidation($model, $request) {
        if ($request->isAjax && $model->load($request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\bootstrap\ActiveForm::validate($model);
        }
    }
}
