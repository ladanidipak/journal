<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PublishedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<?php echo $this->render('_search', ['model' => $searchModel, 'type' => $type]); ?>

<div class="row published-index">
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
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'options' => ['class' => 'project-list'],
                        'tableOptions' => ['class' => 'table table-hover',],
                        'summaryOptions' => ['class' => 'dataTables_info'],
                        'layout' => "{items}\n{summary}\n<div class=\"pull-right\">{pager}</div>",
                        'columns' => [


                            'article.paper_id',
                            'title',
                            'authors',
                            'country',
                            [
                                'attribute'=>'pdf',
                                'content'=>function($data){
									if($data->article->conf_id == 0){
										$fileDir = "article";
									}else{
										$fileDir = "conference";
									}
                                    return Html::a("<span class='label label-success'>PDF</span>",DOCURL."uploads/$fileDir/".$data->pdf,['data-pjax'=>0,'target'=>'_blank']);
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
