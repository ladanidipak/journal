<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \backend\models\VolIss;
use backend\models\Conference;

/* @var $this yii\web\View */
/* @var $model backend\models\search\ArticleSearch */
/* @var $form yii\widgets\ActiveForm */
$isConf = $this->context->action->id == 'conference';
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
<div class="ibox float-e-margins border-bottom">
    <div class="ibox-title">
        <h5>Search</h5>

        <div class="ibox-tools">
            <label>Pagination : </label>
            <?= Html::dropDownList('pagesize', $_SESSION['pagesize'][Yii::$app->controller->id], Yii::$app->params['pagesizeArray'], ['onchange' => '$.get("?exit=1&pagesize="+this.value,{},function(data){location.reload();});', 'id' => 'grid-page-size']) ?>
        </div>
    </div>
    <div class="ibox-content m-b-sm border-bottom article-search">
        <?php yii\widgets\Pjax::begin(['id' => 'search-form-pjax']) ?>
        <?php $form = ActiveForm::begin([
            'action' => !$isConf?['index']:['conference'],
            'method' => 'get',
            'options' => ['data-pjax' => false ],
        ]); ?>

        <div class="row">
            <?php
            if(defined('ACTIVE_CONF')){
                /*$confArray = Conference::getList();
                echo $confArray[ACTIVE_CONF];*/
            }else{
                echo '<div class="col-sm-4">';
                if(!$isConf){
                    echo $form->field($model, 'voliss_id')->dropDownList(VolIss::getList(),['prompt'=>'All Issues'])->label(false);
                }else{
                    echo $form->field($model, 'conf_id')->dropDownList(Conference::getList(),['prompt'=>'All Issues'])->label(false);
                }
                echo '</div>';
            }
            ?>

            <div class="col-sm-2">
                <?= $form->field($model, 'status')->dropDownList((!$isConf?$model->getStatusArray():$model->getConfStatusArray()),['prompt'=>'All'])->label(false); ?>
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
</div>

