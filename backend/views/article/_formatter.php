<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use backend\vendors\Common;
/* @var $this yii\web\View */
/* @var $model backend\models\search\EditorialBoardSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$article->scenario = 'fupload';
$form = ActiveForm::begin(['id'=>'upload_f_file','options'=>['enctype'=>'multipart/form-data'], 'enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => 'col-sm-12'], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>
    <div class="row">
        <?= $form->field($article, 'formatted_file')->fileInput()->label(false); ?>
    </div>
    <div class="row">
        <div class="form-group col-sm-12">
            <?= Html::submitButton('Upload Formatted File', ['class' => 'btn btn-primary pull-right' ]) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
    <div class="row text-centered">
        <div class="hr-line-dashed"></div>
        <span>-- OR --</span>
        <div class="hr-line-dashed"></div>
    </div>

<?php
$article->scenario = 'format_email';
$form = ActiveForm::begin(['id'=>'select_formatter', 'enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => 'col-sm-12'], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>
<div class="row">
    <?= $form->field($article, 'formatter_sent_ids')->inline()->checkboxList($formatters,['separator'=>'<br><hr>','encode'=>false]) ?>
</div>
<div class="row">
    <div class="form-group col-sm-12">
        <?= Html::submitButton('SEND', ['class' => 'btn btn-primary pull-right' ]) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>