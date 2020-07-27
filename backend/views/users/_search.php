<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsersSearch */
/* @var $form yii\widgets\ActiveForm */


$this->registerJs(
   '$("document").ready(function(){ 
        $("#search-form-pjax").on("pjax:end", function() {
            $.pjax.reload({container:"#search-grid-pjax"});$("select.form-control:visible").chosen(config[".chosen-select-p"]);  //Reload GridView
        });
    });'
);
?>

<div class="ibox-content m-b-sm border-bottom users-search">
    <?php yii\widgets\Pjax::begin(['id' => 'search-form-pjax']) ?>
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['data-pjax' => true ]
    ]); ?>
    
    
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'search',['inputOptions' => ['placeholder'=>$model->getAttributeLabel('search'),'class'=>'form-control'],])->label(false); ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'status')->dropDownList(backend\vendors\Common::getStatusArray(),['prompt'=>'Select '.$model->getAttributeLabel('status')])->label(false); ?>
        </div>
        <div class="col-sm-2">
            <?= Html::submitButton(backend\vendors\Common::translateText("SEARCH_BTN_TEXT"), ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="col-sm-4">&nbsp;</div>
    </div>
    <?php ActiveForm::end(); ?>
    <?php yii\widgets\Pjax::end() ?>
</div>
