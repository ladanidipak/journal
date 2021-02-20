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

                <div class="row">
                    <?= $form->field($model, 'full_name')->textInput(['maxlength' => 100]) ?>

                    <?= $form->field($model, 'priority')->checkbox() ?>

                    <?= $form->field($model, 'hide_in_list')->checkbox() ?>
                </div>

                <div class="row">
                    <?= $form->field($model, 'phone')->textInput(['maxlength' => 15]) ?>
                    <?php
                    $desigArray = backend\models\Designation::getDesignations();
                    if (!$model->isNewRecord && !in_array($model->designation, $desigArray)) {
                        $model->desigDrop = "Other";
                        $model->desigInput = $model->designation;
                    } else {
                        $model->desigDrop = $model->designation;
                    }
                    ?>
                    <?= $form->field($model, 'desigDrop')->dropDownList($desigArray,  Common::getDropDownOptions($model, 'designation')) ?>
                    <?= $form->field($model, 'desigInput')->textInput(['maxlength' => 100]) ?>
                    <?= $form->field($model, 'designation')->hiddenInput()->label(false)->error(FALSE) ?>

                </div>

                <div class="row">
                    <?= $form->field($model, 'institute_name')->textInput(['maxlength' => 150]) ?>
                    <?= $form->field($model, 'branch_id')->dropDownList(backend\models\Branch::getBranches(), Common::getDropDownOptions($model, 'branch_id')) ?>
                    <?= $form->field($model, 'branch_name')->textInput(['maxlength' => 255]) ?>
                </div>

                <div class="row">
                    <?= $form->field($model, 'max_article')->dropDownList($model::$maxArticleArray, Common::getDropDownOptions($model, 'max_article')) ?>
                    <?= $form->field($model, 'email')->textInput(['maxlength' => 100]) ?>
                    <?= $form->field($model, 'address')->textarea(['maxlength' => 255]) ?>
                </div>

                <div class="row">
                    <?= $form->field($model, 'city')->textInput(['maxlength' => 50]) ?>
                    <?= $form->field($model, 'state')->textInput(['maxlength' => 100]) ?>
                    <?= $form->field($model, 'country')->dropDownList(backend\models\Country::getCountries(),  Common::getDropDownOptions($model, 'country')) ?>
                </div>

                <div class="row">
                    <?= $form->field($model, 'specialization')->textInput(['maxlength' => 255]) ?>
                    <?php
                    $qualiArray = backend\models\Qualification::getQualifications();
                    if ($model->qualification != "" && !in_array($model->qualification, $qualiArray)) {
                        $model->qualiDrop = "Others";
                        $style = "display:block";
                    } else {
                        $model->qualiDrop = $model->qualification;
                        $style = "display:none";
                    }
                    ?>
                    <?= $form->field($model, 'qualiDrop')->dropDownList($qualiArray,  Common::getDropDownOptions($model, 'qualiDrop')) ?>
                    <?= $form->field($model, 'qualification', ['options' => ['style' => "$style"]])->textInput(['maxlength' => 100])->label('Qualification (Other)') ?>
                </div>

                <div class="row">

                    <?= $form->field($model, 'show_in_reviewer')->checkbox() ?>

                    <?= $form->field($model, 'show_in_editor')->checkbox() ?>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'cv', ['options' => ['class' => 'col-sm-12']])->fileInput()->label('Upload Your CV') ?>
                        <?= Html::a($model->cv, DOCURL . "uploads/cv/" . $model->cv, ['target' => '_blank']) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'editor_consent_form', ['options' => ['class' => 'col-sm-12']])->fileInput()->label('Upload Your Editor Consent Form <a download href="' . DOCURL . "design_elements/documents/Editor_Consent_Form_GRD_Journals.doc" . '">Download Editor Consent Form </a>') ?>
                        <?= Html::a($model->editor_consent_form, DOCURL . "uploads/editor_consent_form/" . $model->editor_consent_form, ['target' => '_blank']) ?>
                    </div>

                    <div class="col-sm-4">
                        <?= $form->field($model, 'profile_pic', ['options' => ['class' => 'col-sm-12']])->fileInput()->label('Upload Profile Pic') ?>
                        <?= Html::img(DOCURL . "uploads/reviewer_pic/" . $model->profile_pic, ['style' => 'width:200px;height:auto;']) ?>
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