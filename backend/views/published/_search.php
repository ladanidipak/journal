<?php

use backend\models\Branch;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\VolIss;
use backend\models\Conference;

/* @var $this yii\web\View */
/* @var $model backend\models\search\PublishedSearch */
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
$this->registerJs(
    "$('.wrapper-content').on('change','#publishedsearch-v_voliss_id',function(){
        if($(this).val() != ''){
            $('#publishedsearch-v_conf_id').val('').trigger(\"chosen:updated\");
        }
    });
    $('.wrapper-content').on('change','#publishedsearch-v_conf_id',function(){
        if($(this).val() != ''){
            $('#publishedsearch-v_voliss_id').val('').trigger(\"chosen:updated\");
        }
    })
    "
);
?>
<div class="ibox-content m-b-sm border-bottom published-search">
    <?php yii\widgets\Pjax::begin(['id' => 'search-form-pjax']) ?>
    <?php $form = ActiveForm::begin([
        'action' => $type == 'article' ? ['index'] : ['conference'],
        'method' => 'get',
        'options' => ['data-pjax' => true],
    ]); ?>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'search', ['inputOptions' => ['placeholder' => backend\vendors\Common::translateText("SEARCH_BTN_TEXT"), 'class' => 'form-control'],])->label(false); ?>
        </div>
        <div class="col-sm-3">
            <?php
            if ($type == 'article') {
                echo $form->field($model, 'v_voliss_id')->dropDownList(VolIss::getList(), ['prompt' => 'All Issues'])->label(false);
            } else {
                echo $form->field($model, 'v_conf_id')->dropDownList(Conference::getList(), ['prompt' => 'All Conference'])->label(false);
            }

            ?>
        </div>

        <div class="col-sm-2">
            <?= $form->field($model, 'status')->dropDownList(backend\vendors\Common::getStatusArray(), ['prompt' => 'Select ' . $model->getAttributeLabel('status')])->label(false); ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'branch_id')->dropDownList(Branch::getBranches(), ['prompt' => 'Select branch'])->label(false); ?>
        </div>
        <div class="col-sm-1">
            <?= Html::submitButton(backend\vendors\Common::translateText("SEARCH_BTN_TEXT"), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <?php yii\widgets\Pjax::end() ?>
</div>