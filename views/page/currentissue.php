<?php

use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;

$this->registerJsFile("@web/design_elements/js/clipboard.min.js", ['position' => View::POS_END, 'depends' => 'app\assets\AppAsset']);

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
if (isset($specialIssue)) {
    $isConf = true;
    $fileDir = "conference";
} else {
    $specialIssue = false;
    if ($currentIssue->tableName() == 'conference') {
        $isConf = true;
        $fileDir = "conference";
    } else {
        $isConf = false;
        $fileDir = "article";
    }
}
?>
<div role="main" class="main">
    <section class="page-header page-header-color page-header-primary page-header-float-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-xs"><?= $content->page_title; ?></h1>
                    <ul class="breadcrumb breadcrumb-valign-mid">
                        <li><a href="/">Home</a></li>
                        <li class="active"><?= $content->page_title; ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="row">
            <div class="heading heading-border heading-middle-border heading-middle-border-center center">
                <h2><span class="text-color-secondary"><?= $content->page_title; ?></span></h2>
            </div>
        </div>
        <div class="row data">
            <!---item-->
            <div class="col-md-12 ">
                <?php if ($isConf && !$specialIssue): ?>
                    <?php
                    $co = $currentIssue->attributes;
                    $conf_id = 'GRDCF' . sprintf("%03d", $co['id']);
                    ?>
                    <div id="accordion_conf" class="panel-group conference-listing">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><a href="#collapse-conf-<?= $co['id'] ?>" data-toggle="collapse"
                                                           data-parent="#accordion_conf"><?= $co['title'] ?></a></h4>
                            </div>
                            <div id="collapse-conf-<?= $co['id'] ?>" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-4"><img class="college-logo" alt="<?= $co['title'] ?>"
                                                                   src="<?= DOCURL . "uploads/college_logo/" . $co['college_logo'] ?>">
                                        </div>
                                        <div class="col-sm-8 conf-right-desc">
                                            <?php
                                            $sDiv = "col-xs-3";
                                            $mDiv = "col-xs-1";
                                            $lDiv = "col-xs-7";
                                            ?>
                                            <div class="row">
                                                <div class="<?= $sDiv ?>">Conference Id</div>
                                                <div class="no-text-ul <?= $mDiv ?>">:</div>
                                                <div class="<?= $lDiv ?>"><?= $conf_id; ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="<?= $sDiv ?>">Organized By</div>
                                                <div class="no-text-ul <?= $mDiv ?>">:</div>
                                                <div class="<?= $lDiv ?>"><?= $co['org_name']; ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="<?= $sDiv ?>">Date</div>
                                                <div class="no-text-ul <?= $mDiv ?>">:</div>
                                                <div class="<?= $lDiv ?>"><?= $co['conf_date']; ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="<?= $sDiv ?>">Venue</div>
                                                <div class="no-text-ul <?= $mDiv ?>">:</div>
                                                <div class="<?= $lDiv ?>"><?= $co['venue']; ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="<?= $sDiv ?>">Brochure</div>
                                                <div class="no-text-ul <?= $mDiv ?>">:</div>
                                                <div class="<?= $lDiv ?>">
                                                    <a target="_blank"
                                                       href="<?= DOCURL . "uploads/brochure/" . $co['brochure'] ?>">
                                                        Click Here to View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">&nbsp;</div>
                <?php else: ?>
                    <?php if ($specialIssue) { ?>
                        <h4>Special Issues</h4>
                    <?php } else { ?>
                        <h4>Publication for Volume-<?= $currentIssue->volume ?> Issue-<?= $currentIssue->issue ?>, <?= $currentIssue->detail ?> </h4>
                    <?php } ?>

                <?php endif; ?>
            </div>
            <!---item-->
            <!---item-->
            <?php $count = 0; ?>
            <?php foreach ($published as $publish): ?>
                <?php $count++; ?>
                <div class="col-md-12">
                    <div class="tabs" style="margin-bottom: 0;">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#details<?= $count ?>" data-toggle="tab">Details</a>
                            </li>
                            <li>
                                <a href="#abstract<?= $count ?>" data-toggle="tab">Abstract</a>
                            </li>
                            <li>
                                <a href="#reference<?= $count ?>" data-toggle="tab">Reference</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="details<?= $count ?>" class="tab-pane active">
                                <div class="row">
                                    <div class="col-xs-3">Title</div>
                                    <div class="no-text-ul col-xs-1">:</div>
                                    <div class="col-xs-7"><?= $publish->title; ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3">Article Type</div>
                                    <div class="no-text-ul col-xs-1">:</div>
                                    <div class="col-xs-7"><?= $publish->article->type->name; ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3">Author Name(s)</div>
                                    <div class="no-text-ul col-xs-1">:</div>
                                    <div class="col-xs-7"><?= $publish->authors; ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3">Country</div>
                                    <div class="no-text-ul col-xs-1">:</div>
                                    <div class="col-xs-7"><?= ($publish->article->country) ? $publish->article->country : "India"; ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3">Research Area</div>
                                    <div class="no-text-ul col-xs-1">:</div>
                                    <div class="col-xs-7">
                                        <?php
                                        if ($publish->article->research_area) {
                                            echo $publish->article->research_area;
                                        } else {
                                            echo ($publish->article->branch_id == "13") ? $publish->article->branch_name : $publish->article->branch->name;
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div id="abstract<?= $count ?>" class="tab-pane">
                                <p><?= $publish->abstract; ?></p>
                                <p>Keywords : <?= $publish->keywords; ?></p>
                            </div>
                            <div id="reference<?= $count ?>" class="tab-pane">
                                <p>Recent</p>
                                <p><?= $publish->reference; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-dark">
                        <ul class="nav nav-tabs mlveda-archive">
                            <li><a  class="citation-link btn btn-info btn-lg">Cite</a>
                                <span class="citation-hide">
                                    <?php
                                    $authorsname = $publish->article->author_name;
                                    if(isset($publish->article->author_name) && !empty($publish->article->author_name))
                                    foreach ($publish->article->coauthors as $author){
                                        $authorsname .= ', '.$author->name;
                                    } 
                                    if ($isConf) {
                                        $cvi = "";
                                    } else {
                                        $cvi = $currentIssue->volume .'.'. $currentIssue->issue . " (" . date('Y', strtotime($currentIssue->last_date)).')';
                                    }
    //                                    ob_clean();
    //                                    echo '<pre>' . print_r($publish, true) . '</pre>';
    //                                    echo '<pre>' . print_r($publish->article->conference->org_name, true) . '</pre>';
    //                                    exit();
    
                                    ?>
                                    <?php if($publish->article->conf_id == 0){ ?>
                                        <?= $authorsname . ". \"$publish->title.\" Global Research and Development Journal For Engineering  $cvi: $publish->start_page" . " - " . "$publish->end_page." ?>
                                    <?php }else{?>
                                        <?= $authorsname . ". \"$publish->title.\" Global Research and Development Journal For Engineering [" .$publish->article->conference->short_name."]".$cvi.", ".$publish->article->conference->org_name ." ".$publish->article->conference->aff_by.", (".date("F Y", strtotime($publish->article->conference->pub_date)).") : pp. $publish->start_page" . " - " .$publish->end_page."."  ?>
                                        <?php // $authorsname . ". \"$publish->title.\" Global Research and Development Journal For Engineering  $cvi , ".$publish->article->conference->org_name ." - ".$publish->article->conference->short_name. ", Special Issue, pg $publish->start_page" . " - " . "$publish->end_page,".date("F Y", strtotime($publish->article->conference->pub_date)).', '.$publish->article->conference->aff_by ;  ?>
                                    <?php } ?>
                                </span>
                            </li>
                            <li><a href="<?= Url::to(['page/article', 'paper_id' => $publish->article->paper_id]) ?>">View</a></li>
                            <li><a target="_blank" href="<?= DOCURL . "uploads/$fileDir/" . $publish->pdf ?>">Download</a>
                                <?php if ($publish->google_scholar): ?>
                                <li><a target="_blank" href="<?= $publish->google_scholar ?>">Google Scholar</a>
                                <?php endif; ?>
                            </li>
                            <li class="float-right-no-style" style="float:right;"><a class="btn btn-info" href="#"><?php echo "Page(s): " . $publish->start_page . " - " . $publish->end_page ?></a></li>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php
            echo LinkPager::widget([
                'pagination' => $pages,
            ]);
            ?>
            <!---/item--><!---item-->
            <div class="modal fade" id="citation-modal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" style="font-size:15px;color:#000;">Citation</h4>
                        </div>
                        <div class="modal-body">
                            <p style="font-size:15px;">

                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>

            <!---/item-->
        </div>


    </div>
</div>
<?php
$this->registerJs("$('.citation-link').click(function(){
        var html = $(this).next().text();
        $('#citation-modal .modal-body').html(html);
        $('#citation-modal').modal('show');
    });
    var clipboard = new Clipboard('.btn-copy');
    ", View::POS_READY);
?>