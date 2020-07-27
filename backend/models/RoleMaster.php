<?php

namespace app\models;

use Yii;
use backend\vendors\Common;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "role_master".
 *
 * @property integer $id
 * @property string $role_title
 * @property integer $is_deleted
 * @property integer $created_dt
 * @property integer $created_by
 * @property integer $updated_dt
 * @property integer $updated_by
 */
class RoleMaster extends \yii\db\ActiveRecord {

    const SUPER_ADMIN = 1;
    const PARTNER = 2;
    const CUSTOMER = 3;
    const WHOLE_SALER = 4;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'role_master';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['role_title'], 'required'],
            [['is_deleted', 'created_dt', 'created_by', 'updated_dt', 'updated_by'], 'integer'],
            [['role_title'], 'string', 'max' => 128]
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->updated_dt = Common::datetimeTimestamp();
            $this->updated_by = Yii::$app->user->identity->id;
            if($insert){
                $this->created_dt = Common::datetimeTimestamp();
                $this->created_by = Yii::$app->user->identity->id;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'role_title' => 'Role Title',
            'is_deleted' => 'Is Deleted',
            'created_dt' => 'Created Date',
            'created_by' => 'Created By',
            'updated_dt' => 'Updated Date',
            'updated_by' => 'Updated By',
        ];
    }

    public static function getRolesList() {
        return ArrayHelper::map(self::getRoles(), 'id', 'role_title');
    }

    public static function getRoles() {
        return self::find()->all();
    }

    public static function printMenuTree($tree, $selected = array()) {
        $html = "";
        //common::p($tree,true);
        if (!is_null($tree) && count($tree) > 0) {
            $html.='<ul>';
            foreach ($tree as $node) {
                $html.='<li id="' . $node["id"] . '" class="jstree-open" >';
                $class = in_array($node["id"], $selected) ? "jstree-clicked" : "";
                @$class = (count($node['children']) > 0)?"":$class;
                $html.='<a href="#" class="' . $class . '"><span class="nav-label">' . $node["menu_title"]. '</span></a>';                
                if (!empty($node['children'])):
                    $html.= self::printMenuTree($node['children'], $selected);
                endif;
                $html.='</li>';
            }
            $html.= '</ul>';
            return $html;
        }
    }
    
    public static function nestableMenuTree($tree){
        $html = "";
        if (!is_null($tree) && count($tree) > 0) {
            $html.='<ol class="dd-list">';
            foreach ($tree as $node) {
                $html.='<li data-id="' . $node["id"] . '" class="dd-item" >';
                $html.='<div class="dd-handle">' . $node["menu_title"]. '</div>';                
                if (!empty($node['children'])):
                    $html.= self::nestableMenuTree($node['children']);
                endif;
                $html.='</li>';
            }
            $html.= '</ol>';
            return $html;
        }
    }

}
