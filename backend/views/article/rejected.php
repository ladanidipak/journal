<?php

use backend\vendors\Common;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<?php echo $this->render('_rejected_search', ['model' => $searchModel]); ?>

    <div class="row article-index">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?= Html::encode(Common::getTitle("{$this->context->id}/{$this->context->action->id}")) ?></h5>
                </div>
                <div class="ibox-content">
                    <div class="row m-b-sm m-t-sm">

                    </div>
                    <div class="table-responsive labelspace">
                        <?php Pjax::begin(['id' => 'search-grid-pjax']); ?>
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'options' => ['class' => 'project-list'],
                            'tableOptions' => ['class' => 'table table-hover',],
                            'summaryOptions' => ['class' => 'dataTables_info'],
                            'layout' => "{items}\n{summary}\n<div class=\"pull-right\">{pager}</div>",
                            'columns' => [
                                [
                                    'header' => 'Detail',
                                    'format' => 'html',
                                    'value' => function ($model, $key, $index, $column) {
                                        return "<span class='label label-primary'>{$model->paper_id}</span>"
                                        . "<span class='label label-danger'>(N) {$model->author_name}</span>"
                                        . "<span class='label label-info'>(M) {$model->a_phone}</span>"
                                        . "<span class='label label-warning'>(D) {$model->created_dt}</span>"
                                        . "";
                                    }
                                ],
                                [
                                    'attribute' => 'article_title',
                                    'content' => function ($data) {
                                        return $data->article_title . (($data->status < 7) ? "" : (
                                            "<br>" . "<div class='col-md-6'>" . Html::a("<span class='label label-warning'>Copyright</span>", DOCURL . "uploads/article/" . $data->copyright_file, ['data-pjax' => 0, 'target' => '_blank']) . "</div>" .
                                            "<div class='col-md-6'>" . Html::a("<span class='label label-success'>Payment</span>", DOCURL . "uploads/article/" . $data->payment_file, ['data-pjax' => 0, 'target' => '_blank']) . "</div>"
                                        )) . (($data->status == 15) ? ("<div class='col-md-6'>" . Html::a("<span class='label label-danger'>Formatted Article</span>", DOCURL . "uploads/article/" . $data->formatted_file, ['data-pjax' => 0, 'target' => '_blank']) . "</div>") : "");


                                    }
                                ],
                                [
                                    'header' => 'Branch',
                                    'format' => 'html',
                                    'value' => function ($model, $key, $index, $column) {
                                        return "{$model->branch->name}";
                                    }
                                ],
                                [
                                    'attribute' => 'status',
                                    'format' => 'html',
                                    'value' => function ($model, $key, $index, $column) {
                                        $color = "label-primary";
                                        if ($model->status == 6) $color = "label-warning";
                                        if ($model->status == 15 && $model->published) $model->status = 20;
                                        return '<span class="label ' . $color . '">' . $model->getStatusArray()[$model->status] . '</span>';
                                    }
                                ],
                                [
                                    'header' => 'Action',
                                    'format' => 'raw',
                                    'value' => function ($model, $key, $index, $column) {
                                        return '<a class="btn btn-success btn-sm" href="' . Url::to(['view', 'id' => $model->id]) . '" title="View"><i class="fa fa-search"></i> View </a>'
                                            . '<a class="btn btn-danger btn-sm" href="' . Url::to(['rollbackreject', 'id' => $model->id]) . '" data-id="' . $model->id . '" data-pjax="0" data-method="post" data-confirm="Rollback This Article?" ><i class="fa fa-thumbs-o-up"></i> Rollback </a>'
                                            . '<a class="btn btn-danger btn-sm showreview" href="' . Url::to(['showreview', 'id' => $model->id]) . '" data-id="' . $model->id . '" data-pjax="0" ><i class="fa fa-ticket"></i> Show Review </a>'
                                            .'<a class="btn btn-success btn-sm plagiarism" href="' . Url::to(['plagiarism', 'id' => $model->id]) . '" data-id="' . $model->id . '" data-pjax="0" ><i class="fa fa-note"></i> Plagiarism Note </a>'
                                            ;
                                    },
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
    <div class="modal inmodal" id="sendtoreviewer" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only"><?= backend\vendors\Common::translateText('CLOSE_BTN_TEXT') ?></span>
                    </button>
                    <h4 class="modal-title">Send To Reviewer</h4>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
    <div class="modal inmodal" id="sendtoformatter" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only"><?= backend\vendors\Common::translateText('CLOSE_BTN_TEXT') ?></span>
                    </button>
                    <h4 class="modal-title">Send To Formatter</h4>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
    <div class="modal inmodal" id="acceptpay" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only"><?= backend\vendors\Common::translateText('CLOSE_BTN_TEXT') ?></span>
                    </button>
                    <h4 class="modal-title">Accept Payment</h4>
                </div>
                <div class="modal-body">
                    <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => 'col-sm-4'], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>
                    <div class="row">
                        <div class="col-md-8">
                            <?= Html::label((new \backend\models\Article())->getAttributeLabel('hardcopy'), 'hardcopy') ?>
                            <?= Html::radioList('hardcopy', '0', ['1' => 'Yes', '0' => 'No'], ['separator' => '<br>']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="hr-line-dashed"></div>
                        <div class="form-group col-sm-12">
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary pull-right']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
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
    <div class="modal inmodal" id="plagiarism" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <div class="modal inmodal" id="edit-review" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

            </div>
        </div>
    </div>
<?php
$this->registerJs(
    "$('#search-grid-pjax').on('click', '.sendtoreviewer',function (e) {
            e.preventDefault();
            obj = $(this);
            $.get(obj.attr('href'), {}, function (data) {
                $('#sendtoreviewer .modal-body').html(data);
                $('#sendtoreviewer').modal('show');
            });
    });", \yii\web\View::POS_READY
);
$this->registerJs(
    "$('#search-grid-pjax').on('click', '.sendtoformatter',function (e) {
            e.preventDefault();
            obj = $(this);
            $.get(obj.attr('href'), {}, function (data) {
                $('#sendtoformatter .modal-body').html(data);
                $('#sendtoformatter').modal('show');
            });
    });", \yii\web\View::POS_READY
);
$this->registerJs(
    "$('#search-grid-pjax').on('click', '.showreview',function (e) {
            e.preventDefault();
            obj = $(this);
            $.get(obj.attr('href'), {}, function (data) {
                $('#showreview .modal-content').html(data);
                $('#showreview').modal('show');
            });
    });", \yii\web\View::POS_READY
);
$this->registerJs(
    "$('#search-grid-pjax').on('click', '.plagiarism',function (e) {
            e.preventDefault();
            obj = $(this);
            $.get(obj.attr('href'), {}, function (data) {
                $('#plagiarism .modal-content').html(data);
                $('#plagiarism').modal('show');
            });
    });", $this::POS_READY
);
$this->registerJs(
    "$('#search-grid-pjax').on('click', '.acceptpay',function (e) {
            e.preventDefault();
            obj = $(this);
            $('#acceptpay form').attr('action',obj.attr('href'));
            $('#acceptpay').modal('show');
    });", \yii\web\View::POS_READY
);
$this->registerJs(
    "function checkRequired(data){
        var ret = true;
        $.each(data,function(e,v){
            if(e == 'radiolist'){
                if($('input[name=\"'+v+'\"]:radio:checked').val() == undefined){
                    ret = false;
                }
            }
        });
        return ret;
    }", \yii\web\View::POS_HEAD
);
$this->registerJs(
    "$(document).on('click', '.edit-review',function (e) {
            e.preventDefault();
            $('#showreview').modal('hide');
            obj = $(this);
            $.get(obj.attr('href'), {}, function (data) {
                $('#edit-review .modal-content').html(data);
                $('#edit-review').modal('show');
            });
    });", \yii\web\View::POS_READY
);
?>