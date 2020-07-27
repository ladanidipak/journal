<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\vendors\Common;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$actionId = $this->context->action->id;
?>

<div role="main" class="main">

    <section class="page-header page-header-color page-header-primary page-header-float-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-xs">About Us <span>20 Years Caring About You</span></h1>
                    <ul class="breadcrumb breadcrumb-valign-mid">
                        <li><a href="/">Home</a></li>
                        <li><a href="/grdje">GRDJE</a></li>
                        <li class="active"><?= $content->page_title ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="col-md-4">
            <?= \app\components\AboutSideMenu::widget(); ?>
        </div>
        <div class="col-md-8">
            <div class="heading heading-border heading-middle-border heading-middle-border-center center">
                <h2><span class="text-color-secondary">GRD JOURNAL FOR ENGINEERING RESEARCH AREA</span></h2>
            </div>
            <hr>
            <?= $content->content; ?>
        </div>
    </div>

</div>