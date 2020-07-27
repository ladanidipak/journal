<?php

use moonland\tinymce\TinyMCE;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Article */
/* @var $form yii\widgets\ActiveForm */

if($this instanceof backend\components\View){
    $this->enableMinify = false;
}

$pageTitle = "Author Name : {$article->author_name} &nbsp; / &nbsp; Email : {$article->a_email}";
$content = $this->render('_authormail_content');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>
                    <?= $pageTitle ?>
                </h5>
            </div>
            <div class="ibox-content article-form" style="display: block;">
                <?php echo $this->render("@app/views/layouts/_message"); ?>
                <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => 'col-sm-8'], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>

                <div class="row">
                    <?= $form->field($mail, 'temp_subject')->textInput(['maxlength' => 255]) ?>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <label for="emailmaster-temp_subject" class="control-label">Email Body</label>
                        <?= TinyMCE::widget(['name' => 'author-mail-html', 'id' => 'author-mail-html','value'=>$content,'height'=>500]); ?>
                    </div>

                </div>

                <div class="row">
                    <div class="hr-line-dashed"></div>
                    <div class="form-group col-sm-12">
                        <?= Html::submitButton('Send Mail', ['class' => 'btn btn-primary', 'name' => 'submit-button']); ?>
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>