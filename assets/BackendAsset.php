<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BackendAsset extends AssetBundle
{
    public $basePath = '@webroot/backend';
    public $baseUrl = '@web/backend';
    public $css = [
        'design_elements/css/bootstrap.min.css',
        'design_elements/font-awesome/css/font-awesome.css',
        'design_elements/css/plugins/chosen/chosen.css',
        'design_elements/css/plugins/datapicker/datepicker3.css',
        'design_elements/css/plugins/footable/footable.core.css',
        'design_elements/css/plugins/toastr/toastr.min.css',
        'design_elements/js/plugins/gritter/jquery.gritter.css',
        'design_elements/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css',
        'design_elements/css/plugins/jsTree/style.min.css',
        'design_elements/css/animate.css',
        'design_elements/css/style.css',
        'design_elements/css/developer.css',
    ];
    public $js = [
        'design_elements/js/bootstrap.min.js',
        'design_elements/js/plugins/chosen/chosen.jquery.js',
        'design_elements/js/plugins/datapicker/bootstrap-datepicker.js',
        'design_elements/js/plugins/metisMenu/jquery.metisMenu.js',
        'design_elements/js/plugins/slimscroll/jquery.slimscroll.min.js',
        'design_elements/js/plugins/flot/jquery.flot.js',
        'design_elements/js/plugins/flot/jquery.flot.spline.js',
        'design_elements/js/plugins/peity/jquery.peity.min.js',
        'design_elements/js/demo/peity-demo.js',
        'design_elements/js/inspinia.js',
        'design_elements/js/plugins/pace/pace.min.js',
        'design_elements/js/plugins/gritter/jquery.gritter.min.js',
        'design_elements/js/plugins/sparkline/jquery.sparkline.min.js',
        'design_elements/js/demo/sparkline-demo.js',
        'design_elements/js/plugins/chartJs/Chart.min.js',
        'design_elements/js/plugins/toastr/toastr.min.js',
        'design_elements/js/plugins/footable/footable.all.min.js',
        'design_elements/js/plugins/jsTree/jstree.min.js',
    ];
    public $depends = [
        'app\assets\BackendJqueryAssets',
        'yii\web\YiiAsset',
    ];
}
