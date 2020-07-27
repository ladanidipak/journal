<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleFormatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>

<div class="row article-format-index">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?= $article->paper_id . " - " . $article->article_title ?></h5>

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
                            'formatter.name:text:Reviewer',
                            'formatted_file:ntext',
                            [
                                'attribute'=>'formatted_file',
                                'format'=>'html',
                                'content'=>function($model){
                                    if($model->formatted_file){
                                        return Html::a($model->formatted_file,DOCURL."uploads/format_request/".$model->formatted_file,['data-pjax'=>0]);
                                    }
                                    return "";
                                }
                            ],
                            'formatted_date',

                            [
                                'format' => 'raw',
                                'header' => 'Action',
                                'value' => function($model, $key, $index, $column) use ($article){
                                    if($article->af_id == $model->id){
                                        $acceptReview = "";
                                        $deleteReview = "";
                                    }else{
                                        $acceptReview = (($model->formatted_file) ? ('<a class="btn btn-primary btn-sm" data-pjax="0" data-method="post" data-confirm="Are you sure you want to accept this formatted file?" aria-label="Accept" title="Accept" href="' . Url::to(['accept', 'id' => $model->id]) . '" ><i class="fa fa-thumbs-up"> Accept</i></a>'):"");
                                        $deleteReview = '<a class="btn btn-success btn-sm" data-pjax="0" data-method="post" data-confirm="Are you sure you want to delete this formatted file?" aria-label="Delete" title="Delete" href="' . Url::to(['delete', 'id' => $model->id]) . '" ><i class="fa fa-trash"></i></a>';
                                    }

                                    $html = $acceptReview.
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
