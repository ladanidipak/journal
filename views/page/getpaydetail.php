<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\vendors\Common;

/* @var $this yii\web\View */
?>
<div role="main" class="main">

    <section class="page-header page-header-color page-header-primary page-header-float-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-xs">GET PAYMENT DETAIL</span></h1>
                    <ul class="breadcrumb breadcrumb-valign-mid">
                        <li><a href="/">Home</a></li>
                        <li class="active">GET PAYMENT DETAIL</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="heading heading-border heading-middle-border heading-middle-border-center center">
                <h2><span class="text-color-secondary">GET PAYMENT DETAIL</span></h2>
            </div>
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => 'col-sm-8'], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>
            <div class="col-md-4"></div>
            <div class="col-md-6 center">
                <form class="form">
                    <div class="form-group ">
                        <?= $form->field($model, 'paper_id')->textInput(['maxlength' => 100]) ?> </div>
                    <div class="form-group ">

                         <?= $form->field($model, 'a_email')->textInput(['maxlength' => 100]) ?>

                    </div>
                    <div class="form-group ">
                        <?= $form->field($model, 'verifyCode', ['options' => ['class' => 'col-sm-4']])->widget(yii\captcha\Captcha::className(), ['captchaAction' => 'page/captcha']) ?>
                    </div>
                    <div class="form-group col-sm-5">
                        <?= Html::submitButton('<b>Proceed</b>', ['class' => ' btn btn-primary pull-left']) ?>
                    </div>
                </form>
            </div>
            <div class="col-md-4"></div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
$this->registerJs("$(document).ready(function(){
        $('input[name*=\"paid_online\"]').change(function(){
            $('.payoff').hide();
            $('.paypayu').hide();
           if($('input[name*=\"paid_online\"]:checked').val() == '0') {
               $('.payoff').show();
           }else{
               $('.paypayu').show();
           }
        });
    });", \yii\web\View::POS_END, 'otherdesig');
?>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','../../../www.google-analytics.com/analytics.js','ga');
    
    ga('create', 'UA-42715764-5', 'auto');
    ga('send', 'pageview');
</script>