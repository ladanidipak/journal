<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div role="main" class="main">
    <section class="page-header page-header-color page-header-primary page-header-float-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-xs">Upcoming Conference</h1>
                    <ul class="breadcrumb breadcrumb-valign-mid">
                        <li><a href="/">Home</a></li>
                        <li class="active">Upcoming Conference</li>
                    </ul>
                </div>
            </div>
            <?php if ($upcoming_conf) { ?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel-group panel-group-primary" id="accordion2Primary">
                    <?php foreach ($upcoming_conf as $co): ?>
                            <?php
                            $conf_id = 'GRDCF' . sprintf("%03d", $co['id']);
                            ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2Primary" href="#collapse<?= $co['id'] ?>">
                                    <?= $co['title'] ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse<?= $co['id'] ?>" class="accordion-body collapse in">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4"><img style="max-width:250px;width: 250px;" class="college-logo" alt="<?= $co['title'] ?>" src="<?= DOCURL . "uploads/college_logo/" . $co['college_logo'] ?>"></div>
                                    <div class="col-sm-8 conf-right-desc">
                                        <div class="row">
                                            <div class="col-sm-3">Conference Id</div>
                                            <div class="no-text-ul col-sm-1">:</div>
                                            <div class="col-sm-7"><?= $conf_id; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">Organized By</div>
                                            <div class="no-text-ul col-sm-1">:</div>
                                            <div class="col-sm-7"><?= $co['org_name']; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">Date</div>
                                            <div class="no-text-ul col-sm-1">:</div>
                                            <div class="col-sm-7"><?= $co['conf_date']; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">Venue</div>
                                            <div class="no-text-ul col-sm-1">:</div>
                                            <div class="col-sm-7"><?= $co['venue']; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3"><a class="btn btn-primary" target="_blank" href="<?= DOCURL . "uploads/brochure/" . $co['brochure'] ?>">
                                                    Brochure
                                                </a>
                                            </div>
                                            <div class="no-text-ul col-sm-1">&nbsp;</div>
                                            <div class="col-sm-7"><a class="btn btn-primary" href="<?= Url::to(['page/proceedings', 'id' => $conf_id]) ?>">
                                                    View Conference Proceedings
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php } ?>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="heading heading-border heading-middle-border heading-middle-border-center center">
                <h2><span class="text-color-secondary">PREVIOUS CONFERENCE</span></h2>
            </div>
        </div>
        <?php if ($prev_conf) { ?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel-group panel-group-primary" id="accordion2Primary">
                    <?php foreach ($prev_conf as $co): ?>
                            <?php
                            $conf_id = 'GRDCF' . sprintf("%03d", $co['id']);
                            ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2Primary" href="#collapse<?= $co['id'] ?>">
                                    <?= $co['title'] ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse<?= $co['id'] ?>" class="accordion-body collapse in">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4"><img style="max-width:250px;width: 250px;" class="college-logo" alt="<?= $co['title'] ?>" src="<?= DOCURL . "uploads/college_logo/" . $co['college_logo'] ?>"></div>
                                    <div class="col-sm-8 conf-right-desc">
                                        <div class="row">
                                            <div class="col-sm-3">Conference Id</div>
                                            <div class="no-text-ul col-sm-1">:</div>
                                            <div class="col-sm-7"><?= $conf_id; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">Organized By</div>
                                            <div class="no-text-ul col-sm-1">:</div>
                                            <div class="col-sm-7"><?= $co['org_name']; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">Date</div>
                                            <div class="no-text-ul col-sm-1">:</div>
                                            <div class="col-sm-7"><?= $co['conf_date']; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">Venue</div>
                                            <div class="no-text-ul col-sm-1">:</div>
                                            <div class="col-sm-7"><?= $co['venue']; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3"><a class="btn btn-primary" target="_blank" href="<?= DOCURL . "uploads/brochure/" . $co['brochure'] ?>">
                                                    Brochure
                                                </a>
                                            </div>
                                            <div class="no-text-ul col-sm-1">&nbsp;</div>
                                            <div class="col-sm-7"><a class="btn btn-primary" href="<?= Url::to(['page/proceedings', 'id' => $conf_id]) ?>">
                                                    View Conference Proceedings
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
