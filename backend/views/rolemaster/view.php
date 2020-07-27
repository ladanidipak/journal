<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\vendors\Common;
/* @var $this yii\web\View */
/* @var $model app\models\RoleMaster */

$pageTitle = Common::getTitle("{$this->context->id}/{$this->context->action->id}");
?>
<div class="role-master-view">

    <h1><?= Html::encode($pageTitle) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'role_title',
            'is_deleted',
            'created_dt',
            'created_by',
            'updated_dt',
            'updated_by',
        ],
    ]) ?>

</div>
