<?php

namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;

class AboutSideMenu extends Widget {

    public function init() {
        parent::init();
    }

    public function run() {
        return $this->render("about_side_menu");
    }

}

?>
