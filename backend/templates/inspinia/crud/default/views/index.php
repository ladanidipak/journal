<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
use yii\widgets\Pjax;
use backend\vendors\Common;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */



?>
<?php if(!empty($generator->searchModelClass)): ?>
<?= "    <?php " . ($generator->indexWidgetType === 'grid' ? " " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>

<div class="row <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?= "<?= " ?>Html::encode(Common::getTitle("{$this->context->id}/{$this->context->action->id}")) ?></h5>
                <div class="ibox-tools">
                    <?= "<?php " ?>if(common::checkActionAccess("{$this->context->id}/create")){ 
                                echo Html::a('<i class="fa fa-plus"></i> '.Common::getTitle("{$this->context->id}/create"), ['create'], ['class' => 'btn btn-primary btn-xs']);
                                } ?>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row m-b-sm m-t-sm">
                    
                </div>
                <div class="table-responsive">
                    <?php echo "<?php "?> Pjax::begin(['id'=>'search-grid-pjax']);?>
                    <?php if ($generator->indexWidgetType === 'grid'): ?>
                        <?= "<?= " ?>GridView::widget([
                            'dataProvider' => $dataProvider,
                            'options'=> ['class'=>'project-list'],
                            'tableOptions' => ['class'=>'table table-hover',],
                            'summaryOptions'=> ['class'=>'dataTables_info'],
                            'layout' => "{items}\n{summary}\n<div class=\"pull-right\">{pager}</div>",
                            <?= !empty($generator->searchModelClass) ? "'columns' => [\n" : "'columns' => [\n"; ?>
                                

                    <?php
                    $count = 0;
                    if (($tableSchema = $generator->getTableSchema()) === false) {
                        foreach ($generator->getColumnNames() as $name) {
                            if (++$count < 6) {
                                echo "            '" . $name . "',\n";
                            } else {
                                echo "            // '" . $name . "',\n";
                            }
                        }
                    } else {
                        foreach ($tableSchema->columns as $column) {
                            $format = $generator->generateColumnFormat($column);
                            if (++$count < 6) {
                                echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                            } else {
                                echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                            }
                        }
                    }
                    ?>

                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Action',
                                    'template'=>Common::gridViewButton($this->context->id).' '.Common::gridUpdateButton($this->context->id).' '.Common::gridDeleteButton($this->context->id),
                                ],
                            ],
                        ]); ?>
                    <?php else: ?>
                        <?= "<?= " ?>ListView::widget([
                            'dataProvider' => $dataProvider,
                            'itemOptions' => ['class' => 'item'],
                            'itemView' => function ($model, $key, $index, $widget) {
                                return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
                            },
                        ]) ?>
                    <?php endif; ?>
                    <?php echo "<?php "?>Pjax::end();?>
                </div>
                
            </div>
        </div>
    </div>
</div>
