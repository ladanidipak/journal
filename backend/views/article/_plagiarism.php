<?php
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?= backend\vendors\Common::translateText('CLOSE_BTN_TEXT') ?></span></button>
    <h4 class="modal-title"><?=$title?></h4>
</div>
<?php  if($type == "form"): ?>
    <?php $form = ActiveForm::begin(['id' => 'plagiarism-form', 'enableClientValidation'=>true,'validateOnSubmit'=>true]);?>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($article, 'plagiarism')->textarea(['placeholder' => "Write plagiarism note here", 'rows' => 5])->label(false); ?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <?= Html::submitButton('Reject Article', ['class' => 'btn btn-primary', 'name' => 'submit-button']); ?>
        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
    </div>
    <?php ActiveForm::end(); ?>
<?php else: ?>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <pre><?=$article->plagiarism?></pre>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
    </div>
<?php endif; ?>

