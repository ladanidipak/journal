<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $model backend\models\VolIss */

$pageTitle = Common::getTitle("{$this->context->id}/{$this->context->action->id}");
?>
<div class="vol-iss-view">

    <h1><?= Html::encode($pageTitle) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'volume',
            'issue',
            'detail',
            'last_date',
            'publish_date',
        ],
    ]) ?>

</div>
