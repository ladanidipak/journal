<?php

use backend\vendors\Common;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use backend\models\EmailRequest;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\EmailMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<?php echo $this->render('_search_log', ['model' => $searchModel]); ?>

<div class="row email-master-index">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?= Html::encode(Common::getTitle("{$this->context->id}/{$this->context->action->id}")) ?></h5>

                <div class="ibox-tools">

                </div>
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
                            'message.subject',
                            'send_to_ids',
                            'id_from',
                            'id_to',
                            'id_ended',
                            'list_id',
                            [
                                'header'=>'Sending Status',
                                'value'=>function($model){
                                    return EmailRequest::$statusArray[$model->send_status];
                                }
                            ]
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>

            </div>
        </div>
    </div>
</div>
