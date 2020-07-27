<script src="<?php echo Yii::$app->params['designElementUrl']; ?>js/plugins/nestable/jquery.nestable.js"></script>
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use backend\components\ActiveForm;
use backend\vendors\Common;
use backend\models\MenuMaster;
use backend\models\RoleMaster;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Menu List</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="dd" id="nestable">
                            <?= RoleMaster::nestableMenuTree($menusArr) ?>
                        </div>
                    </div>
                </div>
                <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'enableClientValidation' => true,'layout'=>'horizontal','fieldConfig' => ['horizontalCssClasses' => ['wrapper' => 'col-sm-8']]]); ?>
                <div class="row" style="display: none">
                    <div class="col-md-6">
                        <textarea id="nestable-output" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="hr-line-dashed"></div>
                    <div class="form-group col-sm-12">
                        <?= Html::submitButton(common::translateText("SAVE_LABEL"), ['class' => 'btn btn-primary pull-left']) ?>
                        <a class="btn btn-white pull-left" onclick="location.href = '<?= Url::to(['index']) ?>'"><?= common::translateText("CANCEL_BTN_TEXT") ?></a>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>  
</div>


<script>
    $(document).ready(function () {

        var updateOutput = function (e) {
            var list = e.length ? e : $(e.target),
                    output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };
        // activate Nestable for list 1
        $('#nestable').nestable({
            group: 1,
            maxDepth: 2,
        }).on('change', updateOutput);


        // output initial serialised data
        updateOutput($('#nestable').data('output', $('#nestable-output')));

    });
</script>  