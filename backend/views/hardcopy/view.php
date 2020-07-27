<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $model backend\models\Hardcopy */

$pageTitle = Common::getTitle("{$this->context->id}/{$this->context->action->id}");
?>
<div class="hardcopy-view">

    <h1><?= Html::encode($pageTitle) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'article_id',
            'dispatched_date',
            'dispatched_by',
            'courier_name',
            'tracking_no',
            'tracking_url:url',
            'detail_sent',
        ],
    ]) ?>

</div>
