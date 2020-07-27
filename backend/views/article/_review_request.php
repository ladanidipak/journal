<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model backend\models\search\EditorialBoardSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-sm-6">
        <table class="table table-striped table-bordered">
            <tbody>
            <tr>
                <td>Article ID</td>
                <td><?= $article->paper_id ?></td>
            </tr>
            <tr>
                <td>Title</td>
                <td><?= $article->article_title ?></td>
            </tr>
            <tr>
                <td>Author Name</td>
                <td><?= $article->author_name ?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-sm-6">
        <table class="table table-striped table-bordered">
            <tbody>
            <tr>
                <td>Branch</td>
                <td><?= ($article->branch_id == "13") ? $article->branch_name : $article->branch->name ?></td>
            </tr>
            <tr>
                <td>Keywords</td>
                <td><?= $article->keyword ?></td>
            </tr>
            <tr>
                <td>Received Date</td>
                <td><?= date('d/m/Y', strtotime($article->created_dt)) ?></td>
            </tr>
            <tr>
                <td>RR</td>
                <td><?= $article->requestedReviewer ?></td>
            </tr>
            <tr>
                <td>STR</td>
                <td><?= $article->sentReviewer ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<hr>
<?php $form = ActiveForm::begin(['id' => 'review-request-file', 'options' => ['enctype' => 'multipart/form-data'], 'enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => 'col-sm-12'], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>
    <div class="row">
        <div class="col-sm-12">
            <span class="help-block m-b-none">
                <i class="fa fa-exclamation-triangle"></i>
                <?php if ($article->reviewer_copy): ?>
                    Previously uploaded reviewer copy found, you can skip uploading new one.
                <?php else: ?>
                    If no file is chosen then <b>default article file</b> will be sent to reviewer.
                <?php endif; ?>

            </span>
        </div>
        <?= $form->field($article, 'reviewer_copy')->fileInput()->label(false); ?>
    </div>
    <div class="row">
        <div class="form-group col-sm-12">
            <?= Html::submitButton('Upload', ['class' => 'btn btn-primary pull-left']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
    <hr>
<?php $form = ActiveForm::begin(['id' => 'review-request-form', 'enableAjaxValidation' => false, 'enableClientValidation' => true, 'fieldConfig' => ['options' => ['class' => 'col-sm-12'], 'checkboxTemplate' => "<label class=\"control-label\">{labelTitle}</label>\n<div>\n{beginLabel}\n{input}\n{endLabel}\n{error}\n{hint}\n</div>"]]); ?>
<div class="row">
        <?= Html::dropDownList('branches',null,backend\models\Branch::getBrancheNames(), ['id'=>'search-branch-pop-1','class'=>'chosen-select-width','multiple'=>'multiple', 'data-placeholder'=>'Select Branch']) ?>
</div>
<br>
    <div class="row">

        <?php
        $reviewersList->pagination = false;
        $reviewersList->sort = false;
         // $form->field($reviewRequest, 'reviewer_ids')->inline()->checkboxList($reviewersList, ['separator' => '<br><hr>', 'encode' => false]) ?>
        <?=
        GridView::widget([
            'id' => 'article-review-request',
            'dataProvider' => $reviewersList,
            'options' => ['class' => 'project-list table-responsive'],
            'tableOptions' => ['class' => 'table table-striped-new table-bordered',],
            'summaryOptions' => ['class' => 'dataTables_info'],
            'layout' => "{items}",
            'columns' => [
                [
                    'class' => 'yii\grid\CheckboxColumn',
                ],
                'full_name',
                [
                    'header' => 'Contact',
                    'content' => function($data){
                        return $data->email."<br>".$data->phone;
                    }
                ],
                [
                    'header' => 'Branch',
                    'content' => function($data){
                        return $data->branch_id == 13 || $data->branch_id == 0?$data->branch_name:$data->branch->name;
                    }
                ],
                'specialization',
                [
                    'header' => 'Article Reviewed this month',
                    'content' => function($data){
                        return $data->articleReviewedInMonth;
                    }
                ],
                [
                    'header' => 'Last Reviewed Date',
                    'content' => function($data){
                        return $data->lastReviewedDate;
                    }
                ],
                'max_article',
                [
                    'header' => 'Reviews Pending',
                    'content' => function($data){
                        return $data->reviewsPending;
                    }
                ],
                [
                    'header' => 'Note',
                    'content' => function($data){
                        return $data->note;
                    }
                ]

            ]
        ])
        ?>


    </div>
    <div class="row">
        <div class="hr-line-dashed"></div>
        <div class="form-group col-sm-12">
            <?= Html::submitButton('SEND', ['class' => 'btn btn-primary pull-left']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
<?php
    $this->registerJs(
        "var table_search_1 = $('#article-review-request table').DataTable({\"aLengthMenu\": [ 10, 25, 50, 100, 200 ]});
        $('#search-branch-pop-1').chosen({width : '250px'});
        $('#search-branch-pop-1').change(function(){
            if($(this).val() != null){
                var search = $('#search-branch-pop-1').val().join('|');
                table_search_1.column( 3 ).search( search, true, false ).draw();
            }else{
                table_search_1.column( 3 ).search( '', true, false ).draw();
            }
        });
        ",
        View::POS_READY
    );
?>
