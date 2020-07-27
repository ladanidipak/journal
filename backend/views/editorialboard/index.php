<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\vendors\Common;
use yii\web\View;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\EditorialBoardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerCssFile(DOCURL."design_elements/js/jquery_editable/bootstrap-editable.min.css", ['position' => View::POS_HEAD, 'depends' => 'backend\assets\AppAsset']);
$this->registerJsFile(DOCURL."design_elements/js/jquery_editable/bootstrap-editable.min.js", ['position' => View::POS_END, 'depends' => 'backend\assets\AppAsset']);
?>
<?php echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="row editorial-board-index">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?= Html::encode(Common::getTitle("{$this->context->id}/{$this->context->action->id}")) ?></h5>
                <div class="ibox-tools">
<?php
if (common::checkActionAccess("{$this->context->id}/create")) {
    echo Html::a('<i class="fa fa-plus"></i> ' . Common::getTitle("{$this->context->id}/create"), ['create'], ['class' => 'btn btn-primary btn-xs']);
}
?>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row m-b-sm m-t-sm">

                </div>
                <div class="table-responsive">
                    <?php Pjax::begin(['id' => 'search-grid-pjax']); ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'options' => ['class' => 'project-list'],
                        'tableOptions' => ['class' => 'table table-hover',],
                        'summaryOptions' => ['class' => 'dataTables_info'],
                        'layout' => "{items}\n{summary}\n<div class=\"pull-right\">{pager}</div>",
                        'columns' => [


                            'id',
                            [
                                'attribute'=>'full_name',
                                'format' => 'html',
                                'content'=>  function($data){
                                    return "<ul><li>".$data->full_name."</li><li>".'<a href="#" class="editable-note" data-type="text" data-pk="'.$data->id.'">'.($data->note?$data->note:'Enter Note').'</a>'."</li></ul>";
                                }
                            ],
                            [
                                'header'=>'Contact',
                                'format' => 'html',
                                'content'=>  function($data){
                                    return "<ul><li>".$data->email."</li><li>".$data->phone."</li></ul>";
                                }
                            ],
                            'designation',
                            [
                                'attribute'=>'qualification / specialization',
                                'format' => 'html',
                                'content'=>  function($data){
                                    $spzn = "";
                                    if($data->specialization != ""){
                                        $spzn = "<li>".$data->specialization . "</li>";
                                    }
                                    return "<ul><li>".$data->qualification."</li>".$spzn."</ul>";
                                }
                            ],
                            [
                                'attribute'=>'institute / branch',
                                'format' => 'html',
                                'content'=>  function($data){
                                    $branch_name = "";
                                    if($data->branch_id != 0){
                                        $branch_name = "<li>".($data->branch_id == 13?$data->branch_name:$data->branch->name) . "</li>";
                                    }
                                    return "<ul><li>".$data->institute_name."</li>".$branch_name."</ul>";
                                }
                            ],
                            [
                                'attribute'=>'priority',
                                'format' => 'html',
                                'content'=>  function($data){
                                    $checked = $data->priority ? "checked = 'checked' ":"";
                                    $value = $data->priority ? "1":"0";
                                    $checkbox = "<input value='$value' class='trigger-priority' type='checkbox' data-id='{$data->id}' name='priority' $checked>";
                                    return (($data->priority)?'<span class="label label-danger">Priority</span>':"")." ".$checkbox;
                                }
                            ],
                            [
                                'attribute' => 'status',
                                'format' => 'html',
                                'value' => function ($model, $key, $index, $column) {
                                    $hidden = $model->hide_in_list ? "<i class=\"fa fa-eye-slash\"></i>":"";
                                    return '<span class="label label-'.$model::$statusClass[$model->status].'">'.$model::$statusArray[$model->status].'</span> '.$hidden;
                                }
                            ],
                            [
                                'attribute'=>'priority',
                                'format' => 'html',
                                'content'=>  function($data){
                                    $checked = $data->show_in_front ? "checked = 'checked' ":"";
                                    $value = $data->show_in_front ? "1":"0";
                                    $checkbox = "<input value='$value' class='trigger-show' type='checkbox' data-id='{$data->id}' name='priority' $checked>";
                                    return (($data->show_in_front)?'<span class="label label-success">Show</span>':'<span class="label label-danger">Hide</span>')." ".$checkbox;
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'template' => "{approve} {reject} {downloadcerti}" . Common::gridViewButton($this->context->id) . ' ' . Common::gridUpdateButton($this->context->id) . ' ' . Common::gridDeleteButton($this->context->id),
                                'buttons'=>[
                                    'approve'=>function($url,$model){
                                        return (common::checkActionAccess("editorialboard/approve")) ? Html::a(' <span class="fa fa-thumbs-up"></span>', $url,['class'=>'text-success','title'=>'Approve','data-confirm'=>'Approve this reviewer?']) : "";
                                    },
                                    'reject'=>function($url,$model){
                                        return (common::checkActionAccess("editorialboard/reject")) ? Html::a(' <span class="fa fa-thumbs-down"></span>', $url,['class'=>'text-danger','title'=>'Reject','data-confirm'=>'Reject this reviewer?']) : "";
                                    },
                                    'downloadcerti'=>function($url,$model){
                                        return (common::checkActionAccess("editorialboard/downloadcerti")) ? Html::a(' <span class="fa fa-download"></span>', $url,['class'=>'text-primary','title'=>'Download']) : "";
                                    }
                                ]
                            ],
                        ],
                    ]);
                    ?>
                    <?php Pjax::end(); ?>
                </div>

            </div>
        </div>
    </div>
</div>
<?php
$this->registerJs("

    function updateEditorialBoard(){
        $('.editable-note').editable({
            url: '".Url::to(['editorialboard/note'])."',
            type: 'text',
            _csrf : yii.getCsrfToken(),
            name: 'note',
            title: 'Enter Note',
            validate: function(value) {
                if($.trim(value) == '') {
                    return 'This field is required';
                }
            },
            success: function(response, newValue) {
                if(!response.success) return response.msg;
            }
        });
        $('.trigger-priority').change(function(){
          var eid = $(this).data('id');
          var obj = $(this);
          if(obj.is(':checked')){
            obj.val('1');
          }else{
            obj.val('0');
          }
          $.post('" . Url::to(['editorialboard/priority']) . "',{id:eid, value:obj.val()},function(response){
            if(response.result == true){
              obj.parent().find('.label').remove();
              obj.parent().prepend(response.text);
            }
          },'json');
        });
         $('.trigger-show').change(function(){
          var eid = $(this).data('id');
          var obj = $(this);
          if(obj.is(':checked')){
            obj.val('1');
          }else{
            obj.val('0');
          }
          $.post('" . Url::to(['editorialboard/show']) . "',{id:eid, value:obj.val()},function(response){
            if(response.result == true){
              obj.parent().find('.label').remove();
              obj.parent().prepend(response.text);
            }
          },'json');
        });
    };
    updateEditorialBoard();
    $('#search-grid-pjax').on('pjax:end', function() {
            updateEditorialBoard();
    });

    ",View::POS_END);
?>