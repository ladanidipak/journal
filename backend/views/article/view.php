<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $model backend\models\Article */

$pageTitle = Common::getTitle("{$this->context->id}/{$this->context->action->id}");
?>
<div class="article-view">

    <h1><?= Html::encode($pageTitle) ?></h1>

<?php
if($model->conf_id != 0){
    $fileDir = "conference";
}else{
    $fileDir = "article";
}
?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'paper_id',
            'article_title',
            'research_area',
            ['attribute'=>'a_type_id','value'=>($model->type->name)],
            ['attribute'=>'branch_id','value'=>($model->branch->name)],
            'branch_name',
            'keyword',
            'abstract:ntext',
            'author_name',
            'a_org',
            'a_email:email',
            'a_phone',
            'addr_1',
            'addr_2',
            'city',
            'zip',
            'state',
            'country',
            ['attribute'=>'article_file','format'=>'raw','value'=>Html::a($model->article_file,DOCURL."uploads/$fileDir/".$model->article_file,['target'=>'_blank'])],
            ['attribute'=>'status','value'=>($model->status)?(Common::translateText('ENABLE_BTN_TEXT')) : (Common::translateText('DISABLE_BTN_TEXT')) ],
        ],
    ]) ?>

</div>
