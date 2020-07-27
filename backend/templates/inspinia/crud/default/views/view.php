<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$pageTitle = Common::getTitle("{$this->context->id}/{$this->context->action->id}");
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">

    <h1><?= "<?= " ?>Html::encode($pageTitle) ?></h1>


    <?= "<?= " ?>DetailView::widget([
        'model' => $model,
        'attributes' => [
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if(in_array($name, array('is_deleted','created_date','created_dt','updated_date','updated_dt'))){
            continue;
        }
        if($name == 'status'){
            echo "            ['attribute'=>'status','value'=>(\$model->status)?(\backend\vendors\Common::translateText('ENABLE_BTN_TEXT')) : (\backend\vendors\Common::translateText('DISABLE_BTN_TEXT')) ],\n";
        }else{
            echo "            '" . $name . "',\n";
        }
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        if(in_array($column->name, array('is_deleted','created_date','created_dt','updated_date','updated_dt','created_by', 'updated_by'))){
            continue;
        }
        $format = $generator->generateColumnFormat($column);
        if($column->name == 'status'){
            echo "            ['attribute'=>'status','value'=>(\$model->status)?(Common::translateText('ENABLE_BTN_TEXT')) : (Common::translateText('DISABLE_BTN_TEXT')) ],\n";
        }else{
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>
        ],
    ]) ?>

</div>
