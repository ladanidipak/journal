<?php

use yii\helpers\Url;

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
                        <li><a href="/">Home</a></li>
                        <li class="active"><?= $content->page_title; ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="row">
            <div class="heading heading-border heading-middle-border heading-middle-border-center center">
                <h2><span class="text-color-secondary"><?= $content->page_title; ?></span></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="alert alert-primary" style="margin-bottom:0;">
                    <strong>Past Issues</strong> 
                </div>
                <blockquote class="with-borders">
                    <ul class="list list-icons list-primary list-borders">
                        <?php foreach ($conferences as $conf): ?>
                            <?php
                            $conf_id = 'GRDCF' . sprintf("%03d", $conf['id']);
                            ?>
                            <li>
                                <a class="artical_list" href='javascript:void(0)' dhref="<?= Url::to(['page/proceedings', 'id' => $conf_id,'special_issue'=>true]) ?>"><i class="fa fa-hand-o-right"></i><?= $conf['title'] ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </blockquote>
            </div>
            <div class="col-md-8">
                <div class='artical_detail'>
                </div>
            </div>
        </div>
    </div>
</div>
<script type='text/javascript'>
    function myFunction(url) {
        $.ajax({
            url: url,
            type: 'get',
            success: function (data) {
                $('.artical_detail').html($(data).find('.data'));
                $('.citation-link').click(function () {
                    var html = $(this).next().text();
                    $('#citation-modal .modal-body').html(html);
                    $('#citation-modal').modal('show');
                });
            }
        });
    }
    $(document).ready(function () {
        setTimeout(function () {
            $('.list-borders a').first().click();
        }, 100);
        $('.list-borders a').click(function () {
            myFunction($(this).attr('dhref'));
        });
    });
</script>
