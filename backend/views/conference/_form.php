<?php

use backend\vendors\Common;
use yii\bootstrap\ActiveForm;
use \backend\models\Conference;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Conference */
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
            <div class="ibox-content conference-form" style="display: block;">

                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'enableAjaxValidation' => false, 'layout' => 'default', 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => 'col-sm-8'], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>

                <div class="row">

                    <?= $form->field($model, 'conf_cor_name')->textInput(['maxlength' => 100]) ?>

                    <?= $form->field($model, 'email')->textInput(['maxlength' => 75]) ?>

                    <?= $form->field($model, 'org_name')->textInput(['maxlength' => 100]) ?>

                </div>

                <div class="row">

                    <?= $form->field($model, 'phone')->textInput(['maxlength' => 50]) ?>

                    <?= $form->field($model, 'org_website')->textInput(['maxlength' => 75]) ?>

                    <?= $form->field($model, 'dept_name')->textInput(['maxlength' => 75]) ?>

                </div>

                <div class="row">

                    <?= $form->field($model, 'aff_by')->textInput(['maxlength' => 75]) ?>

                    <?= $form->field($model, 'conf_type')->dropDownList(Conference::getConfTypeArray(), Common::getDropDownOptions($model, 'conf_type')) ?>

                    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

                </div>

                <div class="row">

                    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'short_name')->textInput(['maxlength' => 50]) ?>

                    <?= $form->field($model, 'conf_date')->textInput() ?>

                </div>

                <div class="row">

                    <?= $form->field($model, 'specialization')->textInput(['maxlength' => 255]) ?>

                    <?= $form->field($model, 'venue')->textInput(['maxlength' => 255]) ?>

                    <?= $form->field($model, 'conf_website')->textInput(['maxlength' => 75]) ?>

                    <?= $form->field($model, 'pub_date')->textInput(['readonly'=>'readonly']) ?>

                </div>
                <div class="row">&nbsp;</div>
                <div class="row">
                    <?= $form->field($model, 'brochure')->fileInput() ?>
                </div>
                <div class="row">
                    <div class="col-sm-8 field-article-article_file">
                        <?= Html::a($model->brochure,DOCURL."uploads/brochure/".$model->brochure,['target'=>'_blank'])?>
                    </div>
                </div>
                <div class="row">&nbsp;</div>

                <div class="row">
                    <?= $form->field($model, 'college_logo')->fileInput() ?>
                </div>
                <div class="row">
                    <div class="col-sm-8 field-article-article_file">
                        <?= Html::a($model->college_logo,DOCURL."uploads/college_logo/".$model->college_logo,['target'=>'_blank'])?>
                    </div>
                </div>
                <div class="row">&nbsp;</div>

                <div class="row">
                    <div class="hr-line-dashed"></div>
                    <div class="form-group col-sm-12">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary pull-left']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#conference-pub_date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            format: "dd/mm/yyyy"
        });
    });
</script>