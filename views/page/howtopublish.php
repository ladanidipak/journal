<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div role="main" class="main">
    <section class="page-header page-header-color page-header-primary page-header-float-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-xs"><?= $content->page_title; ?></h1>
                    <ul class="breadcrumb breadcrumb-valign-mid">
                        <li><a href="index.php">Home</a></li>
                        <li class="active"><?= "Publication Procedure" ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="row">
            <!---col-md-4--->
            <div class="col-md-4">
                <!---cover--->
                <div class="cover">
                    <a href="http://www.academicpedsjnl.net" target="_blank" title="View Articles published in Academic Pediatrics">
                        <!--<img class="cover-img" src="https://www.elsevier.com/__data/cover_img/717484.gif" alt="View Articles published in Academic Pediatrics" itemprop="image">-->
                    </a>
                    <br>
                    <div class="issn keyword">
                        ISSN: <span>1876-2859</span>
                    </div>
                </div>
                <hr>
                <!---/cover--->
                <!---/accord--->
                <div class="panel-group panel-group-primary" id="accordion2Primary">
                    <!--one-->

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" href="<?= Yii::$app->params['webUrl'] ?>/how-to-publish-an-article">
                                    Publication Flow Chart
                                </a>
                            </h4>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" id="submit_script" href="#">Publication Procedure</a>
                            </h4>
                        </div>
                    </div>
                </div>
                <!---/accord--->
            </div>
            <!---/col-md-4--->
            <!---col-md-8--->
            <div class="col-md-8">
                <h3 id='title_text'>Publication Flow Chart</h3>
                <div class="row image_content">
                    <img src="<?= Yii::$app->params['imageUrl'] ?>journals_submission_process.png">
                </div>
                <div class="row hide">
                    <div class="col-md-12">
                        <?= $content->content; ?>
                    </div>
                </div>
                <div class="row">
                    <br>
                </div>
            </div>
            <!---/col-md-8--->
        </div>
    </div>

    <style>
        .max-width-767{
            max-width:600px;
            margin:auto;
        }
    </style>
</div>
<script>
    $(document).ready(function () {
        $('#submit_script').click(function () {
            $('.image_content').html($('.hide').html());
            $('#title_text').text($(this).text());
        });
    });
</script>
