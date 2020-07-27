<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BackendJqueryAssets extends AssetBundle
{
    public $basePath = '@webroot/backend';
    public $baseUrl = '@web/backend';
    public $css = [

    ];
    public $js = [
        'design_elements/js/jquery-2.1.1.js',
    ];
    public $jsOptions = ['position' => View::POS_HEAD];
    public $depends = [
    ];
}
