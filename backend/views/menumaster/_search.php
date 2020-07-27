<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CurrencyMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$this->registerJs(
   '$("document").ready(function(){ 
        $("#search-form-pjax").on("pjax:end", function() {
            $.pjax.reload({container:"#search-grid-pjax"});$("select.form-control:visible").chosen(config[".chosen-select-p"]);  //Reload GridView
        });
    });'
);
?>
<div class="ibox-content m-b-sm border-bottom currency-master-search">
    <?php yii\widgets\Pjax::begin(['id' => 'search-form-pjax']) ?>
    <?php    
    $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['data-pjax' => true],
    ]);
    ?>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($searchModel,'search', ['inputOptions' => ['placeholder' => common::translateText("SEARCH_BTN_TEXT"), 'class' => 'form-control'],])->label(false); ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($searchModel, 'show_in_menu')->dropDownList(['1' => common::translateText("YES_LABEL"), '0' => common::translateText("NO_LABEL")], ["prompt" => $searchModel->getAttributeLabel("show_in_menu")])->label(false); ?>
        </div>
        <div class="col-sm-2">
            <?= Html::submitButton(common::translateText("SEARCH_BTN_TEXT"), ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="col-sm-4">&nbsp;</div>
    </div>
    <?php ActiveForm::end(); ?>
    <?php yii\widgets\Pjax::end(); ?>
</div>
