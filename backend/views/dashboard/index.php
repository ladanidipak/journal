<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DepartmentMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="wrapper wrapper-content animated fadeInRight">    
    <div class="alert alert-info">
        Welcome to <?=  Yii::$app->params['productName']?>
    </div>

</div>


<!-- Mainly scripts -->
<script src="<?php echo Yii::$app->params['designElementUrl']; ?>js/jquery-2.1.1.js"></script>

<!-- Flot -->
<script src="<?php echo Yii::$app->params['designElementUrl']; ?>js/plugins/flot/jquery.flot.js"></script>
<script src="<?php echo Yii::$app->params['designElementUrl']; ?>js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="<?php echo Yii::$app->params['designElementUrl']; ?>js/plugins/flot/jquery.flot.resize.js"></script>
<script src="<?php echo Yii::$app->params['designElementUrl']; ?>js/plugins/flot/jquery.flot.pie.js"></script>
<script src="<?php echo Yii::$app->params['designElementUrl']; ?>js/plugins/flot/jquery.flot.time.js"></script>

<!-- Flot demo data -->
<script src="<?php echo Yii::$app->params['designElementUrl']; ?>js/demo/flot-demo.js"></script>
