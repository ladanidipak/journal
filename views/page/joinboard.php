<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div role="main" class="main">
    <section class="page-header page-header-color page-header-primary page-header-float-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-xs">JOIN EDITORIAL BOARD</span></h1>
                    <ul class="breadcrumb breadcrumb-valign-mid">
                        <li><a href="#">Home</a></li>
                        <li class="active">JOIN EDITORIAL BOARD</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="row">
            <div class="heading heading-border heading-middle-border heading-middle-border-center center">
                <h2><span class="text-color-secondary">JOIN EDITORIAL BOARD</span></h2>
            </div>
        </div>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => ''], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>
        <div class="row">
            <div class="col-lg-6">
                <label>&nbsp;</label>
                <div class="form-group">
                    <?= $form->field($model, 'full_name')->textInput(['maxlength' => 100, 'placeholder' => "Full Name"]) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'desigDrop')->dropDownList(backend\models\Designation::getDesignations(),  Common::getDropDownOptions($model, 'designation')) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'desigInput')->textInput(['maxlength' => 100]) ?>
                    <?= $form->field($model, 'designation')->hiddenInput()->label(false)->error(FALSE) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'specialization')->textInput(['maxlength' => 255]) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => 100]) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'institute_name')->textInput(['maxlength' => 150]) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'city')->textInput(['maxlength' => 50]) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'country')->dropDownList(backend\models\Country::getCountries(),  Common::getDropDownOptions($model, 'country')) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'profile_pic')->fileInput()->label('Upload Profile Pic') ?>
                </div>
            </div>
            <div class="col-lg-6">
                <label>&nbsp;</label>
                <div class="form-group">
                    <?= $form->field($model, 'qualiDrop')->dropDownList(backend\models\Qualification::getQualifications(),  Common::getDropDownOptions($model, 'qualiDrop')) ?>
                    <?= $form->field($model, 'qualification', ['options' => ['style' => 'display:none;']])->textInput(['maxlength' => 100])->label('Qualification (Other)') ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'branch_id')->dropDownList(backend\models\Branch::getBranches(), Common::getDropDownOptions($model, 'branch_id')) ?>
                    <?= $form->field($model, 'branch_name')->textInput(['maxlength' => 255]) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'max_article')->dropDownList($model::$maxArticleArray, Common::getDropDownOptions($model, 'max_article'))->label("How Many articles we can send you to review per month? (You will be asked before we send the article)") ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'phone')->textInput(['maxlength' => 15]) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'address')->textarea(['maxlength' => 255]) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'state')->textInput(['maxlength' => 100]) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'cv')->fileInput()->label('Upload Your CV') ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'editor_consent_form')->fileInput()->label('Upload Your Editor Consent Form <a download style="padding-left:25px;" href="' . DOCURL . "design_elements/documents/Editor_Consent_Form_GRD_Journals.doc" . '">Download Editor Consent Form </a>') ?>
                </div>
                <div class="form-group">
                    <?php Yii::$app->session->set('__captcha/page/captcha', null); ?>
                    <?= $form->field($model, 'verifyCode', ['options' => ['class' => '']])->widget(yii\captcha\Captcha::className(), ['captchaAction' => 'page/captcha']) ?>
                </div>
            </div>
        </div>
        <div class="form-group"> <?= Html::submitButton('Submit', ['class' => 'btn btn-primary pull-left']) ?></div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
</div>
</div>
<?php
$this->registerJs("$(document).ready(function(){
    $('#editorialboard-qualidrop, #editorialboard-branch_id ,#editorialboard-desigdrop, #editorialboard-country, #editorialboard-max_article').addClass('form-control');
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