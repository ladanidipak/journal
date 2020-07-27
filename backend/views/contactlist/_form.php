<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $model backend\models\ContactList */
/* @var $form yii\widgets\ActiveForm */

$pageTitle = Common::getTitle("{$this->context->id}/{$this->context->action->id}");
?>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>
                        <?= $pageTitle?>
                    </h5>
                </div>
                <div class="ibox-content contact-list-form" style="display: block;">

                        <?php $form = ActiveForm::begin(['enableAjaxValidation'=>false,'enableClientValidation'=>true,'fieldConfig'=>['options'=>['class'=>'col-sm-4'],'checkboxTemplate'=>"<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>

                    <div class="row">

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

</div>

                        
                        <div class="row">
                            <div class="hr-line-dashed"></div>
                            <div class="form-group col-sm-12">
                                    <a class="btn btn-white pull-right" onclick="location.href = '<?= Url::to(['index']) ?>'"><?=common::translateText("CANCEL_BTN_TEXT")?></a>
                                    <?= Html::submitButton($model->isNewRecord ? (common::translateText("CREATE_BTN_TEXT")) : (common::translateText("UPDATE_BTN_TEXT")), ['class' => $model->isNewRecord ? 'btn btn-primary pull-right' : 'btn btn-primary pull-right']) ?>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
