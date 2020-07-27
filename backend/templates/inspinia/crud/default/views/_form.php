<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */

$pageTitle = Common::getTitle("{$this->context->id}/{$this->context->action->id}");
?>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>
                        <?= "<?= " ?>$pageTitle?>
                    </h5>
                </div>
                <div class="ibox-content <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form" style="display: block;">

                        <?= "<?php " ?>$form = ActiveForm::begin(['enableAjaxValidation'=>false,'enableClientValidation'=>true,'fieldConfig'=>['options'=>['class'=>'col-sm-4'],'checkboxTemplate'=>"<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>

                    <?php 
                    $rowCount = 0;
                    $rowCounted = 1;
                    foreach ($generator->getColumnNames() as $attribute) {
                        if (in_array($attribute, $safeAttributes) && !in_array($attribute, array('created_by','created_date','created_dt','updated_by','updated_date','updated_dt','is_deleted'))) {
                            if($rowCount % 3 == 0 && $rowCount != $rowCounted)  {
                                echo '<div class="row">'."\n\n"; $rowCounted = $rowCount + 2;}
                                echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
                                if($rowCount == $rowCounted) echo '</div>'."\n\n";
                                $rowCount++;
                        }
                    } 
                    if(($rowCount-1) != $rowCounted) echo '</div>'."\n\n";
                    ?>
                        
                        <div class="row">
                            <div class="hr-line-dashed"></div>
                            <div class="form-group col-sm-12">
                                    <a class="btn btn-white pull-right" onclick="location.href = '<?= "<?="?> Url::to(['index']) ?>'"><?= "<?="?>common::translateText("CANCEL_BTN_TEXT")?></a>
                                    <?= "<?="?> Html::submitButton($model->isNewRecord ? (common::translateText("CREATE_BTN_TEXT")) : (common::translateText("UPDATE_BTN_TEXT")), ['class' => $model->isNewRecord ? 'btn btn-primary pull-right' : 'btn btn-primary pull-right']) ?>
                            </div>
                        </div>

                        <?= "<?php " ?>ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
