<?php

namespace app\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use backend\vendors\Common;
use app\components\BaseController;
use app\models\MenuMaster;

class LeftMenuWidget extends Widget {

    public function init() {
        parent::init();
    }

    public function run() {
        $menusArr = $this->getLeftMenu();
        return $this->render('left_menu', ["menusArr" => $menusArr]);
    }

    public function getLeftMenu() {

        $currentUrl = common::getCurrentUrl();
        list($controller, $pageAction) = explode("/", $currentUrl);
        
        $currentPage = array_search($currentUrl, Yii::$app->user->_permissions);
        $selected = array();
        $selected[] = $currentPage;
        $permissionArr = array_keys(Yii::$app->user->_permissions);
        $condition = !empty($permissionArr) ? " id IN (" . implode(",", $permissionArr) . ")" : "  id IN (0) ";
        $condition = (Yii::$app->user->isSuperAdmin()) ? "1=1" : $condition;
        $model = MenuMaster::find()->andWhere($condition)->orderBy("sort_order ASC")->all();
        $arr = array();
        if (!empty($model)) : foreach ($model as $value):
                if ($value->show_in_menu):
                    list($pageController, $pageAction) = explode("/", $value->page_url);
                    $active = ($controller == $pageController) ? true : false;
                    $module = !empty($value->module_id)?common::getModuleName($value->module_id).DIRECTORY_SEPARATOR:"";
                    $arr[] = array(
                        "id" => $value->id,
                        "parent_id" => $value->parent_id,
                        "menu_title" => $value->menu_title,
                        "url" => Yii::$app->getUrlManager()->createUrl($module.$value->page_url),
                        "menu_icon" => $value->menu_icon,
                        "active" => $active
                    );
                endif;
                //echo $value->parent_id . "==" . $currentPage;echo "<br>";
                if ($value->id == $currentPage):
                    $selected[] = $value->parent_id;
                    $currentPage = $value->parent_id;
                endif;
            endforeach;
        endif;
        $menusArr = MenuMaster::buildMenuTree($arr, null, 0, $selected);
        return $menusArr;
    }

}

?>
