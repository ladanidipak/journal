<?php

use app\models\RoleMaster;
use backend\vendors\Common;
use yii\grid\GridView;
use yii\helpers\Html;

?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?php echo common::getTitle("rolemaster/index"); ?></h5>
                <div class="ibox-tools">                                        
                    <?php echo Html::a('<i class="fa fa-plus"></i> ' . common::getTitle("rolemaster/create"), ['create'], ['class' => 'btn btn-primary btn-xs']) ?>
                </div>
            </div>
            <div class="ibox-content">
                <div class="table-responsive" id="search-grid-pjax">
                    <?php
                    $permissionRights = true;
                    echo
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'options' => ['class' => 'project-list'],
                        'tableOptions' => ['class' => ' table table-stripped toggle-arrow-tiny', 'data-page-size' => '10'],
                        'summaryOptions' => ['class' => 'dataTables_info'],
                        'layout' => "{items}\n{summary}\n<div class=\"pull-right\">{pager}</div>",
                        'columns' => [
                            'role_title',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => Common::gridUpdateButton($this->context->id).'{permissions}',
                                'contentOptions' => ['style' => 'width:7%'],
                                'buttons' => [
                                    'permissions' => function ($url, $model) {
                                        $hide = ($model->id == RoleMaster::SUPER_ADMIN ) ? "hide" : "";
                                        return (common::checkActionAccess("rolemaster/permissions")) ? Html::a(' <span class="glyphicon glyphicon-lock"></span>', $url, ['class' => "$hide"]) : "";
                                    },]
                            ]
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>