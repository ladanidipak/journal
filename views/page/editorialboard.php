<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
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
        <!--<div class="row">
            <div class="heading heading-border heading-middle-border heading-middle-border-center center">
                <h2><span class="text-color-secondary"><?= $content->page_title; ?></span></h2>
            </div>
        </div>-->
        <?= $content->content; ?>
        <div class="row">
            <h2 class="text-center">Advisory/Editorial/Reviewer Board Members</h2>
            <div class="col-md-6">
                <div class="panel-group panel-group-primary" id="accordion2Primary">
                    <?php
                    $count = 0;
                    foreach ($reviewers as $reviewer):;
                        ?>
                        <?php if ($count % 2 == 0) { ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2Primary" href="#collapse<?= $count ?>">
                                            <?php // if (isset($reviewer['profile_pic']) && $reviewer['profile_pic'] && file_exists('/var/www/uploads' . $reviewer['profile_pic'])) { ?>
                                            <?php if (file_exists(Yii::$app->params['reviewerPath'] . $reviewer['profile_pic']) && isset($reviewer['profile_pic']) && $reviewer['profile_pic']) { ?>
                                                <div class="round-img"><img src="<?= Yii::$app->params['webUrl'] . "/uploads/reviewer_pic/" . $reviewer['profile_pic'] ?>"/></div><?= $reviewer['full_name'] ?>
                                            <?php } else { ?>
                                                <div class="round-img"><img src="<?= BASEURL ?>images/drtheme/default_male.jpg"/></div><?= $reviewer['full_name'] ?>
                                            <?php } ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse<?= $count ?>" class="accordion-body collapse">
                                    <div class="panel-body">
                                        <?php if (file_exists(Yii::$app->params['reviewerPath'] . $reviewer['profile_pic']) && isset($reviewer['profile_pic']) && $reviewer['profile_pic']) { ?>
                                            <div class="main-img"><img src="<?= Yii::$app->params['webUrl'] . "/uploads/reviewer_pic/" . $reviewer['profile_pic'] ?>"/></div>
                                        <?php } else { ?>
                                            <div class="main-img"><img src="<?= BASEURL ?>images/drtheme/default_male.jpg"/></div>
                                        <?php } ?>
                                        <p><?= $reviewer['designation'] ?></p>
                                        <p><p><?= $reviewer['institute_name'] ?></p></p>
                                    </div>
                                </div>
                            </div>
                        <?php }$count ++; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel-group panel-group-primary" id="accordion2Primary">
                    <?php
                    $count1 = 0;
                    foreach ($reviewers as $reviewer):;
                        ?>
                        <?php if ($count1 % 2 != 0) { ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2Primary" href="#collapse<?= $count1 ?>">
                                            <?php if (file_exists(Yii::$app->params['reviewerPath'] . $reviewer['profile_pic']) && isset($reviewer['profile_pic']) && $reviewer['profile_pic']) { ?>
                                                <div class="round-img"><img src="<?= Yii::$app->params['webUrl'] . "/uploads/reviewer_pic/" . $reviewer['profile_pic'] ?>"/></div><?= $reviewer['full_name'] ?>
                                            <?php } else { ?>
                                                <div class="round-img"><img src="<?= BASEURL ?>images/drtheme/default_male.jpg"/></div><?= $reviewer['full_name'] ?>
                                            <?php } ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse<?= $count1 ?>" class="accordion-body collapse">
                                    <div class="panel-body">
                                        <?php if (file_exists(Yii::$app->params['reviewerPath'] . $reviewer['profile_pic']) && isset($reviewer['profile_pic']) && $reviewer['profile_pic']) { ?>
                                            <div class="main-img"><img src="<?= Yii::$app->params['webUrl'] . "/uploads/reviewer_pic/" . $reviewer['profile_pic'] ?>"/></div>
                                        <?php } else { ?>
                                            <div class="main-img"><img src="<?= BASEURL ?>images/drtheme/default_male.jpg"/></div>
                                            <?php } ?>
                                        <p><?= $reviewer['designation'] ?></p>
                                        <p><p><?= $reviewer['institute_name'] ?></p></p>
                                    </div>
                                </div>
                            </div>
                        <?php }$count1 ++; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    </div>
</div>