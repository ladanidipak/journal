<?php

use backend\assets\AppAsset;
use yii\helpers\Html;
use app\components\LeftMenuWidget;
use app\components\ChatWidget;
use app\components\RightMenuWidget;
use app\components\TopMenuWidget;
use app\components\HeaderWidget;
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
        <?php $this->head() ?>
    </head>
    <body class="gray-bg">
    <?php $this->beginBody() ?>
        <div class="middle-box text-center loginscreen animated fadeInDown">            
            <?php echo $content; ?>
        </div>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>