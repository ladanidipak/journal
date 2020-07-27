<?php

namespace app\models;

use app\models\MenuMaster;
use Yii;

/**
 * This is the model class for table "group_rights".
 *
 * @property integer $group_id
 * @property integer $menu_id
 */
class GroupRights extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'group_rights';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['group_id', 'menu_id'], 'required'],
            [['group_id', 'menu_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'group_id' => 'Group ID',
            'menu_id' => 'Menu ID',
        ];
    }

    public function getMenus() {
        return $this->hasOne(MenuMaster::className(), ['id' => 'menu_id']);
    }

    public function getRolePermissions($user_group) {        
        return self::findAll(["group_id" => $user_group], ["with" => "menus"]);        
    }

}
