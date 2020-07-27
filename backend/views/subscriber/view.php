<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $model backend\models\Subscriber */

$pageTitle = Common::getTitle("{$this->context->id}/{$this->context->action->id}");
?>
<div class="subscriber-view">

    <h1><?= Html::encode($pageTitle) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'email:email',
            ['attribute'=>'status','value'=>($model->status)?(Common::translateText('ENABLE_BTN_TEXT')) : (Common::translateText('DISABLE_BTN_TEXT')) ],
        ],
    ]) ?>

</div>
