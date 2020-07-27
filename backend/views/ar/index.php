<?php

use backend\vendors\Common;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\web\View;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleReviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<?php //echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="row article-review-index">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?= $article->paper_id . " - " . $article->article_title ?></h5>
                <div class="ibox-tools">
                    <?php
                    echo Html::a('<i class="fa fa-send"></i> ' . Common::getTitle("{$this->context->id}/sendcertificate"), ['sendcertificate','id'=>$article->id], ['class' => 'btn btn-danger btn-xs send-certificate', 'data-confirm'=>'Send Certificate? Even if you select all, certificate will be sent to received review only.' ,'data-method'=>'post' ]);
                    ?>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row m-b-sm m-t-sm">

                </div>
                <div class="table-responsive">
                    <?php Pjax::begin(['id' => 'search-grid-pjax']); ?>
                    <?= GridView::widget([
                        'id' => 'ar-grid',
                        'dataProvider' => $dataProvider,
                        'options' => ['class' => 'project-list'],
                        'tableOptions' => ['class' => 'table table-hover',],
                        'summaryOptions' => ['class' => 'dataTables_info'],
                        'layout' => "{items}\n{summary}\n<div class=\"pull-right\">{pager}</div>",
                        'columns' => [

                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'checkboxOptions' => function ($model, $key, $index, $column) {
                                    return ['class'=>'multi-check-action'];
                                },
//                                'visible' => IS_GRD_ADMIN && !$isConf
                            ],
                            'id',
                            'reviewer.full_name:text:Reviewer',
                            'reviewed_date',
                            'created_dt',
                            [
                                'attribute' => 'certi_status',
                                'format' => 'html',
                                'value' => function ($model, $key, $index, $column) use ($article) {

                                    if ($model->certi_status) {
                                        $color = "label-primary";
                                        $statusText = "Sent";
                                    }else{
                                        $color = "label-default";
                                        $statusText = "Pending";
                                    }
                                    return '<span class="label ' . $color . '">' . $statusText . '</span>';

                                }
                            ],
                            [
                                'attribute' => 'status',
                                'format' => 'html',
                                'value' => function ($model, $key, $index, $column) use ($article) {

                                    if (empty($model->article_review)) {
                                        $color = "label-default";
                                        $statusText = "Pending";
                                    }else{
                                        if($article->ar_id == $model->id){
                                            $color = "label-primary";
                                            $statusText = "Accepted";
                                        } else {
                                            $color = "label-warning";
                                            $statusText = "Received";
                                        }

                                    }
                                    return '<span class="label ' . $color . '">' . $statusText . '</span>';

                                }
                            ],
                            [
                                'format' => 'raw',
                                'header' => 'Action',
                                'value' => function($model, $key, $index, $column) use ($article){
                                    if($article->ar_id == $model->id){
                                        $acceptReview = "";
                                        $deleteReview = "";
                                    }else{
                                        $acceptReview = (($model->article_review) ? ('<a class="btn btn-primary btn-sm" data-pjax="0" data-method="post" data-confirm="Are you sure you want to accept this review?" aria-label="Accept" title="Accept" href="' . Url::to(['accept', 'id' => $model->id]) . '" ><i class="fa fa-thumbs-up"> Accept</i></a>'):"");
                                        $deleteReview = '<a class="btn btn-success btn-sm" data-pjax="0" data-method="post" data-confirm="Are you sure you want to delete this item?" aria-label="Delete" title="Delete" href="' . Url::to(['delete', 'id' => $model->id]) . '" ><i class="fa fa-trash"></i></a>';
                                    }

                                    $html = (($model->article_review) ? ('<a class="btn btn-danger btn-sm showreview" href="' . Url::to(['showreview', 'id' => $model->id]) . '" data-id="' . $model->id . '" data-pjax="0" ><i class="fa fa-ticket"></i> Show Review </a>') : ("")).
                                        $acceptReview.
                                        $deleteReview.
                                        ""
                                        ;
                                    return $html;
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
<div class="modal inmodal" id="showreview" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>
</div>
<?php
$this->registerJs(
    "$('#search-grid-pjax').on('click', '.showreview',function (e) {
            e.preventDefault();
            obj = $(this);
            $.get(obj.attr('href'), {}, function (data) {
                $('#showreview .modal-content').html(data);
                $('#showreview').modal('show');
            });
    });", View::POS_READY
);
$this->registerJs(
    "$('#search-grid-pjax').on('change', '.multi-check-action, .select-on-check-all',function (e) {
           var a_keys = $('#ar-grid').yiiGridView('getSelectedRows');
           a_keys = a_keys.join();
           $('.send-certificate').data('params',{rid:a_keys});
    });", View::POS_READY
);
?>
