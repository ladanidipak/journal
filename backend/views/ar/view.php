<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $model backend\models\ArticleReview */

$pageTitle = Common::getTitle("{$this->context->id}/{$this->context->action->id}");
?>
<div class="article-review-view">

    <h1><?= Html::encode($pageTitle) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'article.paper_id:text:Article',
            'reviewer.full_name:text:Reviewer',
            'article_review:ntext',
            'reviewed_date',
        ],
    ]) ?>

</div>
