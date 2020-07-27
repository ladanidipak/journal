<?php 
use backend\vendors\Common;
?>
<div id="flash-message">    
    <?php
    foreach (Yii::$app->session->getAllFlashes() as $class => $message) {
        if($class == "error") $class = "danger";
        echo "<br />"; echo Common::getMessage($class, $message) . "\n";
    }
    ?>
</div>