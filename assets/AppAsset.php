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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'design_elements/css/bootstrap.min.css',
        'design_elements/css/font-awesome.min.css',
        'design_elements/css/prettyPhoto.css',
        //'design_elements/css/price-range.css',
        'design_elements/css/animate.css',
        //'design_elements/css/main.css',
        'design_elements/css/responsive.css',
        'design_elements/css/developer.css',
        //Doctor theme css
        //'design_elements/css/bootstrap.min.css',
        //'design_elements/css/font-awesome.min.css',
        'design_elements/css/drthemecss/animate.min.css',
        'design_elements/css/drthemecss/simple-line-icons.min.css',
        'design_elements/css/drthemecss/owl.carousel.min.css',
        'design_elements/css/drthemecss/owl.theme.default.min.css',
        'design_elements/css/drthemecss/magnific-popup.min.css',
        'design_elements/css/drthemecss/theme.css',
        'design_elements/css/drthemecss/theme-elements.css',
        'design_elements/css/drthemecss/theme-blog.css',
        'design_elements/css/drthemecss/theme-shop.css',
        'design_elements/css/drthemecss/settings.css',
        'design_elements/css/drthemecss/layers.css',
        'design_elements/css/drthemecss/custom.css',
        'design_elements/css/drthemecss/navigation.css',
        'design_elements/css/drthemecss/skin-medical.css',
        'design_elements/css/drthemecss/demo-medical.css',
    ];
    public $js = [
        'design_elements/js/bootstrap.min.js',
        'design_elements/js/jquery.scrollUp.min.js',
        //'design_elements/js/price-range.js',
        'design_elements/js/jquery.prettyPhoto.js',
        //'design_elements/js/main.js',
        'design_elements/js/jquery.marquee.min.js',
        'design_elements/js/jquery.totemticker.js',
        // Doctor theme js
        'design_elements/js/drthemejs/style.switcher.localstorage.js',
        'design_elements/js/drthemejs/modernizr.min.js',
        //'design_elements/js/drthemejs/jquery.min.js',
        'design_elements/js/drthemejs/jquery.appear.min.js',
        'design_elements/js/drthemejs/jquery.easing.min.js',
        'design_elements/js/drthemejs/jquery-cookie.min.js',
        'design_elements/js/drthemejs/style.switcher.js',
        'design_elements/js/bootstrap.min.js',
        'design_elements/js/drthemejs/common.min.js',
        'design_elements/js/drthemejs/jquery.validation.min.js',
        'design_elements/js/drthemejs/jquery.easy-pie-chart.min.js',
        'design_elements/js/drthemejs/jquery.gmap.min.js',
        'design_elements/js/drthemejs/jquery.lazyload.min.js',
        'design_elements/js/drthemejs/jquery.isotope.min.js',
        'design_elements/js/drthemejs/owl.carousel.min.js',
        'design_elements/js/drthemejs/jquery.magnific-popup.min.js',
        'design_elements/js/drthemejs/vide.min.js',
        'design_elements/js/drthemejs/theme.js',
        'design_elements/js/drthemejs/jquery.themepunch.tools.min.js',
        'design_elements/js/drthemejs/jquery.themepunch.revolution.min.js',
        'design_elements/js/drthemejs/view.contact.js',
        'design_elements/js/drthemejs/demo-medical.js',
        'design_elements/js/drthemejs/custom.js',
        'design_elements/js/drthemejs/theme.init.js',
        'design_elements/js/drthemejs/analytics.js',
    ];
    public $depends = [
        'app\assets\JqueryAssets',
        'yii\web\YiiAsset',
    ];
}
