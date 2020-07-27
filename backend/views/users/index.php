<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use backend\vendors\Common;

echo $this->render('_search', ['model' => $searchModel]);
if($this->context->id == 'confusers'){
    $urlArray = ['create','id'=>$id];
} else {
    $urlArray = ['create'];
}

?>
<div class="row users-index">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?= Common::getTitle('users/index') ?></h5>
                <div class="ibox-tools">
                    <?php
                    if (common::checkActionAccess('users/create')) :
                        echo Html::a('<i class="fa fa-plus"></i> ' . common::getTitle("users/create"), $urlArray, ['class' => 'btn btn-primary btn-xs']);
                    endif;
                    ?>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row m-b-sm m-t-sm">

                </div>
                <div class="table-responsive"> 
                    <?php
                    Pjax::begin(['id' => 'search-grid-pjax']);
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'options' => ['class' => 'project-list'],
                        'tableOptions' => ['class' => 'table table-hover',],
                        'summaryOptions' => ['class' => 'dataTables_info'],
                        'layout' => "{items}\n{summary}\n<div class=\"pull-right\">{pager}</div>",
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'profile_pic',
                                'format' => 'html',
                                'filter' => false,
                                'content' => function($data) {
                                    return Html::img(Yii::$app->user->getProfilePicture($data->profile_pic, $data->id), ["class" => "img-circle"]);
                                },
                                    ],
                                    'first_name',
                                    [
                                        'attribute' => 'user_group',
                                        'format' => 'text',
                                        'content' => function($data) {
                                            return $data->roles->role_title;
                                        },
                                    ],
                                    'email',
                                    [
                                        'attribute' => 'status',
                                        'format' => 'html',
                                        'value' => function ($model, $key, $index, $column) {
                                            return Common::statusLables($model);
                                            // return Common::statusLables($model);
                                        }
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'template' => '{view}{update}'.Common::gridDeleteButton($this->context->id),
                                        'buttons' => [
                                          
                                                ],
                                            ],
                                        ],
                                    ]);
                                    Pjax::end();
                                    ?>
                </div>

            </div>
        </div>
    </div>
</div>
