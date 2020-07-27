<?php

/**
 * This file is copied in rejected and archived section also change there.
 */


use backend\vendors\Common;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$isConf = $this->context->action->id == 'conference';
$arDir = $isConf ? 'conference' : 'article';
if(defined('ACTIVE_CONF')){
    $this->title = $_SESSION['active_conf']['short_name'];
}

$this->registerCssFile(DOCURL."design_elements/js/jquery_editable/bootstrap-editable.min.css", ['position' => View::POS_HEAD, 'depends' => 'backend\assets\AppAsset']);
$this->registerJsFile(DOCURL."design_elements/js/jquery_editable/bootstrap-editable.min.js", ['position' => View::POS_END, 'depends' => 'backend\assets\AppAsset']);

$this->registerCssFile("@web/design_elements/css/plugins/dataTables/dataTables.bootstrap.css", ['position' => View::POS_HEAD, 'depends' => 'backend\assets\AppAsset']);
$this->registerJsFile("@web/design_elements/js/plugins/dataTables/jquery.dataTables.js", ['position' => View::POS_END, 'depends' => 'backend\assets\AppAsset']);
$this->registerJsFile("@web/design_elements/js/plugins/dataTables/dataTables.bootstrap.js", ['position' => View::POS_END, 'depends' => 'backend\assets\AppAsset']);
?>
<?php if(IS_GRD_ADMIN) echo $this->render('_statistics',['isConf'=>$isConf,'model' => $searchModel]); ?>
<?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="row article-index">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?= Html::encode(Common::getTitle("{$this->context->id}/{$this->context->action->id}")) ?></h5>

                    <div class="ibox-tools">
                        <?php
                        if(IS_GRD_ADMIN && !$isConf){
                            echo Html::a('<i class="fa fa-send"></i> ' . Common::getTitle("{$this->context->id}/multireminder"), ['multireminder'], ['class' => 'btn btn-danger btn-xs multireminder', 'data-confirm'=>'Send Reminder? Reminder will be sent to applicable articles only out of selected.' ,'data-method'=>'post' ]);
                        }
                        if ($this->context->action->id == 'index' && common::checkActionAccess("{$this->context->id}/create")) {
                            echo Html::a('<i class="fa fa-plus"></i> ' . Common::getTitle("{$this->context->id}/create"), ['create'], ['class' => 'btn btn-primary btn-xs']);
                        }
                        if ($isConf && common::checkActionAccess("{$this->context->id}/createproceeding")) {
                            echo Html::a('<i class="fa fa-plus"></i> ' . Common::getTitle("{$this->context->id}/createproceeding"), ['createproceeding'], ['class' => 'btn btn-primary btn-xs']);
                        }
                        ?>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row m-b-sm m-t-sm">

                    </div>
                    <div class="table-responsive labelspace">
                        <?php Pjax::begin(['id' => 'search-grid-pjax']); ?>
                        <?=
                        GridView::widget([
                            'id' => 'article-grid',
                            'dataProvider' => $dataProvider,
                            'options' => ['class' => 'project-list border-bottom-none'],
                            'tableOptions' => ['class' => 'table table-striped-new',],
                            'summaryOptions' => ['class' => 'dataTables_info'],
                            'layout' => "{items}\n{summary}\n<div class=\"pull-right\">{pager}</div>",

                            'columns' => [
                                [
                                    'class' => 'yii\grid\CheckboxColumn',
                                    'checkboxOptions' => function ($model, $key, $index, $column) use ($isConf) {
                                        return ['data-status-id' => $model->status, 'class'=>'multi-check-action'];
                                    },
                                    'visible' => IS_GRD_ADMIN && !$isConf
                                ],
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
                                    'format' => 'html',
                                    'content' => function ($data){
                                        if(IS_GRD_ADMIN){
                                            return "<ul><li>".$data->article_title."</li><li>".'<a href="#" class="editable-note" data-type="text" data-pk="'.$data->id.'">'.($data->note?$data->note:'Enter Note').'</a>'."</li></ul>";
                                        } else {
                                            return $data->article_title;
                                        }

                                    }
                                ],
                                [
                                    'header' => 'Branch',
                                    'format' => 'html',
                                    'value' => function ($model, $key, $index, $column) {
                                        return ($model->branch_id == "13") ? $model->branch_name : $model->branch->name;
                                    }
                                ],
                                [
                                    'attribute' => 'status',
                                    'format' => 'raw',
                                    'value' => function ($model, $key, $index, $column) use ($isConf) {
                                        $color = "label-primary";
                                        if ($model->r_request_sent == 1) {
                                            $requested = "<p title='Review Request'>RR: " . $model->requestedReviewer . "</p>";
                                        } else {
                                            $requested = "";
                                        }
                                        if ($model->sent_for_review == 1) {
                                            $r_sent = "<p title='Sent to Reviewer'>" . (Html::a("STR: {$model->sentReviewer}", ['ar/index', 'id' => $model->id],['data-pjax'=>'0'])) . "</p>";
                                        } else {
                                            $r_sent = "";
                                        }

                                        $f_sent = "";
                                        if (IS_GRD_ADMIN && $model->status >= 13 && $model->sentFormatters != "") {
                                            $f_sent = "<p title='Sent to Formatter'>" . (Html::a("FMTR: {$model->sentFormatters}", ['af/index', 'id' => $model->id],['data-pjax'=>'0'])) . "</p>";
                                        }

                                        if ($model->status == 6) $color = "label-warning";
                                        if ($model->status == 15 && $model->published) $model->status = 20;

                                        if($isConf && IS_GRD_ADMIN){
                                            $checked = $model->allow_certi ? "checked = 'checked' ":"";
                                            $value = $model->allow_certi ? "1":"0";
                                            $checkbox = "<p><input value='$value' class='trigger-certi' type='checkbox' data-id='{$model->id}' name='allow_certi' $checked> Allow Certificate</p>";
                                        } else {
                                            $checkbox = "";
                                        }


                                        return '<span class="label ' . $color . '">' . $model->getStatusArray()[$model->status] . '</span>' . $requested . $r_sent . $f_sent . $checkbox;
                                    }
                                ],
                                [
                                    'header' => 'Information',
                                    'format' => 'raw',
                                    'contentOptions' => ['class'=>'link-no-margin'],
                                    'content'=>function($data) use ($isConf,$arDir) {

                                        $copyFile = ((!$data->copyright_file) ? "" : (Html::a("<span class='label label-warning'>Copyright</span>", DOCURL . "uploads/$arDir/" . $data->copyright_file, ['data-pjax' => 0, 'target' => '_blank'])));
                                        $paymentFile = (($data->payment_file && !$isConf) ? (Html::a("<span class='label label-success'>Payment</span>", DOCURL . "uploads/$arDir/" . $data->payment_file, ['data-pjax' => 0, 'target' => '_blank'])):"");
                                        $cpFiles = $copyFile . $paymentFile;

                                        if(IS_GRD_ADMIN){
                                            $formattedFile = (($data->status == 15) ? (Html::a("<span class='label label-danger'>Formatted Article</span>", DOCURL . "uploads/$arDir/" . $data->formatted_file, ['data-pjax' => 0, 'target' => '_blank'])) : "");
                                        } else {
                                            $formattedFile = "";
                                        }
                                        $reviewerSpan = ($isConf ? "" : (($data->reviewer_id == '0') ? ('') : ("<span>Reviewer: {$data->reviewer->full_name}</span>")));
                                        $formatSpan = (( !IS_GRD_ADMIN || $data->formatter_id == '0') ? ('') : ("<span>Formatter: {$data->formatter->name}</span>"));
                                        return $cpFiles . $formattedFile . $reviewerSpan . $formatSpan;
                                    }
                                ]
                                /*[
                                    'header' => 'Action',
                                    'format' => 'raw',

                                ],*/
                            ],
                            'afterRow'=>function ($model, $key, $index, $column) use ($isConf) {

                                $updateButton = $isConf && $model->is_submitted && IS_CONF_USER?'':('<a class="btn btn-success btn-sm" href="' . Url::to([($isConf ? 'updateproceeding' : 'update'), 'id' => $model->id]) . '" title="Edit"><i class="fa fa-pencil" data-pjax="0"></i></a>');
                                $sendCerti = '<a class="btn btn-danger btn-sm sendcertificate" href="' . Url::to(['sendcertificate', 'id' => $model->id]) . '" data-id="' . $model->id . '" data-pjax="0" data-confirm="Do you really want to send Certificates?"  ><i class="fa fa-send"></i> Send Certificates </a>';
                                $checkCerti = ((($isConf && ( IS_GRD_ADMIN || ($model->status >= '1' && $model->is_submitted && $model->copyright_file && $model->allow_certi == 1))) || (!$isConf && $model->status >= '10')) ? ('<a class="btn btn-success btn-sm checkcertificate" href="' . Url::to(['checkcertificate', 'id' => $model->id]) . '" data-id="' . $model->id . '" data-pjax="0" ><i class="fa fa-download"></i> Download Certi. </a>' . $sendCerti) : (""));

                                $frontPublished = "";
                                $copyRightButton = "";
                                if($isConf && (IS_GRD_ADMIN || !$model->copyright_file)){
                                    $copyRightButton = '<a class="btn btn-primary btn-sm upload-copyright" href="' . Url::to(['uploadcopyright', 'id' => $model->id]) . '" data-id="' . $model->id . '" data-pjax="0" ><i class="fa fa-send"></i> Upload Copyright </a>';
                                }
                                if(IS_GRD_ADMIN){
                                    $formatButton = ((($model->status == '10' || ($model->status == '13' && $model->formatter_id == '0')) || ($isConf && $model->status == '1')) ? ('<a class="btn btn-danger btn-sm sendtoformatter" href="' . Url::to(['sendtoformatter', 'id' => $model->id]) . '" data-id="' . $model->id . '" data-pjax="0" ><i class="fa fa-send"></i> Send to Formatter </a>') : (""));
                                    $deleteButton = '<a class="btn btn-success btn-sm" data-pjax="0" data-method="post" data-confirm="Are you sure you want to delete this item?" aria-label="Delete" title="Delete" href="' . Url::to(['delete', 'id' => $model->id]) . '" ><i class="fa fa-trash"></i></a>';
                                    $submitText = "Lock Article";
                                    $submitWarning = "Are you sure you want to lock this article? Conference User will not be able to update this article after this action.";
                                    $unlockWarning = "Are you sure you want to unlock this article?";
                                    $authorMail = '<a class="btn btn-success btn-sm author-mail" data-pjax="0" aria-label="Author Mail" title="Author Mail" href="' . Url::to(['authormail', 'id' => $model->id]) . '" ><i class="fa fa-send"></i></a>';
                                } else {
                                    $formatButton = "";
                                    $deleteButton = "";
                                    $submitText = "Submit to GRD";
                                    $submitWarning = "Are you sure you want to submit this article? You will not be able to update this article after this action.";
                                    if($model->status == '20'){
                                        $frontPublished = '<a class="btn btn-danger btn-sm" href="' . Yii::$app->urlManagerFrontend->createAbsoluteUrl(['page/article','paper_id'=>$model->paper_id]) . '" data-pjax="0" target="_blank"><i class="fa fa-file-powerpoint-o"></i> View Published Article </a>';
                                    }
                                    $authorMail = "";
                                }

                                $submitButton = $isConf && !$model->is_submitted?('<a class="btn btn-danger btn-sm" href="' . Url::to(['submit', 'id' => $model->id]) . '" data-id="' . $model->id . '" data-pjax="0" data-method="post" data-confirm="' . $submitWarning . '" ><i class="fa fa-thumbs-o-up"></i> ' . $submitText . ' </a>'):("");
                                $unlockButton = IS_GRD_ADMIN && $isConf && $model->is_submitted?('<a class="btn btn-warning btn-sm" href="' . Url::to(['unlock', 'id' => $model->id]) . '" data-id="' . $model->id . '" data-pjax="0" data-method="post" data-confirm="' . $unlockWarning . '" ><i class="fa fa-thumbs-o-up"></i> Unlock Article </a>'):("");
                                $accept  = '<div class="btn-group">
                                                <button data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle"><i class="fa fa-thumbs-o-up"></i> Accept <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="' . Url::to(['accept', 'id' => $model->id]) . '" data-id="' . $model->id . '" data-params=\'{"accept_type":"1"}\' data-pjax="0" data-method="post" data-confirm="Accept This Article without revision?" >Accepted without revision</a></li>
                                                    <li><a href="' . Url::to(['accept', 'id' => $model->id]) . '" data-id="' . $model->id . '" data-params=\'{"accept_type":"2"}\' data-pjax="0" data-method="post" data-confirm="Accept This Article with minor revision?" >Minor revision required (Not mandatory)</a></li>
                                                    <li><a href="' . Url::to(['accept', 'id' => $model->id]) . '" data-id="' . $model->id . '" data-params=\'{"accept_type":"3"}\' data-pjax="0" data-method="post" data-confirm="Accept This Article with major revision?" >Major Revision Required(Mandatory)</a></li>
                                                </ul>
                                            </div>';

                                $html =
                                    '<tr class="border-bottom-grey"><td colspan="6">'
                                    .'<a class="btn btn-success btn-sm" href="' . Url::to(['view', 'id' => $model->id]) . '" title="View"><i class="fa fa-search"></i></a>'
                                    . $updateButton
                                    . '<a class="btn btn-success btn-sm" href="' . DOCURL . "uploads/" . ($isConf ? 'conference' : 'article') . "/" . $model->article_file . '" data-pjax="0" title="Read Article"><i class="fa fa-book"></i></a>'
                                    . $deleteButton
                                    . $authorMail
                                    . ($isConf ? "" : (($model->reviewer_id == '0') ? ('<a class="btn btn-danger btn-sm reviewrequest" href="' . Url::to(['reviewrequest', 'id' => $model->id]) . '" data-id="' . $model->id . '" data-pjax="0" ><i class="fa fa-send"></i> Review Request </a>') : ("")))
                                    . ($isConf ? "" : (($model->reviewer_id == '0') ? ('<a class="btn btn-danger btn-sm sendtoreviewer" href="' . Url::to(['sendtoreviewer', 'id' => $model->id]) . '" data-id="' . $model->id . '" data-pjax="0" ><i class="fa fa-send"></i> Send To Reviewer </a>') : ("")))
                                    . ($isConf ? "" : (($model->status >= '3') ? ('<a class="btn btn-danger btn-sm showreview" href="' . Url::to(['showreview', 'id' => $model->id]) . '" data-id="' . $model->id . '" data-pjax="0" ><i class="fa fa-ticket"></i> Show Review </a>') : ("")))
                                    . ($isConf ? "" : (($model->status <= '3') ? ('<a class="btn btn-success btn-sm plagiarism" href="' . Url::to(['plagiarism', 'id' => $model->id]) . '" data-id="' . $model->id . '" data-pjax="0" ><i class="fa fa-note"></i> Plagiarism Note </a>') : ("")))
                                    . ($isConf ? "" : (($model->status == '3') ? ($accept) : ("")))
                                    . ($isConf ? "" : (($model->status == '3') ? ('<a class="btn btn-danger btn-sm" href="' . Url::to(['reject', 'id' => $model->id]) . '" data-id="' . $model->id . '" data-pjax="0" data-method="post" data-confirm="Reject This Article?" ><i class="fa fa-thumbs-o-down"></i> Reject </a>') : ("")))
                                    . ($isConf ? "" : (($model->status == '5') ? ('<a class="btn btn-danger btn-sm" href="' . Url::to(['reminder', 'id' => $model->id]) . '" data-id="' . $model->id . '" data-pjax="0" data-method="post" data-confirm="Send Reminder Mail?" ><i class="fa fa-send"></i> Send Reminder </a>') : ("")))
                                    . ($isConf ? "" : (($model->status == '7') ? ('<a class="btn btn-danger btn-sm acceptpay" href="' . Url::to(['acceptpay', 'id' => $model->id]) . '" data-id="' . $model->id . '" data-pjax="0"><i class="fa fa-thumbs-o-up"></i> Accept Payment </a>') : ("")))
                                    . $checkCerti
                                    . $formatButton
                                    . (($model->status == '15' && IS_GRD_ADMIN) ? ('<a class="btn btn-danger btn-sm" href="' . Url::to(['published/create', 'id' => $model->id]) . '" data-pjax="0" ><i class="fa fa-file-powerpoint-o"></i> Publish an Article </a>') : (""))
                                    . (($model->status == '20' && IS_GRD_ADMIN) ? ('<a class="btn btn-danger btn-sm" href="' . Url::to(['published/update', 'id' => $model->published->id]) . '" data-pjax="0" ><i class="fa fa-file-powerpoint-o"></i> View Published Article </a>') : (""))
                                    . $submitButton
                                    . $unlockButton
                                    . $copyRightButton
                                    . $frontPublished
                                    . '</td></tr>';
                                return $html;
                            },
                        ]);
                        ?>
                        <?php Pjax::end(); ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal inmodal" id="sendtoreviewer" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
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
    <div class="modal inmodal" id="reviewrequest" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only"><?= backend\vendors\Common::translateText('CLOSE_BTN_TEXT') ?></span>
                    </button>
                    <h4 class="modal-title">Review Request</h4>
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
    <div class="modal inmodal" id="upload-copyright" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only"><?= backend\vendors\Common::translateText('CLOSE_BTN_TEXT') ?></span>
                    </button>
                    <h4 class="modal-title">Upload Copyright Document</h4>
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
                    <?php $xform = ActiveForm::begin(['enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => 'col-sm-4'], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>
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
if (Yii::$app->session->has('aid_highlight')) {
    $h_aid = Yii::$app->session->get('aid_highlight');
    $this->registerJs(
        "$('#search-grid-pjax table tr[data-key=\"$h_aid\"]').addClass('highlight-ar');", View::POS_READY
    );
    Yii::$app->session->remove('aid_highlight');
}
$this->registerJs(
    "$('#search-grid-pjax').on('click', '.sendtoreviewer',function (e) {
            e.preventDefault();
            obj = $(this);
            $.get(obj.attr('href'), {}, function (data) {
                $('#sendtoreviewer .modal-body').html(data);
                $('#sendtoreviewer').modal('show');
            });
    });", View::POS_READY
);
$this->registerJs(
    "$('#search-grid-pjax').on('click', '.reviewrequest',function (e) {
            e.preventDefault();
            obj = $(this);
            $.get(obj.attr('href'), {}, function (data) {
                $('#reviewrequest .modal-body').html(data);
                $('#reviewrequest').modal('show');
            });
    });", View::POS_READY
);
$this->registerJs(
    "$('#search-grid-pjax').on('click', '.sendtoformatter',function (e) {
            e.preventDefault();
            obj = $(this);
            $.get(obj.attr('href'), {}, function (data) {
                $('#sendtoformatter .modal-body').html(data);
                $('#sendtoformatter').modal('show');
            });
    });", View::POS_READY
);
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
    "$('#search-grid-pjax').on('click', '.plagiarism',function (e) {
            e.preventDefault();
            obj = $(this);
            $.get(obj.attr('href'), {}, function (data) {
                $('#plagiarism .modal-content').html(data);
                $('#plagiarism').modal('show');
            });
    });", View::POS_READY
);
$this->registerJs(
    "$('#search-grid-pjax').on('click', '.acceptpay',function (e) {
            e.preventDefault();
            obj = $(this);
            $('#acceptpay form').attr('action',obj.attr('href'));
            $('#acceptpay').modal('show');
    });", View::POS_READY
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
    }", View::POS_HEAD
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
    });", View::POS_READY
);
$this->registerJs(
    "$('#search-grid-pjax').on('click', '.upload-copyright',function (e) {
            e.preventDefault();
            obj = $(this);
            $.get(obj.attr('href'), {}, function (data) {
                $('#upload-copyright .modal-body').html(data);
                $('#upload-copyright').modal('show');
            });
    });", View::POS_READY
);
$this->registerJs(
    "$('#search-grid-pjax').on('change', '.multi-check-action, .select-on-check-all',function (e) {
           var a_keys = $('#article-grid').yiiGridView('getSelectedRows');
           a_keys = a_keys.join();
           $('.multireminder').data('params',{id:a_keys});
    });", View::POS_READY
);
?>
<?php
$this->registerJs("

    function updateArticleGrid(){
        $('.editable-note').editable({
            url: '".Url::to(['article/note'])."',
            type: 'text',
            _csrf : yii.getCsrfToken(),
            name: 'note',
            title: 'Enter Note',
            validate: function(value) {
                if($.trim(value) == '') {
                    return 'This field is required';
                }
            },
            success: function(response, newValue) {
                if(!response.success) return response.msg;
            }
        });
        $('.trigger-certi').change(function(){
          var eid = $(this).data('id');
          var obj = $(this);
          if(obj.is(':checked')){
            obj.val('1');
          }else{
            obj.val('0');
          }
          $.post('" . Url::to(['article/allowcerti']) . "',{id:eid, value:obj.val()},function(response){
            if(response.result == false){
              alert(response.text);
            }
          },'json');
        });
    };
    updateArticleGrid();
    $('#search-grid-pjax').on('pjax:end', function() {
            updateArticleGrid();
    });

    ",View::POS_END);
?>