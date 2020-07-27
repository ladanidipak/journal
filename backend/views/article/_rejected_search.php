<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \backend\models\VolIss;

/* @var $this yii\web\View */
/* @var $model backend\models\search\ArticleSearch */
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
<div class="ibox-content m-b-sm border-bottom article-search">
    <?php yii\widgets\Pjax::begin(['id' => 'search-form-pjax']) ?>
    <?php $form = ActiveForm::begin([
        'action' => ['rejected'],
        'method' => 'get',
        'options' => ['data-pjax' => true ],
    ]); ?>
    
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'voliss_id')->dropDownList(VolIss::getList(),['prompt'=>'All Issues'])->label(false); ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'status')->dropDownList($model->getStatusArray(),['prompt'=>'All'])->label(false); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'search',['inputOptions' => ['placeholder'=>backend\vendors\Common::translateText("SEARCH_BTN_TEXT"),'class'=>'form-control'],])->label(false); ?>
        </div>
        <div class="col-sm-2">
            <?= Html::submitButton(backend\vendors\Common::translateText("SEARCH_BTN_TEXT"), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <?php  yii\widgets\Pjax::end() ?>
</div>
