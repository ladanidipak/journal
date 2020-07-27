<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $model backend\models\EditorialBoard */

$pageTitle = Common::getTitle("{$this->context->id}/{$this->context->action->id}");
?>
<div class="editorial-board-view">

    <h1><?= Html::encode($pageTitle) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'full_name',
            'qualification',
            'designation',
            'email:email',
            'phone',
            'institute_name',
            'country',
            'state',
            ['attribute'=>'cv','format'=>'raw','value'=>Html::a($model->cv,DOCURL."uploads/cv/".$model->cv,['target'=>'_blank'])],
            ['attribute'=>'status','value'=>($model->status)?(Common::translateText('ENABLE_BTN_TEXT')) : (Common::translateText('DISABLE_BTN_TEXT')) ],
        ],
    ]) ?>

</div>
