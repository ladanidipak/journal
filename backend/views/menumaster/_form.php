<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\vendors\Common;
use app\models\MenuMaster;
?>
<?php $form = ActiveForm::begin(['id' => 'menu-master-form', 'enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => 'col-sm-4'], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>
<div class="row">
    <?php echo $form->field($model, 'menu_title'); ?> 
    <?php echo $form->field($model, 'parent_id')->dropDownList($model->getParentMenusList(), ['class'=>'chosen-select-width','prompt' => common::getDropDownText($model->getAttributeLabel("parent_id"))]) ?>
    <?php echo $form->field($model, 'page_url'); ?>
</div>
<div class="row">
    <?php echo $form->field($model, 'module_id')->dropDownList(common::getModuleList(), ['class'=>'chosen-select-width','prompt' => common::getDropDownText($model->getAttributeLabel("module_id"))]) ?>
    <?php echo $form->field($model, 'menu_icon'); ?>
    <?php echo $form->field($model, 'show_in_menu')->checkbox(); ?>
</div>
<div class="row">                    
    <div class="hr-line-dashed"></div>
    <div class="form-group pull-right">                        
        <?php echo Html::submitButton(common::translateText("SUBMIT_BTN_TEXT"), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(common::translateText("CANCEL_BTN_TEXT"), ["menumaster/index"], ["class" => "btn btn-white"]); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>