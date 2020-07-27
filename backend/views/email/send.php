<?php

use backend\vendors\Common;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $model backend\models\EmailMaster */

$this->registerCssFile("@web/design_elements/css/plugins/clockpicker/clockpicker.css", ['position' => View::POS_HEAD, 'depends' => 'backend\assets\AppAsset']);
$this->registerJsFile("@web/design_elements/js/plugins/clockpicker/clockpicker.js", ['position' => View::POS_END, 'depends' => 'backend\assets\AppAsset']);
?>

<div class="row email-master-index">
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?= Html::encode(Common::getTitle("{$this->context->id}/{$this->context->action->id}")) ?>
                    - <?= $email->subject ?></h5>

                <div class="ibox-tools">

                </div>
            </div>
            <div class="ibox-content">
                <div class="row m-b-sm m-t-sm">

                </div>
                <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => 'col-sm-4'], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>
                <div class="row">
                    <?= $form->field($model, 'id_from')->textInput(['maxlength' => 11]) ?>
                    <?= $form->field($model, 'id_to')->textInput(['maxlength' => 11]) ?>
                </div>
                <!--<h4> Schedule Email </h4>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" value="" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div data-autoclose="true" class="input-group clockpicker">
                            <input type="text" value="00:00" class="form-control">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                        </div>
                    </div>
                </div>-->
                <div class="row">
                    <div class="hr-line-dashed"></div>
                    <div class="form-group col-sm-12">
                        <?= Html::submitButton('Send', ['class' => 'btn btn-primary pull-left']) ?>
                        <a class="btn btn-white pull-left"
                           onclick="location.href = '<?= Url::to(['index']) ?>'"><?= common::translateText("CANCEL_BTN_TEXT") ?></a>

                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?= Html::encode(Common::getTitle("{$this->context->id}/{$this->context->action->id}")) ?>
                    - <?= $email->subject ?></h5>
            </div>
            <?php
            $model->scenario = "send_list";
            ?>
            <div class="ibox-content">
                <?php $form2 = ActiveForm::begin(['enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => 'col-sm-4'], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>
                <div class="row">
                    <?= $form2->field($model, 'list_id')->dropDownList(\backend\models\ContactList::getList(),Common::getDropDownOptions($model,'list_id')); ?>
                </div>
                <div class="row">
                    <div class="hr-line-dashed"></div>
                    <div class="form-group col-sm-12">
                        <?= Html::submitButton('Send', ['class' => 'btn btn-primary pull-left']) ?>
                        <a class="btn btn-white pull-left"
                           onclick="location.href = '<?= Url::to(['index']) ?>'"><?= common::translateText("CANCEL_BTN_TEXT") ?></a>

                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
<div class="row email-master-index">

</div>
