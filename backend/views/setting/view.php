<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $model backend\models\Setting */

$pageTitle = Common::getTitle("{$this->context->id}/{$this->context->action->id}");
?>
<div class="setting-view">

    <h1><?= Html::encode($pageTitle) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'value',
        ],
    ]) ?>

</div>
