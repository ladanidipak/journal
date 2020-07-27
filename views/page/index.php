<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\vendors\Common;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//echo "<pre>";print_r($content->content);exit;
?>

    <div class="row">
        <div class="features_items">
            <p class="lead font-weight-normal"><?= $content->page_title?></p>
            <?php echo $content->content; ?>
        </div>
    </div>
    
