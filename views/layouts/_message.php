<?php
use yii\web\View;
$showPopup = false;
foreach (Yii::$app->session->getAllFlashes() as $class => $message) {
    $showPopup = true;
    echo $message."<br>";
}
if($showPopup){
    $this->registerJs("$('#notification-modal').modal('show');",View::POS_READY,'notification-popup');
}

