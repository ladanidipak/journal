<?php

use backend\models\ContactList;
use backend\vendors\Common;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ContactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="row contact-index">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?= Html::encode(Common::getTitle("{$this->context->id}/{$this->context->action->id}")) ?></h5>

                    <div class="ibox-tools">
                        <?php
                        if (common::checkActionAccess("{$this->context->id}/create")) {
                            echo Html::a('<i class="fa fa-plus"></i> ' . Common::getTitle("{$this->context->id}/create"), ['create'], ['class' => 'btn btn-primary btn-xs']);
                        }
                        if (common::checkActionAccess("{$this->context->id}/import")) {
                            echo Html::a('<i class="fa fa-upload"></i> ' . Common::getTitle("{$this->context->id}/import"), ['import'], ['class' => 'btn btn-primary btn-xs import-contact']);
                        }
                        ?>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row m-b-sm m-t-sm">

                    </div>
                    <div class="table-responsive">
                        <?php Pjax::begin(['id' => 'search-grid-pjax']); ?>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'options' => ['class' => 'project-list'],
                            'tableOptions' => ['class' => 'table table-hover',],
                            'summaryOptions' => ['class' => 'dataTables_info'],
                            'layout' => "{items}\n{summary}\n<div class=\"pull-right\">{pager}</div>",
                            'columns' => [


                                'id',
                                [
                                    'label'=>'List Name',
                                    'value'=>function($data){
                                        return $data->type->name;
                                    }
                                ],
                                'first_name',
                                'last_name',
                                'email_id:email',
                                [
                                    'header'=>'Unsubscribed',
                                    'value'=>function($model){
                                        return ($model->unsubscribed)?"Yes":"No";
                                    }
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Action',
                                    'template' => Common::gridViewButton($this->context->id) . ' ' . Common::gridUpdateButton($this->context->id) . ' ' . Common::gridDeleteButton($this->context->id),
                                ],
                            ],
                        ]); ?>
                        <?php Pjax::end(); ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal inmodal" id="import-contact" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?= backend\vendors\Common::translateText('CLOSE_BTN_TEXT') ?></span>
                    </button>
                    <h4 class="modal-title">Import Contacts</h4>
                </div>
                <div class="modal-body">
                    <?php $xform = ActiveForm::begin(['action' => ['import'], 'options' => ['enctype' => 'multipart/form-data'],'enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => 'col-sm-4'], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $c_list = ContactList::getList();
                            $c_list['Other'] = "Create New List";
                            ?>
                            <?= $xform->field($contact, 'list_drop')->dropDownList($c_list, Common::getDropDownOptions($contact, 'list_id')) ?>
                            <?= $xform->field($contact, 'list_input', ['options' => ['style' => 'display:none']])->textInput(['maxlength' => 255]) ?>
                            <?= $xform->field($contact, 'csv')->fileInput() ?>
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                    <span class="help-block m-b-none"><i class="fa fa-exclamation-triangle"></i>
                        File Format should be CSV. First column is <b>First Name</b>, Second column <b>Last Name</b> and third column <b>Email Address</b>
                    </span>
                    <span class="help-block m-b-none"><i class="fa fa-exclamation-triangle"></i>
                        <a href="<?= Yii::$app->urlManagerFrontend->baseUrl."/uploads/files/import_contact.csv"?>" >Download Demo CSV</a>
                    </span>
                    </div>
                    <div class="row">
                        <div class="hr-line-dashed"></div>
                        <div class="form-group col-sm-12">
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary pull-right']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
<?php

$this->registerJs(
    "$('.contact-index').on('click', '.import-contact',function (e) {
            e.preventDefault();
            $('#import-contact').modal('show');
            $('#contact-list_drop').trigger('change');
    });
    $('#contact-list_drop').change(function(){
        if($(this).val() == 'Other'){
            $('.field-contact-list_input').show();
        }else{
            $('#contact-list_input').val('');
            $('.field-contact-list_input').hide();
        }
    });

    ", View::POS_READY
);
?>