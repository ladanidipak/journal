<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\DesignationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<?php echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="row designation-index">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?= Html::encode(Common::getTitle("{$this->context->id}/{$this->context->action->id}")) ?></h5>
                <div class="ibox-tools">
<?php
if (common::checkActionAccess("{$this->context->id}/create")) {
    echo Html::a('<i class="fa fa-plus"></i> ' . Common::getTitle("{$this->context->id}/create"), ['create'], ['class' => 'btn btn-primary btn-xs']);
}
?>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row m-b-sm m-t-sm">

                </div>
                <div class="table-responsive">
                    <?php Pjax::begin(['id' => 'search-grid-pjax']); ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'options' => ['class' => 'project-list'],
                        'tableOptions' => ['class' => 'table table-hover',],
                        'summaryOptions' => ['class' => 'dataTables_info'],
                        'layout' => "{items}\n{summary}\n<div class=\"pull-right\">{pager}</div>",
                        'columns' => [


                            'id',
                            'name',
                            [
                                'attribute' => 'status',
                                'format' => 'html',
                                'value' => function ($model, $key, $index, $column) {
                                    return ($model->status) ? '<span class="label label-primary">' . Common::translateText('ENABLE_BTN_TEXT') . '</span>' : '<span class="label label-danger">' . Common::translateText('DISABLE_BTN_TEXT') . '</span>';
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'template' => Common::gridViewButton($this->context->id) . ' ' . Common::gridUpdateButton($this->context->id) . ' ' . Common::gridDeleteButton($this->context->id),
                            ],
                        ],
                    ]);
                    ?>
                    <?php Pjax::end(); ?>
                </div>

            </div>
        </div>
    </div>
</div>
