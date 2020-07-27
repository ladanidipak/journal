<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\vendors\Common;

echo $this->render('_search', ['searchModel' => $searchModel]);
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?php echo common::getTitle("menumaster/index"); ?></h5>
                <div class="ibox-tools">                                        
                <?php echo Html::a('<i class="fa fa-plus"></i> ' . common::getTitle("menumaster/create"), ['create'], ['class' => 'btn btn-primary btn-xs']) ?>
                </div>
            </div>
            <div class="ibox-content">   
                <?php yii\widgets\Pjax::begin(['id' => 'search-grid-pjax']); ?>
                <?php
                echo
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'options' => ['class' => 'project-list'],
                    'tableOptions' => ['class' => ' table table-stripped toggle-arrow-tiny', 'data-page-size' => '10'],
                    'summaryOptions' => ['class' => 'dataTables_info'],
                    'layout' => "{items}\n{summary}\n<div class=\"pull-right\">{pager}</div>",
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'menu_title',
                        [
                            'header' => 'Parent Menu',
                            'attribute' => 'parent.menu_title',
                        ],
                        'page_url',
                        [
                            'attribute' => 'show_in_menu',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return !empty($model->show_in_menu) ? Common::translateText("YES_LABEL") : Common::translateText("NO_LABEL");
                            },
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => Common::gridUpdateButton($this->context->id),
                            
                                ]
                            ]
                        ]);
                        ?> 
        <?php yii\widgets\Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>