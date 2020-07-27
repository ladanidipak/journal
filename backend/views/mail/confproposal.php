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
    Received new Conference proposal request with bellow detail.
</p>
<br>
<p>
    <strong><?= $model->getAttributeLabel('conf_cor_name')?> : </strong><?= $model->conf_cor_name?><br>
    <strong><?= $model->getAttributeLabel('org_name')?> : </strong><?= $model->org_name?><br>
    <strong><?= $model->getAttributeLabel('org_website')?> : </strong><?= $model->org_website?><br>
    <strong><?= $model->getAttributeLabel('aff_by')?> : </strong><?= $model->aff_by?><br>
    <strong><?= $model->getAttributeLabel('title')?> : </strong><?= $model->title?><br>
    <strong><?= $model->getAttributeLabel('short_name')?> : </strong><?= $model->short_name?><br>
    <strong><?= $model->getAttributeLabel('conf_date')?> : </strong><?= $model->conf_date?><br>
    <strong><?= $model->getAttributeLabel('specialization')?> : </strong><?= $model->specialization?><br>
    <strong><?= $model->getAttributeLabel('email')?> : </strong><?= $model->email?><br>
    <strong><?= $model->getAttributeLabel('phone')?> : </strong><?= $model->phone?><br>
    <strong><?= $model->getAttributeLabel('dept_name')?> : </strong><?= $model->dept_name?><br>
    <strong><?= $model->getAttributeLabel('description')?> : </strong><?= $model->description?><br>
    <strong><?= $model->getAttributeLabel('conf_website')?> : </strong><?= $model->conf_website?><br>
    <strong><?= $model->getAttributeLabel('venue')?> : </strong><?= $model->venue?><br>
</p>

