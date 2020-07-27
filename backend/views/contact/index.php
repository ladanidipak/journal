<?php

use backend\vendors\Common;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ContactUsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<?php echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="row contact-us-index">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?= Html::encode(Common::getTitle("{$this->context->id}/{$this->context->action->id}")) ?></h5>
            </div>
            <div class="ibox-content">
                <div class="row m-b-sm m-t-sm">

                </div>
                <div class="table-responsive">
                    <?php Pjax::begin(['id' => 'search-grid-pjax']); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'options' => ['class' => 'project-list'],
                        'tableOptions' => ['class' => 'table table-hover',],
                        'summaryOptions' => ['class' => 'dataTables_info'],
                        'layout' => "{items}\n{summary}\n<div class=\"pull-right\">{pager}</div>",
                        'columns' => [


                            'id',
                            'name',
                            'email:email',
                            'phone',
                            'subject',
                            // 'message:ntext',
                            // 'created_dt',
                            // 'updated_dt',
                            // 'updated_by',

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'template' => Common::gridViewButton($this->context->id) . ' ' . Common::gridUpdateButton($this->context->id) . ' ' . Common::gridDeleteButton($this->context->id),
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>

            </div>
        </div>
    </div>
</div>
