<?php

namespace app\models;

use yii\helpers\ArrayHelper;
use Yii;
use backend\vendors\Common;

/**
 * This is the model class for table "menu_master".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $menu_title
 * @property string $page_url
 * @property integer $module_id
 * @property integer $show_in_menu
 * @property integer $sort_order
 * @property string $menu_icon
 * @property integer $is_deleted
 * @property integer $created_dt
 * @property integer $created_by
 * @property integer $updated_dt
 * @property integer $updated_by
 */
class MenuMaster extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'menu_master';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['parent_id', 'show_in_menu', 'sort_order', 'is_deleted', 'created_dt', 'created_by', 'updated_dt', 'updated_by'], 'integer'],
            [['menu_title', 'page_url'], 'required'],
            [['page_url'], 'unique'],
            [['menu_title', 'page_url'], 'string', 'max' => 128],
            [['menu_icon'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent',
            'menu_title' => 'Menu Title',
            'page_url' => 'Page Url',
            'module_id' => 'Module',
            'show_in_menu' => 'Show In Menu',
            'sort_order' => 'Sort Order',
            'menu_icon' => 'Menu Icon',
            'is_deleted' => 'Is Deleted',
            'created_dt' => 'Created Date',
            'created_by' => 'Created By',
            'updated_dt' => 'Updated Date',
            'updated_by' => 'Updated By',
        ];
    }

    public function beforeSave($insert) {

        if (parent::beforeSave($insert)) {
            $this->parent_id = !empty($this->parent_id) ? $this->parent_id : 0;
            $this->module_id = !empty($this->module_id) ? $this->module_id : 0;            
            if ($insert):
                $this->created_dt = common::getTimeStamp();
                $this->created_by = Yii::$app->user->identity->id;
            else:
                $this->updated_dt = common::getTimeStamp();
                $this->updated_by = Yii::$app->user->identity->id;
            endif;
            return true;
        } else {
            return false;
        }
    }

    public function getChilds() {
        return $this->hasMany(MenuMaster::className(), ['id' => 'parent_id'])->from(["M2" => MenuMaster::tableName()]);
    }

    public function getParent() {
        return $this->hasOne(MenuMaster::className(), ['id' => 'parent_id'])->from(["M2" => MenuMaster::tableName()]);
    }

    public function getParentMenus() {
        return $this->find()->where(["parent_id" => 0])->all();
    }

    public function getParentMenusList() {
        return ArrayHelper::map($this->getParentMenus(), 'id', 'menu_title');
    }

    public static function buildMenuTree($ar, $pid = null, $level = 0, $selected = array()) {

        $op = array();
        foreach ($ar as $item) {
            $level = empty($pid) ? 0 : $level;
            if ($item['parent_id'] == $pid) {
                $active = in_array($item["id"], $selected) ? true : false;
                $op[$item['id']] = array(
                    'id' => $item['id'],
                    'parent_id' => $item['parent_id'],
                    'menu_title' => $item['menu_title'],
                    'url' => $item['url'],
                    'menu_icon' => $item['menu_icon'],
                    'active' => $active,
                );
                $collapse = ($active)?"":"collapse";
                $levelClass = array(1 => "nav nav-second-level $collapse", 2 => 'nav nav-third-level');
                // using recursion
                $children = self::buildMenuTree($ar, $item['id'], $level, $selected);
                if ($children) {
                    $level++;
                    $op[$item['id']]['level_class'] = !empty($pid) ? $levelClass[2] :$levelClass[1];
                    $op[$item['id']]['children']    = $children;
                }
            }
        }
        return $op;
    }

    public static function printMenuTree($tree, $ULID = null, $ULClass = null, $profile = false) {
        $html = "";
        if (!is_null($tree) && count($tree) > 0) {
            $html.='<ul id="' . $ULID . '" class="' . $ULClass . '">';

            if ($profile):
                $html.='<li class="nav-header">
                        <div class="dropdown profile-element"> <span>                            
                            <!--<img height="48" width="48" alt="image" class="img-circle" src="' . Yii::$app->user->getProfilePicture() . '" />-->
                        </span>
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">' . Yii::$app->user->getFullName() . '<b class="caret"></b></strong></span></span> 
                        </a>
                        <ul class="dropdown-menu m-t-xs">                            
                            <li><a href="' . \yii\helpers\Url::to(['users/profile']) . '">Profile</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        <img height="48" width="48" alt="image" class="img-circle" src="' . Yii::$app->user->getProfilePicture() . '" />
                    </div>
                </li>';
            endif;

            foreach ($tree as $node) {

                $activeClass = !empty($node['active']) ? "active" : "";
                $html.='<li class="' . $activeClass . '">';
                $html.='<a href="' . $node["url"] . '">';
                if (empty($node["parent_id"])):
                    $html.='<i class="' . $node["menu_icon"] . '"></i>';
                    $html.='<span class="nav-label">' . $node["menu_title"] . '</span>';
                else:
                    $html.= $node["menu_title"];
                endif;

                if (!empty($node['children'])):
                    $html.='<span class="fa arrow"></span>';
                endif;

                $html.='</a>';
                if (!empty($node['children'])):
                    $html.= self::printMenuTree($node['children'], null, $node["level_class"]);
                endif;
                $html.='</li>';
            }
            $html.= '</ul>';
            return $html;
        }
    }

}
