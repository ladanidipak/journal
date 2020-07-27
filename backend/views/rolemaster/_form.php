<?php

use yii\widgets\ActiveForm;
use app\models\MenuMaster;
use yii\helpers\html;
use backend\vendors\Common;
?>

<?php
$form = ActiveForm::begin(['id' => 'role-master-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ]);
?>
<?= $form->field($model, 'role_title')->textInput(['maxlength' => 128]) ?>
<div class="row">                    
    <div class="hr-line-dashed"></div>
    <div class="form-group pull-right">        
        <?php echo Html::submitButton(common::translateText("SUBMIT_BTN_TEXT"), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(common::translateText("CANCEL_BTN_TEXT"), ["rolemaster/index"], ["class" => "btn btn-white"]); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
