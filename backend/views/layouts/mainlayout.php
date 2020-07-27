<?php

use backend\assets\AppAsset;
use yii\helpers\Html;
use app\components\LeftMenuWidget;
use app\components\ChatWidget;
use app\components\RightMenuWidget;
use app\components\TopMenuWidget;
use app\components\HeaderWidget;
use app\components\FooterWidget;
use backend\vendors\Common;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo Yii::$app->language; ?>" lang="<?php echo Yii::$app->language; ?>">
    <head>
        <meta charset="<?php echo Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php
        echo Html::csrfMetaTags();
        $this->title = ($this->title)?$this->title:Common::getTitle(Common::getCurrentURL());
        ?>
        <title><?php echo Html::encode($this->title) ?></title>

        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div id="wrapper">
        <?php echo LeftMenuWidget::widget(); ?>
        <div id="page-wrapper" class="gray-bg">
            <?php echo TopMenuWidget::widget(); ?>
            <?php echo HeaderWidget::widget(); ?>
            <div class="wrapper wrapper-content">
                <?php echo $content; ?>
            </div>
            <?php echo FooterWidget::widget(); ?>
        </div>
    </div>
    <?= \app\components\ViewModalWidget::widget(); ?>
    <!-- Page-Level Scripts -->
    <?php
    $this->registerJs('
    var config = {
            \'.chosen-select\': {width: "100%"},
            \'.chosen-select-deselect\': {allow_single_deselect: true},
            \'.chosen-select-no-single\': {disable_search_threshold: 10},
            \'.chosen-select-no-results\': {no_results_text: \'Oops, nothing found!\'},
            \'.chosen-select-width\': {width: "100%"},
            \'.chosen-select-p\': {width: "100%", disable_search_threshold: 10}/*=>Do not change this. Create another if needed*/
        };
            if(typeof tinyMCE !== "undefined"){
                tinyMCE.baseURL = "'. Yii::$app->params['designElementUrl'] .'js/plugins/tinymce";
                tinyMCE.suffix = \'.min\';
            }
            $(\'.form_date_picker\').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: \''. Yii::$app->params['dateFormat'] .'\'
    });

    for (var selector in config) {
    $(selector).chosen(config[selector]);
    }

    $(\'select.form-control:visible\').chosen(config[\'.chosen-select-p\']);


    function dependentDropDown(url, data, target) {
    if (data.id != "") {
    $.get(url, data, function (response) {
    if (response.success == true) {
    $(target).html(response.select);
    //Trigger change is required to update Chosen and other dependencies
    $(target).trigger("chosen:updated");
    } else {
    alert(\'Failed to load data\');
    }
    });
    }

    }
    ', \yii\web\View::POS_READY,'mainlayoutscript');
    ?>

    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
