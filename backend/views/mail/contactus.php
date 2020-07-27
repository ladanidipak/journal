<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\vendors\Common;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

?>
<h2>Hello Admin,</h2>
<p><?= date('d/m/Y')?></p>
<p>
    Received new contact request with bellow detail.
</p>
<br>
<p>
    <strong><?= $model->getAttributeLabel('name')?> : </strong><?= $model->name?><br>
    <strong><?= $model->getAttributeLabel('email')?> : </strong><?= $model->email?><br>
    <strong><?= $model->getAttributeLabel('subject')?> : </strong><?= $model->subject?><br>
    <strong><?= $model->getAttributeLabel('phone')?> : </strong><?= $model->phone?><br>
    <strong><?= $model->getAttributeLabel('message')?> : </strong><?= $model->message?><br>
</p>

