<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

    <div class="features_items prit_items"><!--features_items-->
        <h2 class="title text-center"><?= $content->page_title;?></h2>
        
        <?= $content->content;?>
    </div><!--features_items-->
