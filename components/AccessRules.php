<?php

namespace app\components;

use Yii;
use yii\filters\AccessRule;
use app\components\AccessRules;
use backend\vendors\common;

class AccessRules extends AccessRule {

    public static function getAccessRules() {
        $pageUrl = common::getCurrentUrl();
        return (common::checkActionAccess($pageUrl)) ? array(Yii::$app->controller->action->id) : array("");
    }

}
