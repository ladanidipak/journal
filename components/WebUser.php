<?php

namespace app\components;

use yii\web\User as CoreUser;
use Yii;
use common\models\User;
use app\models\GroupRights;
use app\models\Users;
use app\models\RoleMaster;
use app\models\MenuMaster;
use backend\vendors\Common;

/**
 * User component
 */
class WebUser extends CoreUser {

    // Store model to not repeat query.
    private $_model;
    public $_permissions;
    public $_titles;

    public function init() {
        parent::init();
        $this->loadWebUser();
        return true;
    }

    function loadWebUser() {
        if (!empty(Yii::$app->user->identity->id)):
            $userModel = $this->loadUser(Yii::$app->user->identity->id);
            if (is_object($userModel)):
                $this->loadPermissions(Yii::$app->user->identity->user_group);
                $this->loadTitles();
            endif;
        endif;
    }

    function isSuperAdmin() {
        return intval($this->_model->user_group) == RoleMaster::SUPER_ADMIN;
    }

    function getProfilePicture($profile_pic = null, $id = null,$thumb=true)
    {
        $thumbPrefix = ($thumb)?Users::THUMB_SMALL:"";
        $profile_pic = !empty($profile_pic) ? $profile_pic : $this->_model->profile_pic;
        $profile_pic = $thumbPrefix.$profile_pic;
        
        $id = !empty($id) ? $id : $this->_model->id;
        $PATH = Yii::$app->params['usersPath'] . $id . DIRECTORY_SEPARATOR;
        $URL = Yii::$app->params['usersURL'] . $id . DIRECTORY_SEPARATOR;

        if (file_exists($PATH . $profile_pic) && !empty($profile_pic)) {
            return $URL . $profile_pic;
        } else {
            $genderImg = !empty($this->_model->gender)?"no-image-female.png":"no-image-male.png";
            return Yii::$app->params['designElementUrl'] . "img/".$genderImg;
        }
    }

    function getFullName() {
        return $this->_model->first_name . " " . $this->_model->last_name;
    }

    // Load user model.
    protected function loadUser($id = null) {
        if ($this->_model === null) {
            if ($id !== null) {
                $this->_model = User::findOne($id);
            }
        }
        return $this->_model;
    }

    public function loadPermissions($user_group) {
        $GroupRights = new GroupRights();
        $permissionArr = array();                
        if ($user_group == RoleMaster::SUPER_ADMIN):
            $Permissions = MenuMaster::find()->all();        
            if (!empty($Permissions)):
                foreach ($Permissions as $value):
                    if (!empty($value->page_url)):
                        $permissionArr[$value->id] = trim($value->page_url);
                    endif;
                endforeach;
            endif;
        else:
            $Permissons = $GroupRights->getRolePermissions($user_group);
            if (!empty($Permissons)):
                foreach ($Permissons as $value):
                    if (!empty($value->menus->page_url)):
                        $permissionArr[$value->menus->id] = trim($value->menus->page_url);
                    endif;
                endforeach;
            endif;
        endif;
        //common::p($permissionArr,0,"192.168.0.146");
        return $this->_permissions = $permissionArr;
    }

    public function loadTitles() {
        $menusModel = MenuMaster::find()->all();
        $titlesArr = array();
        if (!empty($menusModel)):
            foreach ($menusModel as $value):
                $titlesArr[$value->page_url] = $value->menu_title;
            endforeach;
        endif;
        return $this->_titles = $titlesArr;
    }

}
