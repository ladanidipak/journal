<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerCssFile(DOCURL . "design_elements/css/progress-tracker.css", ['position' => $this::POS_HEAD])
?>
<div role="main" class="main">
    <section class="page-header page-header-color page-header-primary page-header-float-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-xs">CHECK YOUR PAPER STATUS</span></h1>
                    <ul class="breadcrumb breadcrumb-valign-mid">
                        <li><a href="/">Home</a></li>
                        <li class="active">CHECK YOUR PAPER STATUS</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <?php if (!empty($p_status)) { ?>
            <div class="row">
                <div class="col-sm-10">
                    <ul class="progress-tracker custom-progress-tracker progress-tracker--text progress-tracker--center progress-tracker--spaced">
                        <li class="progress-step <?= ($p_step > 0) ? "is-complete" : ""; ?>">
                            <span class="progress-marker"></span>
                            <span class="progress-text">
                                <h4 class="progress-title">Received</h4>
                            </span>
                        </li>
                        <li class="progress-step <?= ($p_step > 1) ? "is-complete" : ""; ?>">
                            <span class="progress-marker"></span>
                            <span class="progress-text">
                                <h4 class="progress-title">Under Review</h4>
                                <?php if ($p_step == 2) { ?>
                                    <i class="progress-tooltip">Your paper is under review process. You will receive a email once the review is done.</i>
                                <?php } ?>
                            </span>
                        </li>
                        <li class="progress-step <?= ($p_step > 2) ? "is-complete" : ""; ?> <?= ($p_status == "rejected") ? "progress-mark-red" : "" ?>">
                            <span class="progress-marker"></span>
                            <span class="progress-text">
                                <h4 class="progress-title"><?= $p_status == "rejected" ? "Rejected" : "Accepted"; ?></h4>
                                <?php
                                if ($p_step == 3) {
                                    if ($p_status == "rejected") {
                                        echo '<i class="progress-tooltip">Your paper is Rejected. Please read the email of Reject status for the further procedure.</i>';
                                    } else {
                                        echo '<i class="progress-tooltip">Your paper is Accepted. Please read the email of Acceptance for the further procedure.</i>';
                                    }
                                }
                                ?>
                            </span>
                        </li>
                        <li class="progress-step <?= ($p_step > 3) ? "is-complete" : ""; ?>">
                            <span class="progress-marker"></span>
                            <span class="progress-text">
                                <h4 class="progress-title">Sent for Publication</h4>
                                <?php if ($p_step == 4) { ?>
                                    <i class="progress-tooltip">Your paper is sent for publication procedure. You will receive an email when it gets published.</i>
    <?php } ?>
                            </span>
                        </li>
                        <li class="progress-step <?= ($p_step > 4) ? "is-complete" : ""; ?>">
                            <span class="progress-marker"></span>
                            <span class="progress-text">
                                <h4 class="progress-title">Published</h4>
                                <?php if ($p_step == 5) { ?>
                                    <i class="progress-tooltip">Your paper has been published.</i>
    <?php } ?>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
<?php } ?>

        <div class="row">
            <div class="heading heading-border heading-middle-border heading-middle-border-center center">
                <h2><span class="text-color-secondary">CHECK YOUR PAPER STATUS</span></h2>
            </div>
            <div class="col-sm-4"></div>
            <div class="col-md-6">
                    <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => 'col-sm-8'], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>
                <div class="form-group ">
<?= $form->field($model, 'paper_id')->textInput(['maxlength' => 100]) ?>

                </div>
                <div class="form-group ">
<?= $form->field($model, 'a_email')->textInput(['maxlength' => 100]) ?>

                </div>
                <div class="form-group">
<?= $form->field($model, 'verifyCode', ['options' => ['class' => 'col-sm-4']])->widget(yii\captcha\Captcha::className(), ['captchaAction' => 'page/captcha']) ?>
                </div>
                <div class="form-group col-sm-4">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary pull-left']) ?>
                </div>
<?php ActiveForm::end(); ?>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</div>
<?php
$this->registerJs("$(document).ready(function(){
        $('#editorialboard-desigdrop').change(function(){
           if($(this).val() == 'Other') {
               $('#editorialboard-desiginput').parent().show();
           }else{
               $('#editorialboard-desiginput').parent().hide();
           }
        });
        $('#editorialboard-desigdrop').trigger('change');
        $('#editorialboard-desigdrop,#editorialboard-desiginput').change(function(){
            if($('#editorialboard-desigdrop').val() != 'Other'){
                $('#editorialboard-designation').val($('#editorialboard-desigdrop').val());
            }else{
                $('#editorialboard-designation').val($('#editorialboard-desiginput').val());
            }
        });
    });", \yii\web\View::POS_END, 'otherdesig');
?>