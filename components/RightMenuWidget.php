<?php

namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;

class RightMenuWidget extends Widget {

    public function init() {
        parent::init();
    }

    public function run() {
        return $this->render("right_menu");
    }

}

?>
