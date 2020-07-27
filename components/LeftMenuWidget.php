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
        return $this->render('left_menu');
    }

}

?>
