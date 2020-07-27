<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\vendors\Common;

/* @var $this yii\web\View */
?>

<div class="features_items prit_items"><!--features_items-->
    <h2 class="title text-center">Submit Copyright Receipt</h2>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content article-form" style="display: block;">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => 'col-sm-8'], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>

                    <div class="row">
                        <div class="col-sm-12">
                            <p>Paper ID : <?=$_SESSION['get_pay_detail']['paper_id']?></p>
                            <p>Email : <?=$_SESSION['get_pay_detail']['a_email']?></p>
                            <p><?= Html::a("(Click to Start Again)",['page/getpaydetail'])?></p>
                        </div>
                    </div>
                    <br>

                    <div class="row"><?= $form->field($model, 'copyright_file')->fileInput() ?></div>
                    <div class="row">
                        &nbsp;
                    </div>

                    <div class="row">
                        <div class="hr-line-dashed"></div>
                        <div class="form-group col-sm-12">
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary pull-left']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div><!--features_items-->
<?php
$this->registerJs("$(document).ready(function(){
        $('input[name*=\"paid_online\"]').change(function(){
            $('.payoff').hide();
            $('.paypayu').hide();
           if($('input[name*=\"paid_online\"]:checked').val() == '0') {
               $('.payoff').show();
           }else{
               $('.paypayu').show();
           }
        });
    });", \yii\web\View::POS_END, 'otherdesig');
?>