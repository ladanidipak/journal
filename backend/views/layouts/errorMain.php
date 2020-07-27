<?php

use backend\assets\AppAsset;
use yii\helpers\Html;
use app\components\LeftMenuWidget;
use app\components\ChatWidget;
use app\components\RightMenuWidget;
use app\components\TopMenuWidget;
use app\components\FooterWidget;

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
        <?php echo Html::csrfMetaTags() ?>
        <title><?php echo Html::encode($this->title) ?></title>        
        <link href="<?php echo Yii::$app->params['designElementUrl']; ?>css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo Yii::$app->params['designElementUrl']; ?>font-awesome/css/font-awesome.css" rel="stylesheet">
        <!-- Toastr style -->
        <link href="<?php echo Yii::$app->params['designElementUrl']; ?>css/plugins/toastr/toastr.min.css" rel="stylesheet">
        <!-- Gritter -->
        <link href="<?php echo Yii::$app->params['designElementUrl']; ?>js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
        <link href="<?php echo Yii::$app->params['designElementUrl']; ?>css/animate.css" rel="stylesheet">
        <link href="<?php echo Yii::$app->params['designElementUrl']; ?>css/style.css" rel="stylesheet">
    </head>
    <body class="gray-bg">
        <div class="middle-box text-center animated fadeInDown">
        <?php echo $content; ?>    
        </div>
        <!-- Mainly scripts -->
        <script src="<?php echo Yii::$app->params['designElementUrl']; ?>js/jquery-2.1.1.js"></script>
        <script src="<?php echo Yii::$app->params['designElementUrl']; ?>js/bootstrap.min.js"></script>
    </body>
</html>
<?php $this->endPage() ?>