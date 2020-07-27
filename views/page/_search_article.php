<?php

use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use backend\models\VolIss;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$isConf = $model->article->conf_id ? true : false;
$fileDir = $isConf ? "conference" : "article";
if (!$isConf) {
    $currentIssue = VolIss::findOne($model->article->voliss_id);
}
?>
<div class="col-md-12">
    <div class="tabs" style="margin-bottom: 0;">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#ar-details-<?= $index ?>" data-toggle="tab">Details</a>
            </li>
            <li>
                <a href="#ar-abstract-<?= $index ?>" data-toggle="tab">Abstract</a>
            </li>
            <li>
                <?php if (!empty($model->reference)) { ?>
                    <a href="#ar-reference-<?= $index ?>" data-toggle="tab">Reference</a>
                <?php } ?>
            </li>
        </ul>
        <div class="tab-content">
            <div id="ar-details-<?= $index ?>" class="tab-pane active">
                <div class="row">
                    <div class="col-xs-3">Title</div>
                    <div class="no-text-ul col-xs-1">:</div>
                    <div class="col-xs-7"><?= $model->title; ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-3">Article Type</div>
                    <div class="no-text-ul col-xs-1">:</div>
                    <div class="col-xs-7"><?= $model->article->type->name; ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-3">Author Name(s)</div>
                    <div class="no-text-ul col-xs-1">:</div>
                    <div class="col-xs-7"><?= $model->authors; ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-3">Country</div>
                    <div class="no-text-ul col-xs-1">:</div>
                    <div class="col-xs-7"><?= $model->article->country; ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-3">Research Area</div>
                    <div class="no-text-ul col-xs-1">:</div>
                    <div class="col-xs-7"><?= $model->article->research_area; ?></div>
                </div>
            </div>
            <div id="ar-abstract-<?= $index ?>" class="tab-pane">
                <pre><?= $model->abstract; ?></pre>
                <pre>Keywords : <?= $model->keywords; ?></pre>
            </div>
            <div id="ar-reference-<?= $index ?>" class="tab-pane">
                <pre><?= $model->reference; ?></pre>
            </div>
        </div>
    </div>
    <div class="alert alert-dark">
        <ul class="nav nav-tabs mlveda-archive">
            <li><a  class="citation-link btn btn-info btn-lg" href="javascript:void()">Cite</a>
                <span class="citation-hide">
                   <?php
                    if ($isConf) {
                        $cvi = "";
                    } else {
                        $cvi = $currentIssue->volume . $currentIssue->issue . " " . date('Y', strtotime($currentIssue->last_date));
                    }
                    ?>
                    <?= $model->authors . ". \"$model->title.\" Global Research and Development Journal For Engineering  $cvi: $model->start_page" . " - " . "$model->end_page." ?>
                </span>
            </li>
            <li><a href="<?= Url::to(['page/article', 'paper_id' => $model->article->paper_id]) ?>">View</a></li>
            <li><a target="_blank" href="<?= DOCURL . "uploads/$fileDir/" . $model->pdf ?>">Download</a></li>
            <li class="float-right-no-style"><a class="btn btn-info" href="#"><?php echo "Page(s): " . $model->start_page . " - " . $model->end_page ?></a></li>
        </ul>
    </div>
</div>
