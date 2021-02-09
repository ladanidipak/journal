<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $model backend\models\EditorialBoard */
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
            <div class="ibox-content editorial-board-form" style="display: block;">

                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => 'col-sm-4'], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>

                <?= $form->field($model, 'CertificateText')->textInput(['maxlength' => 100]) ?>

                <div class="row">
                    <div class="hr-line-dashed"></div>
                    <div class="form-group col-sm-12">
                        <a class="btn btn-white pull-right" onclick="location.href = '<?= Url::to(['index']) ?>'"><?= common::translateText("CANCEL_BTN_TEXT") ?></a>
                        <?= Html::submitButton($model->isNewRecord ? (common::translateText("CREATE_BTN_TEXT")) : (common::translateText("SEND")), ['class' => $model->isNewRecord ? 'btn btn-primary pull-right' : 'btn btn-primary pull-right']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
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
<?php
$this->registerJs("$(document).ready(function(){
        $('#editorialboard-branch_id').change(function(){
           if($('#editorialboard-branch_id option:selected').text() == 'Other') {
               $('#editorialboard-branch_name').parent().show();
           }else{
               $('#editorialboard-branch_name').parent().hide();
           }
        });
        $('#editorialboard-branch_id').trigger('change');

         $('#editorialboard-qualidrop').change(function(){
           if($(this).val() == 'Others' || $(this).val() == 'Other') {
               $('#editorialboard-qualification').val('');
               $('#editorialboard-qualification').parent().show();
           }else{
               $('#editorialboard-qualification').val($(this).val());
               $('#editorialboard-qualification').parent().hide();
           }
        });
    });", \yii\web\View::POS_END, 'otherbranch');
?>