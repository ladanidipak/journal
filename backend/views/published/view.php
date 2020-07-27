<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $model backend\models\Published */

$pageTitle = Common::getTitle("{$this->context->id}/{$this->context->action->id}");
if($model->article->conf_id == 0){
                        $fileDir = "article";
                    }else{
                        $fileDir = "conference";
                    }
?>
<div class="published-view">

    <h1><?= Html::encode($pageTitle) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'article_id',
            'title',
            'authors',
            'country',
            'abstract:ntext',
            'keywords',
            'start_page',
            'end_page',
            'pub_date',
            ['attribute'=>'pdf','format'=>'raw','value'=>Html::a($model->pdf,DOCURL."uploads/$fileDir/".$model->pdf,['target'=>'_blank'])],
            ['attribute'=>'status','value'=>($model->status)?(Common::translateText('ENABLE_BTN_TEXT')) : (Common::translateText('DISABLE_BTN_TEXT')) ],
        ],
    ]) ?>

</div>
