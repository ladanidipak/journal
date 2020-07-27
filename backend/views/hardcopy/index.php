<?php

use backend\vendors\Common;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\HardcopySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<?php echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="row hardcopy-index">
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
                            'paper_id',
                            'author_name',
                            'article_title',
                            [
                                'header' => 'Address',
                                'content'=>function($data){
                                    return $data->addr_1 . ", " . $data->addr_2 . ", " . $data->city . " - " . $data->zip . ", " . $data->state . ", " . $data->country;
                                }
                            ],
                            [
                                'header'=>'Author Email',
                                'content' => function($data){
                                    if($data->hardcopyRel && $data->hardcopyRel->detail_sent == 1){
                                        $sent = "<i class='fa fa-check'></i>";
                                    }else{
                                        $sent = "";
                                    }
                                    return $data->a_email."$sent";
                                }
                            ],
                            [
                                'header' => 'Dispatch Detail',
                                'content' => function($data){
                                    if($data->hardcopyRel){
                                        $date = date('d/m/Y',strtotime($data->hardcopyRel->dispatched_date));
                                        $detail = "<span class='span-inline-block'>{$date}</span><span class='span-inline-block'>{$data->hardcopyRel->dispatched_by}</span><span class='span-inline-block'>{$data->hardcopyRel->courier_name}</span><span class='span-inline-block'>{$data->hardcopyRel->tracking_no}</span>".
                                            "<span class='span-inline-block'><a data-pjax='0' target='_blank' href='{$data->hardcopyRel->tracking_url}'>Track Url</a></span>";
                                    } else {
                                        $detail = "N/A";
                                    }
                                    $dispatch = $detail;
                                    return $dispatch;
                                },
                            ],

                            [
                                'header' => 'Action',
                                'content' => function($model){
                                    $certi = '<a class="btn btn-success btn-sm checkcertificate" href="' . Url::to(['article/checkcertificate', 'id' => $model->id]) . '" data-id="' . $model->id . '" data-pjax="0" ><i class="fa fa-download"></i></a>';
                                    $dispatch = '<a class="btn btn-danger btn-sm dispatch" href="' . Url::to(['dispatch', 'id' => $model->id]) . '" data-id="' . $model->id . '" data-pjax="0" ><i class="fa fa-edit"></i> Dispatch Detail </a>';
                                    $send = ($model->hardcopyRel)?('<a class="btn btn-primary btn-sm send-detail" href="' . Url::to(['sendemail', 'id' => $model->hardcopyRel->id]) . '" data-id="' . $model->id . '" data-pjax="0" data-method="post" data-confirm="Are you sure want to send dispatch mail?" ><i class="fa fa-mail"></i> Send Mail </a>'):"";
                                    return $certi . $send . $dispatch;
                                }
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>

            </div>
        </div>
    </div>
</div>
