<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $model backend\models\EmailMaster */

$pageTitle = Common::getTitle("{$this->context->id}/{$this->context->action->id}");
?>
<div class="email-master-view">

    <h1><?= Html::encode($pageTitle) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'from_name',
            'from_email:email',
            'reply_to',
            'subject',
            'content:ntext',
        ],
    ]) ?>

</div>
