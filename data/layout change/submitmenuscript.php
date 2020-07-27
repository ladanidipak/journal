<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $model backend\models\Article */
/* @var $form yii\widgets\ActiveForm */
$pageTitle = Common::getTitle("{$this->context->id}/{$this->context->action->id}");
?>

    <div class="features_items prit_items"><!--features_items-->
        <h2 class="title text-center">Submit Menu Script Online</h2>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">

                    <div class="ibox-content article-form" style="display: block;">
                        <?php $form = ActiveForm::begin(['options'=>['enctype' => 'multipart/form-data'],'enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => 'col-sm-8'], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>

                        <div class="row">
                            <?= $form->field($model, 'article_title')->textInput(['maxlength' => 255]) ?>
                        </div>
                        <div class="row">
                            <?= $form->field($model, 'research_area')->textInput(['maxlength' => 255]) ?>
                        </div>

                        <div class="row">

                            <?= $form->field($model, 'a_type_id')->dropDownList(backend\models\ArticleType::getTypes(),  Common::getDropDownOptions($model, 'a_type_id')) ?>
                        </div>
                        <div class="row">
                            <?= $form->field($model, 'branch_id')->dropDownList(backend\models\Branch::getBranches(),  Common::getDropDownOptions($model, 'branch_id')) ?>
                        </div>
                        <div class="row">
                            <?= $form->field($model, 'branch_name')->textInput(['maxlength' => 255]) ?>

                        </div>

                        <div class="row">

                            <?= $form->field($model, 'keyword')->textInput(['maxlength' => 255]) ?>
                        </div>
                        <div class="row">
                            <?= $form->field($model, 'abstract')->textarea(['rows' => 6]) ?>
                        </div>
                        
                        <div class="row">&nbsp;</div>
                        <div class="row">
                            <div class="col-sm-12">Author Details</div>
                        </div>
                        <div class="row">&nbsp;</div>
                        
                        <div class="row">
                            <?= $form->field($model, 'author_name')->textInput(['maxlength' => 255]) ?>

                        </div>

                        <div class="row">

                            <?= $form->field($model, 'a_org')->textInput(['maxlength' => 100]) ?>
                        </div>
                        <div class="row">
                            <?= $form->field($model, 'a_email')->textInput(['maxlength' => 100]) ?>
                        </div>
                        <div class="row">
                            <?= $form->field($model, 'a_phone')->textInput(['maxlength' => 10]) ?>

                        </div>

                        
                        <div class="row">
                            <div class="col-sm-12">Co-Author Details</div>
                        </div>
                        <div class="row">&nbsp;</div>
                        <div class="row">
                            <div class="col-sm-1"><label class="control-label">1</label></div>
                            
                            <?= $form->field($coa['coa1'], '[coa1]name',['options'=>['class'=>'col-sm-3']])->textInput(['maxlength' => 100,'placeholder'=>'Name'])->label(false) ?>
                            <?= $form->field($coa['coa1'], '[coa1]org',['options'=>['class'=>'col-sm-3']])->textInput(['maxlength' => 100,'placeholder'=>'Institute/Organization'])->label(false) ?>
                            <?= $form->field($coa['coa1'], '[coa1]email',['options'=>['class'=>'col-sm-3']])->textInput(['maxlength' => 100,'placeholder'=>'Email'])->label(false) ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-1"><label class="control-label">2</label></div>
                            <?= $form->field($coa['coa2'], '[coa2]name',['options'=>['class'=>'col-sm-3']])->textInput(['maxlength' => 100,'placeholder'=>'Name'])->label(false) ?>
                            <?= $form->field($coa['coa2'], '[coa2]org',['options'=>['class'=>'col-sm-3']])->textInput(['maxlength' => 100,'placeholder'=>'Institute/Organization'])->label(false) ?>
                            <?= $form->field($coa['coa2'], '[coa2]email',['options'=>['class'=>'col-sm-3']])->textInput(['maxlength' => 100,'placeholder'=>'Email'])->label(false) ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-1"><label class="control-label">3</label></div>
                            <?= $form->field($coa['coa3'], '[coa3]name',['options'=>['class'=>'col-sm-3']])->textInput(['maxlength' => 100,'placeholder'=>'Name'])->label(false) ?>
                            <?= $form->field($coa['coa3'], '[coa3]org',['options'=>['class'=>'col-sm-3']])->textInput(['maxlength' => 100,'placeholder'=>'Institute/Organization'])->label(false) ?>
                            <?= $form->field($coa['coa3'], '[coa3]email',['options'=>['class'=>'col-sm-3']])->textInput(['maxlength' => 100,'placeholder'=>'Email'])->label(false) ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-1"><label class="control-label">4</label></div>
                            <?= $form->field($coa['coa4'], '[coa4]name',['options'=>['class'=>'col-sm-3']])->textInput(['maxlength' => 100,'placeholder'=>'Name'])->label(false) ?>
                            <?= $form->field($coa['coa4'], '[coa4]org',['options'=>['class'=>'col-sm-3']])->textInput(['maxlength' => 100,'placeholder'=>'Institute/Organization'])->label(false) ?>
                            <?= $form->field($coa['coa4'], '[coa4]email',['options'=>['class'=>'col-sm-3']])->textInput(['maxlength' => 100,'placeholder'=>'Email'])->label(false) ?>
                        </div>
                        
                        <div class="row">&nbsp;</div>
                        <div class="row">
                            <div class="col-sm-12">Postal Address</div>
                        </div>
                        <div class="row">&nbsp;</div>
                        
                        <div class="row">

                            <?= $form->field($model, 'addr_1')->textInput(['maxlength' => 255]) ?>
                        </div>
                        <div class="row">
                            <?= $form->field($model, 'addr_2')->textInput(['maxlength' => 255]) ?>
                        </div>
                        <div class="row">
                            <?= $form->field($model, 'city')->textInput(['maxlength' => 100]) ?>

                        </div>

                        <div class="row">

                            <?= $form->field($model, 'zip')->textInput(['maxlength' => 6]) ?>
                        </div>
                        <div class="row">
                            <?= $form->field($model, 'state')->textInput(['maxlength' => 100]) ?>
                        </div>
                        <div class="row">
                            <?= $form->field($model, 'country')->dropDownList(backend\models\Country::getCountries(),  Common::getDropDownOptions($model, 'country')) ?>

                        </div>

                        <div class="row">&nbsp;</div>
                        <div class="row">

                            <?= $form->field($model, 'article_file')->fileInput() ?>
                        </div>
                        
                        <div class="row">&nbsp;</div>
                        <div class="row">
<!--                            <div class="col-sm-12 p-captcha-div">
                                <div class="g-recaptcha" data-sitekey="6LcWhAsTAAAAAEVsOBNUWLEBzTrymPLUL0FB-CrO"></div>
                                <p class="help-block help-block-error">Please Verify Captcha.</p>
                            </div>-->
                                <?= $form->field($model, 'verifyCode',['options'=>['class'=>'col-sm-4']])->widget(yii\captcha\Captcha::className(),['captchaAction'=>'page/captcha']) ?>
                        </div>
                        
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
    </div><!--features_items-->
<!--<script>
    function checkcaptcha(){
        if(document.querySelector('.g-recaptcha-response').value != ""){
            $('.p-captcha-div').removeClass('has-error');
            return true;
        }else{
            $('.p-captcha-div').addClass('has-error');
            return false;
        }
    }
</script>-->
<?php


