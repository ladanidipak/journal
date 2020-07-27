<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $model backend\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="heading heading-border heading-middle-border heading-middle-border-center center">
        <h2><span class="text-color-secondary">GRD JOURNAL FOR ENGINEERING</span><span class="text-color-primary"> | GRDJE | </span><span class="text-color-secondary">ISSN 2455-5703</span></h2>
    </div>
    <hr>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => 'col-md-12 bold'], 'checkboxTemplate' => "<label class=\"control-label bold\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>
      <h2>Author Details</h2>
        <div class="row"><hr></div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'article_title')->textInput(['maxlength' => 255]) ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'author_name')->textInput(['maxlength' => 255]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'research_area')->textInput(['maxlength' => 255]) ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'a_org')->textInput(['maxlength' => 100]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'a_type_id')->dropDownList(backend\models\ArticleType::getTypes(), Common::getDropDownOptions($model, 'a_type_id')) ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'a_email')->textInput(['maxlength' => 100]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'branch_id')->dropDownList(backend\models\Branch::getBranches(), Common::getDropDownOptions($model, 'branch_id')) ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'a_phone')->textInput(['maxlength' => 10]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'keyword')->textInput(['maxlength' => 255]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'abstract')->textarea(['rows' => 6]) ?>
            </div>
        </div>

        <div class="row">
            <?= $form->field($model, 'branch_name')->textInput(['maxlength' => 255]) ?>
        </div>
        <div class="row"><hr></div>

        <div class="row">
          <h2><div class="col-sm-12">Co-Author Details</div></h2>
        </div>
        <div class="row"><hr></div>
        <div class="row">
            <div class="col-md-1"><label class="control-label"><b>1</b></label></div>

            <?= $form->field($coa['coa1'], '[coa1]name', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Name'])->label(false) ?>
            <?= $form->field($coa['coa1'], '[coa1]org', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Institute/Organization'])->label(false) ?>
            <?= $form->field($coa['coa1'], '[coa1]email', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Email'])->label(false) ?>
        </div>
        <div class="row">
            <div class="col-md-1"><label class="control-label"><b>2</b></label></div>
            <?= $form->field($coa['coa2'], '[coa2]name', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Name'])->label(false) ?>
            <?= $form->field($coa['coa2'], '[coa2]org', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Institute/Organization'])->label(false) ?>
            <?= $form->field($coa['coa2'], '[coa2]email', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Email'])->label(false) ?>
        </div>
        <div class="row">
            <div class="col-md-1"><label class="control-label"><b>3</b></label></div>
            <?= $form->field($coa['coa3'], '[coa3]name', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Name'])->label(false) ?>
            <?= $form->field($coa['coa3'], '[coa3]org', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Institute/Organization'])->label(false) ?>
            <?= $form->field($coa['coa3'], '[coa3]email', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Email'])->label(false) ?>
        </div>
        <div class="row">
            <div class="col-md-1"><label class="control-label"><b>4</b></label></div>
            <?= $form->field($coa['coa4'], '[coa4]name', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Name'])->label(false) ?>
            <?= $form->field($coa['coa4'], '[coa4]org', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Institute/Organization'])->label(false) ?>
            <?= $form->field($coa['coa4'], '[coa4]email', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Email'])->label(false) ?>
        </div>

        <div class="row"><hr></div>
        <div class="row">
          <h2> <div class="col-sm-12">Postal Address</div></h2>
        </div>
        <div class="row"><hr></div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'addr_1')->textInput(['maxlength' => 255]) ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'zip')->textInput(['maxlength' => 6]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'addr_2')->textInput(['maxlength' => 255]) ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'state')->textInput(['maxlength' => 100]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'city')->textInput(['maxlength' => 100]) ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'country')->dropDownList(backend\models\Country::getCountries(), Common::getDropDownOptions($model, 'country')) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'article_file')->fileInput() ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'source')->dropDownList($model->getSourceArray($model->source), Common::getDropDownOptions($model, 'source')) ?>
            </div>
        </div>
        <div class="row">
            <?= $form->field($model, 'source_specify')->textInput(['maxlength' => 100])->label('Specify', ['id' => 'source-label']) ?>
        </div>

        <div class="row">&nbsp;</div>
        <div class="row">
            <?php Yii::$app->session->set('__captcha/page/captcha', null); ?>
            <?= $form->field($model, 'verifyCode', ['options' => ['class' => 'col-sm-4']])->widget(yii\captcha\Captcha::className(), ['captchaAction' => 'page/captcha']) ?>
        </div>

        <div class="row">
            <div class="form-group col-sm-4">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary pull-left']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$this->registerJs("$(document).ready(function(){
        $('#article-branch_id ,#article-a_type_id, #article-country, #article-source').addClass('form-control');
        $('#article-branch_id').change(function(){
           if($('#article-branch_id option:selected').text() == 'Other') {
               $('#article-branch_name').parent().show();
           }else{
               $('#article-branch_name').parent().hide();
           }
        });
        $('#article-branch_id').trigger('change');

        $('#article-source').change(function(){
            var article_source = $('#article-source').val();
           if($.inArray(article_source,['Reference by a friend', 'References by professor', 'Other']) != -1) {
               if(article_source == 'Reference by a friend'){
                    $('#source-label').text('Friend\'s Name ');
               } else if(article_source == 'References by professor') {
                    $('#source-label').text('Professor\'s Name ');
               } else {
                    $('#source-label').text('Specify');
               }
               $('#article-source_specify').parent().show();
           }else{
               $('#article-source_specify').parent().hide();
               $('#article-source_specify').val('');
           }
        });
        $('#article-source').trigger('change');
    });", \yii\web\View::POS_END, 'otherbranch');
?>
