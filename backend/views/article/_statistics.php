<?php

use backend\models\ArticleStatistics;

/* @var $this yii\web\View */
/* @var $model backend\models\search\ArticleSearch */
/* @var $form yii\widgets\ActiveForm */
if ($isConf) {
    $stats = ArticleStatistics::getStats(['conf_id' => $model->conf_id]);
} else {
    $stats = ArticleStatistics::getStats(['voliss_id' => $model->voliss_id]);
}

?>
    <div class="row article-statistics">
        <div class="col-sm-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Total Article</h5>

                    <div class="ibox-tools master-tool-box">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?= $stats['total']; ?></h1>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Current articles</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?= $stats['current']; ?></h1>
                </div>
            </div>
        </div>
        <?php if (!$isConf) { ?>
            <div class="col-sm-2">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Accepted articles</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><?= $stats['accepted']; ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Rejected Artcles</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><?= $stats['rejected']; ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Payment Done</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><?= $stats['payment_done']; ?></h1>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="col-sm-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Published Article</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?= $stats['published']; ?></h1>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerJs(
    "$('.master-tool-box .collapse-link').click(function(){
  if($(this).find('i').hasClass('fa-chevron-down')){
    $('.article-statistics .ibox-content').slideUp();
  } else {
    $('.article-statistics .ibox-content').slideDown();
  }
});
$('.master-tool-box .close-link').click(function(){
    $('.article-statistics').hide();
});", $this::POS_READY
)

?>