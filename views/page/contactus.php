<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div role="main" class="main">
    <section class="page-header page-header-color page-header-primary page-header-float-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-xs"><?= $content->page_title; ?></span></h1>
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
            <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'options' => ['enctype' => 'multipart/form-data'], 'enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['horizontalCssClasses' => ['offset' => '', 'wrapper' => 'col-sm-12'], 'options' => ['class' => 'col-sm-12'], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>
            <div class="col-md-6">
                <div class="form-group ">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => 100, 'placeholder' => $model->getAttributeLabel('name')])->label(false) ?>
                </div>
                <div class="form-group ">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => 100, 'placeholder' => $model->getAttributeLabel('email')])->label(false) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'verifyCode', ['options' => ['class' => 'col-sm-8']])->widget(yii\captcha\Captcha::className(), ['captchaAction' => 'page/captcha', 'options' => ['placeholder' => $model->getAttributeLabel('verifyCode'), 'class' => 'col-sm-12']])->label(false) ?>
                </div>  
            </div>
            <div class="col-md-6">
                <div class="form-group ">
                    <?= $form->field($model, 'subject')->textInput(['maxlength' => 20, 'placeholder' => $model->getAttributeLabel('subject')])->label(false) ?>
                </div>
                <div class="form-group ">
                    <?= $form->field($model, 'message')->textarea(['placeholder' => $model->getAttributeLabel('message')])->label(false) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'phone')->textInput(['maxlength' => 20, 'placeholder' => $model->getAttributeLabel('phone')])->label(false) ?>
                </div>
                <div class="form-group" style="margin-left: 30px;">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="row">
            <?= $content->content; ?>
        </div>
    </div>
</div>