<?php
use backend\assets\AppAsset;
use common\models\Common;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\base\Widget;

/* @var $this \yii\web\View */
/* @var $content string */
AppAsset::register($this);
$this->beginContent('@app/views/layouts/errorMain.php');     
echo  $content; 
$this->endContent();
?>