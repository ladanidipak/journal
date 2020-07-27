<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\vendors\Common;
use backend\models\Conference;

/* @var $this yii\web\View */
/* @var $model backend\models\Article */
/* @var $form yii\widgets\ActiveForm */

$pageTitle = Common::getTitle("{$this->context->id}/{$this->context->action->id}");
$isConf = $this->context->action->id == 'createproceeding' || $this->context->action->id == 'updateproceeding';
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>
                    <?= $pageTitle ?>
                </h5>
            </div>
            <div class="ibox-content article-form" style="display: block;">
                <?php echo $this->render("@app/views/layouts/_message"); ?>
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => 'col-sm-8'], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>

                <?php if($isConf): ?>
                <div class="row">
                    <?php
                    if(IS_GRD_ADMIN){
                        echo $form->field($model, 'conf_id')->dropDownList(Conference::getList(),Common::getDropDownOptions($model,'conf_id'));
                    } else {
                        echo "<div class='col-sm-8'>" . $_SESSION['active_conf']['short_name'] . "</div>";
                    }
                    ?>
                </div>
                <?php endif; ?>
                <div class="row">
                    <?= $form->field($model, 'article_title')->textInput(['maxlength' => 255]) ?>
                </div>

                <div class="row">
                    <?= $form->field($model, 'research_area')->textInput(['maxlength' => 255]) ?>
                </div>


                <div class="row">

                    <?= $form->field($model, 'a_type_id')->dropDownList(backend\models\ArticleType::getTypes(), Common::getDropDownOptions($model, 'a_type_id')) ?>
                </div>
                <div class="row">
                    <?= $form->field($model, 'branch_id')->dropDownList(backend\models\Branch::getBranches(), Common::getDropDownOptions($model, 'branch_id')) ?>
                </div>
                <div class="row">
                    <?= $form->field($model, 'branch_name')->textInput(['maxlength' => 255]) ?>

                </div>

                <?php if(!$isConf): ?>
                <div class="row">

                    <?= $form->field($model, 'keyword')->textInput(['maxlength' => 255]) ?>
                </div>
                <div class="row">
                    <?= $form->field($model, 'abstract')->textarea(['rows' => 6]) ?>
                </div>
                <div class="row">
                    <?= $form->field($model, 'reference')->textarea(['rows' => 6]) ?>
                </div>
                <?php endif; ?>

                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="col-sm-12">Author Details</div>
                </div>
                <div class="row">&nbsp;</div>

                <div class="row">
                    <?= $form->field($model, 'author_name')->textInput(['maxlength' => 255]) ?>

                </div>

                <div class="row">

                    <?= $form->field($model, 'a_org')->textInput(['maxlength' => 100]) ?>
                </div>
                <div class="row">
                    <?= $form->field($model, 'a_email')->textInput(['maxlength' => 100]) ?>
                </div>
                <div class="row">
                    <?= $form->field($model, 'a_phone')->textInput(['maxlength' => 10]) ?>

                </div>


                <div class="row">
                    <div class="col-sm-12">Co-Author Details</div>
                </div>
                <div class="row">&nbsp;</div>
                
                <?php if(!$model->isNewRecord){foreach($coa as $key => $vcoa): ?>
                    <div class="row">
                        <div class="col-sm-1"><label class="control-label">1</label></div>
                        <?= $form->field($coa[$key], "[$key]name", ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Name'])->label(false) ?>
                        <?= $form->field($coa[$key], "[$key]org", ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Institute/Organization'])->label(false) ?>
                        <?= $form->field($coa[$key], "[$key]email", ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Email'])->label(false) ?>
                    </div>
                <?php endforeach;} else { ?>
                <div class="row">
                    <div class="col-sm-1"><label class="control-label">1</label></div>
                    <?= $form->field($coa['coa1'], '[coa1]name', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Name'])->label(false) ?>
                    <?= $form->field($coa['coa1'], '[coa1]org', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Institute/Organization'])->label(false) ?>
                    <?= $form->field($coa['coa1'], '[coa1]email', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Email'])->label(false) ?>
                </div>
                <div class="row">
                    <div class="col-sm-1"><label class="control-label">2</label></div>
                    <?= $form->field($coa['coa2'], '[coa2]name', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Name'])->label(false) ?>
                    <?= $form->field($coa['coa2'], '[coa2]org', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Institute/Organization'])->label(false) ?>
                    <?= $form->field($coa['coa2'], '[coa2]email', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Email'])->label(false) ?>
                </div>
                <div class="row">
                    <div class="col-sm-1"><label class="control-label">3</label></div>
                    <?= $form->field($coa['coa3'], '[coa3]name', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Name'])->label(false) ?>
                    <?= $form->field($coa['coa3'], '[coa3]org', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Institute/Organization'])->label(false) ?>
                    <?= $form->field($coa['coa3'], '[coa3]email', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Email'])->label(false) ?>
                </div>
                <div class="row">
                    <div class="col-sm-1"><label class="control-label">4</label></div>
                    <?= $form->field($coa['coa4'], '[coa4]name', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Name'])->label(false) ?>
                    <?= $form->field($coa['coa4'], '[coa4]org', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Institute/Organization'])->label(false) ?>
                    <?= $form->field($coa['coa4'], '[coa4]email', ['options' => ['class' => 'col-sm-3']])->textInput(['maxlength' => 100, 'placeholder' => 'Email'])->label(false) ?>
                </div>
                <?php } ?>

                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="col-sm-12">Postal Address</div>
                </div>
                <div class="row">&nbsp;</div>

                <div class="row">

                    <?= $form->field($model, 'addr_1')->textInput(['maxlength' => 255]) ?>
                </div>
                <div class="row">
                    <?= $form->field($model, 'addr_2')->textInput(['maxlength' => 255]) ?>
                </div>
                <div class="row">
                    <?= $form->field($model, 'city')->textInput(['maxlength' => 100]) ?>

                </div>

                <div class="row">

                    <?= $form->field($model, 'zip')->textInput(['maxlength' => 6]) ?>
                </div>
                <div class="row">
                    <?= $form->field($model, 'state')->textInput(['maxlength' => 100]) ?>
                </div>
                <div class="row">
                    <?= $form->field($model, 'country')->dropDownList(backend\models\Country::getCountries(), Common::getDropDownOptions($model, 'country')) ?>

                </div>

                <div class="row">&nbsp;</div>
                <div class="row">
                    <?= $form->field($model, 'article_file')->fileInput() ?>
                </div>
                <div class="row">
                    <div class="col-sm-8 field-article-article_file">
                        <?= Html::a($model->article_file,DOCURL."uploads/article/".$model->article_file,['target'=>'_blank'])?>
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row">
                    <?= $form->field($model, 'source')->dropDownList($model->getSourceArray($model->source),  Common::getDropDownOptions($model, 'source')) ?>
                </div>
                <div class="row">
                    <?= $form->field($model, 'source_specify')->textInput(['maxlength' => 100])->label('Specify',['id'=>'source-label']) ?>
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
<?php
$this->registerJs("$(document).ready(function(){
        $('#article-branch_id').change(function(){
           if($('#article-branch_id option:selected').text() == 'Other') {
               $('#article-branch_name').parent().show();
           }else{
               $('#article-branch_name').parent().hide();
           }
        });
        $('#article-branch_id').trigger('change');

        $('#article-source').change(function(){
            var article_source = $('#article-source').val();
           if($.inArray(article_source,['Reference by a friend', 'References by professor', 'Other']) != -1) {
               if(article_source == 'Reference by a friend'){
                    $('#source-label').text('Friend\'s Name ');
               } else if(article_source == 'References by professor') {
                    $('#source-label').text('Professor\'s Name ');
               } else {
                    $('#source-label').text('Specify');
               }
               $('#article-source_specify').parent().show();
           }else{
               $('#article-source_specify').parent().hide();
               $('#article-source_specify').val('');
           }
        });
        $('#article-source').trigger('change');
    });", \yii\web\View::POS_END, 'otherbranch');
?>