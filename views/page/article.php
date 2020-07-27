<?php

use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

if ($published->article->conf_id != 0) {
    $isConf = true;
    $fileDir = "conference";
} else {
    $isConf = false;
    $fileDir = "article";
}
?>
<div role="main" class="main">
    <section class="page-header page-header-color page-header-primary page-header-float-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-xs">Article</h1>
                    <ul class="breadcrumb breadcrumb-valign-mid">
                        <li><a href="#">Home</a></li>
                        <li class="active">MPSOEPDP</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="row">
            <div class="heading heading-border heading-middle-border heading-middle-border-center center">
                <h2><span class="text-color-secondary"><?= $published->title ?></span></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-zero">
                <div class="panel-group panel-group-primary" id="accordion2Primary">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" >
                                    Author(s):
                                </a>
                            </h4>
                        </div>
                        <div  class="accordion-body  ">
                            <div class="panel-body">
                                <div class="alert alert-default">
                                    <?= $published->authors ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle">
                                    Keywords
                                </a>
                            </h4>
                        </div>
                        <div  class="accordion-body ">
                            <div class="panel-body">
                                <p><?= $published->keywords ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" >
                                    Abstract
                                </a>
                            </h4>
                        </div>
                        <div  class="accordion-body">
                            <div class="panel-body">
                                <div class="alert alert-default"><?= $published->abstract ?></div>

                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" >
                                    Reference
                                </a>
                            </h4>
                        </div>
                        <div  class="accordion-body">
                            <div class="panel-body">
                                <div class="alert alert-default">
                                    <ul class="list-unstyled" style="margin-left: 0;">
                                        <?= $published->reference ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" >
                                    Other Details
                                </a>
                            </h4>
                        </div>
                        <div  class="accordion-body">
                            <div class="panel-body">
                                <div class="alert1 alert-default1">
                                    Paper ID: <?= $published->article->paper_id ?><br>
                                    <?php if ($isConf): ?>
                                        Published in: Conference : <?= $published->article->conference->title ?><br>
                                    <?php else: ?>
                                        Published in: Volume : <?= $published->article->voliss->volume ?>, Issue : <?= $published->article->voliss->issue ?><br>
                                        Publication Date: <?= $published->article->voliss->publish_date ?><br>
                                    <?php endif; ?>

                                    Page(s): <?= $published->start_page . " - " . $published->end_page ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" >
                                    Article Preview
                                </a>
                            </h4>
                        </div>
                        <div  class="accordion-body">
                            <div class="panel-body">
                                <div class="alert1 alert-default1">
                                    <div class="article_preview_front">
                                        <iframe id="previewFrame" frameborder="0" style="width:100%; height: 500px;" src="http://docs.google.com/gview?url=http://grdjournals.com/uploads/<?= $fileDir ?>/<?= $published->pdf ?>&embedded=true"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-default">
                        <div class="text-center">
                            <a class="roundbutton btn btn-primary" href="<?= Url::to(['/'], true) ?>uploads/<?= $fileDir ?>/<?= $published->pdf ?>" target="_blank"> Download </a>
                            <?php if ($published->google_scholar): ?>
                                &nbsp;
                                <a class="roundbutton" href="<?= $published->google_scholar; ?>" target="_blank"> Google Scholar </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->registerJs("
$('#previewFrame').width($('.article_preview_front').width()-50);

$(window).resize(function(){
        $('#previewFrame').width(0);
        $('#previewFrame').width($('.article_preview_front').width()-50);
});

", \yii\web\View::POS_READY, 'preview_resize') ?>