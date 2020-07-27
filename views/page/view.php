<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $model app\models\Cms */

$pageTitle = Common::getTitle("{$this->context->id}/{$this->context->action->id}");
?>
<div class="cms-view">

    <h1><?= Html::encode($pageTitle) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'page_title',
            'page_name',
            'slug',
            'meta_key',
            'meta_description',
            ['attribute'=>'status','value'=>($model->status)?(Common::translateText('ENABLE_BTN_TEXT')) : (Common::translateText('DISABLE_BTN_TEXT')) ],
        ],
    ]) ?>

</div>
