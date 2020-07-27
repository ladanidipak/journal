<?php

use backend\vendors\Common;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\ConfPro;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div role="main" class="main">
    <section class="page-header page-header-color page-header-primary page-header-float-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-xs"><?= $content->page_title; ?></h1>
                    <ul class="breadcrumb breadcrumb-valign-mid">
                        <li><a href="#">Home</a></li>
                        <li class="active"><?= $content->page_title; ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="heading heading-border heading-middle-border heading-middle-border-center center">
                <h2><span class="text-color-secondary"><?= $content->page_title; ?></span></h2>
            </div>
        </div>
        <div class="row">
         <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'enableAjaxValidation' => false,
             'layout' => 'default', 
             'enableClientValidation' => true, 
             'fieldConfig' => ['options' => [], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>
             <div class="col-lg-6">
                <label>&nbsp;</label>
                <div class="form-group">
                    <label><b>Name of the Conference Coordinators:</b></label>
                    <?= $form->field($model, 'conf_cor_name')->textInput(['maxlength' => '100',"placeholder"=>"Name of the Conference Coordinators",'class'=>'form-control'])->label(false) ?>
                </div>
                <div class="form-group">
                    <label><b>University/College Name</b></label>
                    <?= $form->field($model, 'org_name')->textInput(['maxlength' => 100,'placeholder'=>"University/College Name"])->label(false) ?>
                </div>
                <div class="form-group">
                    <label><b>University/College Website</b></label>
                    <?= $form->field($model, 'org_website')->textInput(['maxlength' => 75,'placeholder'=>'University/College Website'])->label(false) ?>
                </div>
                <div class="form-group">
                    <label><b>Affiliation By</b></label>
                    <?= $form->field($model, 'aff_by')->textInput(['maxlength' => 75,'placeholder'=>'Affiliation By'])->label(false) ?>
                </div>
                <div class="form-group">
                    <label><b>Title of the Conference</b></label>
                    <?= $form->field($model, 'title')->textInput(['maxlength' => 255,'placeholder'=>'Title of the Conference'])->label(false) ?>
                </div>

                <div class="form-group">
                    <label><b>Short Name of conference:</b></label>
                    <?= $form->field($model, 'short_name')->textInput(['maxlength' => 50,'placeholder'=>'Short Name of conference'])->label(false) ?>
                </div>
                <div class="form-group">
                    <label><b>Date of the Conference:</b></label>
                    <?= $form->field($model, 'conf_date')->textInput(['placeholder'=>'Date of the Conference'])->label(false) ?>
                </div>
                <div class="form-group">
                    <label><b>Area of Specializations:</b></label>
                    <?= $form->field($model, 'specialization')->textInput(['maxlength' => 255,'placeholder'=>'Area of Specializations'])->label(false) ?>
                </div>
                <div class="form-group">
                    <label class="control-label" >Conference Brochure</label>
                    <?= $form->field($model, 'brochure')->fileInput()->label(false) ?>
                </div>
                <div class="form-group">
                    <?php Yii::$app->session->set('__captcha/page/captcha',null); ?>
                    <?= $form->field($model, 'verifyCode', ['options' => []])->widget(yii\captcha\Captcha::className(), ['captchaAction' => 'page/captcha']) ?>
                </div>
            </div>
            <div class="col-lg-6">
                <label>&nbsp;</label>
                <div class="form-group">
                    <label><b>Email:</b></label>
                    <?= $form->field($model, 'email')->textInput(['maxlength' => '75','placeholder'=>"Email"])->label(false) ?>
                </div>
                <div class="form-group">
                    <label><b>Contact Number</b></label>
                    <?= $form->field($model, 'phone')->textInput(['maxlength' => 50,'placeholder'=>"Contact Number"])->label(false) ?>
                </div>
                <div class="form-group">
                    <label><b>Name of the Department</b></label>
                    <?= $form->field($model, 'dept_name')->textInput(['maxlength' => 75,'placeholder'=>"Department"])->label(false) ?>
                </div>
                <div class="form-group">
                    <label class="control-label" for="article-a_type_id"><b>National / International Conference</b></label>
                    <?php // $form->field($model, 'conf_type')->dropDownList(ConfPro::getConfTypeArray(), Common::getDropDownOptions($model, 'conf_type',['class'=>"form-control"])) ?>
                    <select id="confpro-conf_type" class="form-control" name="ConfPro[conf_type]">
                        <option value="">Select National / International Conference</option>
                        <option value="1">National</option>
                        <option value="2">International</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Description about conference</label>
                    <?= $form->field($model, 'description')->textarea(['rows' => 6])->label(false) ?>
                </div>
                <div class="form-group">
                    <label><b>Conference Website:</b></label>
                    <?= $form->field($model, 'conf_website')->textInput(['maxlength' => 75,'placeholder' => 'Conference Website'])->label(false) ?>
                </div>
                <div class="form-group">
                    <label><b>Venue:</b></label>
                    <?= $form->field($model, 'venue')->textInput(['placeholder' => 'Venue'])->label(false) ?>
                </div>
                <div class="form-group">
                    <label class="control-label" for="confpro-college_logo">College Logo</label>
                    <?= $form->field($model, 'college_logo')->fileInput()->label(false) ?>
                </div>
                
            </div>
            <div class="form-group col-lg-7">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary pull-left']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <?= $content->content; ?>
    </div>
</div>