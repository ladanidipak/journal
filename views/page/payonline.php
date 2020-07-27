<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\vendors\Common;

/* @var $this yii\web\View */
?>

    <div class="features_items prit_items"><!--features_items-->
        <h2 class="title text-center">Submit Payment Receipt</h2>
        <div class="row">
            <div class="col-lg-6">
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
                        <div class="row payment-block">
                            <div class="col-sm-12">
                                <p><b><u>Please Select Payment Charges :</u></b></p>
                                <div class="checkbox">
                                    <label><input type="checkbox" value="manuscript" disabled="disabled" checked="checked"> <?= $items['manuscript']['description']?></label>
                                </div>
                                    <?= $form->field($instamojo, 'item_list')->checkboxList($instamojo::getSelectionItem())->label('Additional Purchase') ?>


                            </div>

                            <div class="col-sm-12">

                                <?= $form->field($instamojo,'additional')->checkbox()->label('Custom Purchase');?>
                                <?= $form->field($instamojo,'additional_amount')->textInput(['disabled'=>'disabled'])->label('Custom Amount');?>
                                <?= $form->field($instamojo,'additional_desc')->textInput(['disabled'=>'disabled'])->label('Custom Description');?>
                            </div>
                            <div class="col-sm-12">
                                <b>Pay : </b> Rs. <span id="update-amount"><b><?= $mainPrice?></b></span>
                            </div>
                        </div>

                       <!-- <div class="row">
                            <?= $form->field($model, 'verifyCode', ['options' => ['class' => 'col-sm-4']])->widget(yii\captcha\Captcha::className(), ['captchaAction' => 'page/captcha']) ?>
                        </div>-->

                        <div class="row">
                            <div class="hr-line-dashed"></div>
                            <div class="form-group col-sm-12">
                                <?= Html::submitButton('<b>Proceed to Pay</b>', ['class' => 'btn btn-primary pull-left']) ?>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
			<div class="col-lg-6">
				<div class="brands_products padding-bottom-20">
					<div class="blueboxshadow brands-name padding-10">
						<table class="table table-striped table-bordered callforpaper text-center table-vcenter" id="priceTable">
							<tr>
								<td><?= $items['manuscript']['description'] ?></td>
								<td><?= $items['manuscript']['price'] ?></td>
							</tr><?php 
							if($processingFee != "" || $processingFee > 0){
								?><tr>
									<td>Processing Charge</td>
									<td><?= round($processingFee) ?></td>
								</tr><?php
							}
							if($processingFee != "" || $processingFee > 0){
								?><tr>
									<td>Total</td>
									<td><?= round($mainPrice) ?></td>
								</tr><?php
							}
							?>							
						</table>
					</div>
				</div>
			</div>
        </div>
    </div><!--features_items-->
<?php
$json = \yii\helpers\Json::encode($instamojo::getPaymentItems());
$this->registerJs("$(document).ready(function(){
        var itemsList = {$json};
		var percentageCharges = {$instamojo::$percentageCharges};
		var staticCharge = {$instamojo::$staticCharges};
         var totalAmount = parseFloat(itemsList.manuscript.price);
         function getTotal(){
            var total = totalAmount;
            $('#instamojopayment-item_list input:checkbox').filter(':checked').each(function(){
                total += parseFloat(itemsList[$(this).val()].price);
            });
            if($('#instamojopayment-additional').is(':checked')){
                total += parseFloat($('#instamojopayment-additional_amount').val());
            }
            return total;
         }
         $('#instamojopayment-additional').change(function(){
            if($(this).is(':checked')){
                $('#instamojopayment-additional_amount,#instamojopayment-additional_desc').removeAttr('disabled');
            }else{
                $('#instamojopayment-additional_amount,#instamojopayment-additional_desc').attr('disabled','disabled');
            }
        });
		
		var formatTR = '<tr><td>#label</td><td>#Value</td></tr>';
		
		function getPriceTable(){
			var mandatoryContent = itemsList.manuscript.description;
			var innerContent , priceValue;
			
			priceValue = totalAmount;
			var tempContent = formatTR.replace('#label', mandatoryContent);
			tempContent = tempContent.replace('#Value', totalAmount);
			
			innerContent = innerContent + tempContent;
			
			$('#instamojopayment-item_list input:checkbox').filter(':checked').each(function(){
                priceValue += parseFloat(itemsList[$(this).val()].price);
				
				var tempContent = formatTR.replace('#label', itemsList[$(this).val()].description);
				tempContent = tempContent.replace('#Value', itemsList[$(this).val()].price);
				
				innerContent = innerContent + tempContent;
            });
            if($('#instamojopayment-additional').is(':checked')){               
				
				if($('#instamojopayment-additional_amount').val() != '' && !isNaN($('#instamojopayment-additional_amount').val())){
					
					addValue = parseFloat($('#instamojopayment-additional_amount').val()).toFixed(2);
					priceValue += parseFloat(addValue);
					
					var tempContent = formatTR.replace('#label', $('#instamojopayment-additional_desc').val());
					tempContent = tempContent.replace('#Value', addValue);
					
					innerContent = innerContent + tempContent;
				}
            }
			
			processingFee = 0;
			if(percentageCharges != '' && percentageCharges > 0){
				processingFee = (parseFloat(priceValue) * parseFloat(percentageCharges)) / 100;			
			}
			if(staticCharge != '' && staticCharge > 0){
				processingFee = parseFloat(processingFee) + parseFloat(staticCharge);
			}
			
			processingFee = processingFee.toFixed(2);
			
			
			var tempContent = formatTR.replace('#label', 'Processing Charge');
			tempContent = tempContent.replace('#Value', processingFee);
			
			innerContent = innerContent + tempContent;
			
			var tempContent = formatTR.replace('#label', 'Total');
			tempContent = tempContent.replace('#Value', (parseFloat(priceValue) + parseFloat(processingFee)).toFixed(2));
			$('#update-amount').html((parseFloat(priceValue) + parseFloat(processingFee)).toFixed(2));
			
			innerContent = innerContent + tempContent;
			
			$('#priceTable').html(innerContent);
		}
		
        $('#instamojopayment-item_list input:checkbox').change(function(){
            $('#update-amount').html('<b>'+getTotal()+'</b>');
			getPriceTable();
        });
        $('#instamojopayment-additional_amount').keyup(function(){
            $('#update-amount').html('<b>'+getTotal()+'</b>');
			getPriceTable();
        });
		$('#instamojopayment-additional_desc').keyup(function(){
			getPriceTable();
        });
    });", \yii\web\View::POS_END, 'otherdesig');
?>