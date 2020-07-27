<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use backend\vendors\Common;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
$this->title = 'Review Request - Accept Request';
?>

<div class="open-box" style="text-align: left">
    <?php echo $this->render("@backend/views/layouts/_message"); ?>
    <?php if($hide == false){?>
        <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => 'col-sm-4'], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>
        <div class="row">

                    <span class="help-block m-b-none"><i class="fa fa-exclamation-triangle"></i>
                        Please Enter your email address and hit enter to unsubscribe from our mailing list. Contact us on info@grdjournals.com in case of any issue.
                    </span>
            <?= $form->field($model, 'email_id')->textInput(['maxlength'=>255])->label('Email Address');?>

        </div>
        <div class="row">
            <div class="hr-line-dashed"></div>
            <div class="form-group col-sm-12">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary pull-left']) ?>
                <a class="btn btn-white pull-left" href="<?php echo Yii::$app->request->baseUrl; ?>/"><?= common::translateText("CANCEL_BTN_TEXT") ?></a>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    <?php }?>

    <p class="m-t"> <small><?= Yii::$app->name . " &copy;" . date('Y') ?> </small> </p>
</div>
