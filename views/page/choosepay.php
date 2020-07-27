<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\vendors\Common;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
?>

    <div class="features_items prit_items" id="replace-data"><!--features_items-->
        <h2 class="title text-center">Choose Payment method</h2>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content article-form" style="display: block;">
                        <div class="row">
                            <div class="col-sm-12">
                                <p>Paper ID : <?=$model->paper_id?></p>
                                <p>Email : <?=$model->a_email?></p>
                                <p><?= Html::a("(Click to Start Again)",['page/getpaydetail'])?></p>
                            </div>
                        </div>
                        <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="nav padding-10" id="choose_pay">
                                        <li class="col-md-4">
                                            <a href="javascript:;" data-id="0" role="alert" class="alert alert-warning">
                                                Upload payment proof
                                            </a>
                                            <span>(if paid by deposit then receipt photo,if by NetBanking, Paytm or NEFT then screenshot of transaction)</span>
                                        </li>
                                        <li class="col-md-4">
                                            <a href="javascript:;" data-id="1" role="alert" class="alert alert-success">
                                                Online
                                            </a>
                                            <span>(if payment is not done and you want to make online payment right now)</span>
                                        </li>
                                        <li class="col-md-6 text-centered" id="pay-loader" style="display: none">
                                            <img src="<?= BASEURL?>/images/loader.gif" alt="Please Wait ... " />
                                        </li>
                                    </ul>
                                </div>

                            </div>

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
        $('#choose_pay a').click(function(){
            if($(this).data('id') == '1'){
                var url = '". Url::to(['page/payonline']) ."';
            }else{
                var url = '". Url::to(['page/uploadpay']) ."';   
            }
            $('#choose_pay li').hide();
            $('#pay-loader').show();
            $.get(url,{},function(data){
                $('#replace-data').replaceWith(data);
            });
        });
    });", \yii\web\View::POS_END, 'otherdesig');
?>