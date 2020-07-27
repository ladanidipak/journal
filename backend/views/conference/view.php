<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $model backend\models\Conference */

$pageTitle = Common::getTitle("{$this->context->id}/{$this->context->action->id}");
?>
<div class="conference-view">

    <h1><?= Html::encode($pageTitle) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'conf_cor_name',
            'email:email',
            'org_name',
            'phone',
            'org_website',
            'dept_name',
            'aff_by',
            ['attribute'=>'conf_type','value'=>$model::getConfTypeArray($model->conf_type)],
            'title',
            'description:ntext',
            'short_name',
            'conf_date',
            'specialization',
            'venue',
            'conf_website',
            'brochure',
            'college_logo',
        ],
    ]) ?>

</div>
