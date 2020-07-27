<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$pageTitle = Common::getTitle("{$this->context->id}/{$this->context->action->id}");
?>
<div class="users-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'first_name',
            'last_name',
            'email:email',   
            'phone',
            ['attribute'=>'user_group','value'=>$model->roles->role_title],
            'address',
            ['attribute'=>'city','value'=>$model->city->location_name],
            ['attribute'=>'city','value'=>$model->state->location_name],
            ['attribute'=>'country_id','value'=>$model->country->location_name],
        ],
    ]) ?>

</div>
