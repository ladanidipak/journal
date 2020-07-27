<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\vendors\Common;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

?>
<h2>Hello <?= $formatter->name?>,</h2>
<p><?= date('d/m/Y')?></p>
<p>
    We have attached an Article to Format. Please format it and upload on below url.
</p>
<p>
    <?= Html::a('Click To Upload formatted Article', Yii::$app->urlManagerFrontend->createAbsoluteUrl(['open/formatted','id'=>  Common::passencrypt($fid)])) ?>
</p>

