<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use app\models\MenuMaster;
use backend\models\VolIss;
?>
<?php
$volissue = VolIss::findCurrentIssue();
?>
<nav role="navigation" class="navbar-default navbar-static-side">
    <div class="sidebar-collapse">        
        <?php echo MenuMaster::printMenuTree($menusArr, "side-menu", "nav metismenu",$profile=true); ?>
    </div>
</nav> 