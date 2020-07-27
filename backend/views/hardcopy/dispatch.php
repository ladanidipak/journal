<?php

use backend\vendors\Common;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model backend\models\Hardcopy */
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
            <div class="ibox-content hardcopy-form" style="display: block;">

                <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => 'col-sm-4'], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>

                <div class="row">

                    <?= $form->field($model, 'dispatched_date')->textInput(['readonly'=>'readonly']) ?>

                    <?= $form->field($model, 'dispatched_by')->textInput() ?>

                </div>

                <div class="row">

                    <?= $form->field($model, 'courier_name')->textInput(['maxlength' => 255]) ?>

                    <?= $form->field($model, 'tracking_no')->textInput(['maxlength' => 255]) ?>

                </div>

                <div class="row">

                    <?= $form->field($model, 'tracking_url')->textInput(['maxlength' => 255]) ?>

                </div>


                <div class="row">
                    <div class="hr-line-dashed"></div>
                    <div class="form-group col-sm-12">
                        <?= Html::submitButton($model->isNewRecord ? (common::translateText("CREATE_BTN_TEXT")) : (common::translateText("UPDATE_BTN_TEXT")), ['class' => $model->isNewRecord ? 'btn btn-primary pull-left' : 'btn btn-primary pull-left']) ?>
                        <a class="btn btn-white pull-left"
                           onclick="location.href = '<?= Url::to(['index']) ?>'"><?= common::translateText("CANCEL_BTN_TEXT") ?></a>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJs('
$(document).ready(function(){
        $(\'#hardcopy-dispatched_date\').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            format: "dd/mm/yyyy"
        });
    });
',View::POS_READY);
?>