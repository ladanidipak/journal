<?php

use backend\models\EditorialBoard;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $model backend\models\BoardCertificatesLogs */
/* @var $form yii\widgets\ActiveForm */

$pageTitle = Common::getTitle("{$this->context->id}/{$this->context->action->id}");
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>
                    <?= $pageTitle ?>
                </h5>
            </div>
            <div class="ibox-content board-certificates-logs-form" style="display: block;">

                <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => ''], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>

                <div class="row">
                    <div class="col-sm-3">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => 75]) ?>
                    </div>

                    <div class="col-sm-3">
                        <?= $form->field($model, 'board_member')->dropDownList(ArrayHelper::map(EditorialBoard::find()->all(), 'id', 'full_name')) ?>

                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($model, 'recognize')->textInput(['maxlength' => 75]) ?>
                    </div>

                    <div class="col-sm-3">
                        <?= $form->field($model, 'date_on_certificate')->textInput(['maxlength' => 75]) ?>
                    </div>
                </div>

                <div class="row">

                    <div class="col-sm-8">
                        <?= $form->field($model, 'to')->textInput(['maxlength' => 75]) ?>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <?= $form->field($model, 'subject')->textInput(['maxlength' => 75]) ?>
                    </div>
                </div>
                <div class="row">

                    <div class="col-sm-8">
                        <?= $form->field($model, 'body')->textarea(['rows' => 8]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="hr-line-dashed"></div>
                    <div class="form-group col-sm-12">
                        <a class="btn btn-white pull-right" onclick="location.href = '<?= Url::to(['index']) ?>'"><?= common::translateText("CANCEL_BTN_TEXT") ?></a>
                        <?= Html::submitButton($model->isNewRecord ? (common::translateText("CREATE_BTN_TEXT")) : (common::translateText("UPDATE_BTN_TEXT")), ['class' => $model->isNewRecord ? 'btn btn-primary pull-right' : 'btn btn-primary pull-right']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>