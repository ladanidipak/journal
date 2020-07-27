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
$form = ActiveForm::begin(['id'=>'upload_copyright_file','options'=>['enctype'=>'multipart/form-data'], 'enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => 'col-sm-12'], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>
    <div class="row">
        <?= $form->field($article, 'copyright_file')->fileInput()->label(false); ?>
    </div>
    <div class="row">
        <div class="hr-line-dashed"></div>
        <div class="form-group col-sm-12">
            <?= Html::submitButton('Upload', ['class' => 'btn btn-primary pull-right' ]) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>