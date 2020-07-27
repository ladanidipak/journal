<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $model backend\models\Published */
/* @var $form yii\widgets\ActiveForm */

$pageTitle = Common::getTitle("{$this->context->id}/{$this->context->action->id}");
if($model->article->conf_id == 0){
                        $fileDir = "article";
                    }else{
                        $fileDir = "conference";
                    }
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>
                    <?= $pageTitle ?>
                </h5>
            </div>
            <div class="ibox-content published-form" style="display: block;">

                <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data'],'enableAjaxValidation' => false, 'layout' => 'horizontal', 'enableClientValidation' => true]); ?>

                <div class="row">

                    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

                    <?= $form->field($model, 'authors')->textarea(['rows' => 3]) ?>

                </div>

                <div class="row">

                    <?= $form->field($model, 'country')->textInput(['maxlength' => 75]) ?>

                    <?= $form->field($model, 'abstract')->textarea(['rows' => 6]) ?>
                    <?= $form->field($model, 'reference')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'keywords')->textInput(['maxlength' => 255]) ?>

                </div>

                <div class="row">

                    <?= $form->field($model, 'start_page')->textInput() ?>

                    <?= $form->field($model, 'end_page')->textInput() ?>

                    <?= $form->field($model, 'pub_date')->textInput(['readonly'=>'readonly']) ?>

                </div>

                <div class="row">

                    <?= $form->field($model, 'pdf')->fileInput(['maxlength' => 255]) ?>
                    <div class="form-group">
                        <label class="control-label col-sm-3">&nbsp;</label>
                        <div class="col-sm-6">
                            <?= Html::a($model->pdf,DOCURL."uploads/$fileDir/".$model->pdf,['target'=>'_blank'])?>
                            <div class="help-block help-block-error "></div>
                        </div>
                    </div>

                    <?= $form->field($model, 'google_scholar')->textInput() ?>
                    <?= $form->field($model, 'status')->dropDownList(Common::getStatusArray()) ?>

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
<script>
    $(document).ready(function(){
        $('#published-pub_date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            format: "dd/mm/yyyy"
        });
    });
</script>
