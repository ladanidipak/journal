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
$this->title = \backend\vendors\Common::getTitle(\backend\vendors\Common::getCurrentURL());
$this->beginContent('@app/views/layouts/noHeaderMainlayout.php');     
echo  $content; 
$this->endContent();
?>