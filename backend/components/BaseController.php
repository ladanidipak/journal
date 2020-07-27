<?php

namespace app\components;

use backend\models\Conference;
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

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '/columnMain';
    public $isSuperAdmin;
    public $siteTitle="";
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

        if(CONF_WEB_PANEL && strstr(Yii::$app->request->baseUrl,'backend')){
            return $this->redirect(str_replace('backend','admin',Yii::$app->request->baseUrl));
        }elseif( !CONF_WEB_PANEL && strstr(Yii::$app->request->baseUrl,'admin')){
            return $this->redirect(str_replace('admin','backend',Yii::$app->request->baseUrl));
        }
     
        if ($this->id != 'login' && !Common::checkLoggedIn()) {  
            $this->redirect(Yii::$app->getUrlManager()->createUrl('login/login'));
        }
        if(isset($_REQUEST['pagesize'])){
            $_SESSION['pagesize'][$this->id] = $_REQUEST['pagesize'];
        }elseif(!(isset($_SESSION['pagesize']) && isset($_SESSION['pagesize'][$this->id]))){
            $_SESSION['pagesize'][$this->id] = Yii::$app->params['defaultPageSize'];
        }
        if(isset($_REQUEST['exit']) && $_REQUEST['exit'] = 1){
            Yii::$app->end();
        }

        $userid = Yii::$app->session->get('userId');
        if(!empty($userid) && is_numeric($userid) ){
            Yii::$app->user->loadWebUser(); // Load Web User Data                        
            $this->isSuperAdmin = Common::isSuperAdmin();
            defined('IS_GRD_ADMIN') or define('IS_GRD_ADMIN',$this->isSuperAdmin);
            //defined('IS_GRD_ADMIN') or define('IS_GRD_ADMIN',false);
            if(Yii::$app->user->identity->conf_id){
                defined('ACTIVE_CONF') or define('ACTIVE_CONF',Yii::$app->user->identity->conf_id);
                $_SESSION['active_conf'] = Conference::findOne(Yii::$app->user->identity->conf_id)->attributes;
                $_SESSION['authorized_conf'] = [ACTIVE_CONF];

                defined('IS_CONF_USER') or define('IS_CONF_USER',true);
            }else{
                defined('IS_CONF_USER') or define('IS_CONF_USER',false);
            }
            
            $userarr = \common\models\User::find()->where(['id'=>Yii::$app->session->get('userId')])->one();
            if(!empty($userarr)){
                if($userarr->status==0 || $userarr->is_deleted==1){
                    if($userarr->status==0){
                        $msg  = Common::translateText('USER_DEACTIVE');
                    }
                    if($userarr->is_deleted==1){
                        $msg  = Common::translateText('USER_DELETED');
                    }
                    Yii::$app->response->cookies->add(new \yii\web\Cookie([
                        'name' => 'loginerror',
                        'value' => $msg,
                        'expire' => time() + (60 * 60 * 24 * 30 ),
                    ]));
                    $this->redirect(Yii::$app->getUrlManager()->createUrl('login/logout'));
                }
            }
        }
        
        
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => AccessRules::getAccessRules(),
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

    protected function performAjaxValidation($model, $request) {
        if ($request->isAjax && $model->load($request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\bootstrap\ActiveForm::validate($model);
        }
    }
}
