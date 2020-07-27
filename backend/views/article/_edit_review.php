<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?= backend\vendors\Common::translateText('CLOSE_BTN_TEXT') ?></span></button>
    <h4 class="modal-title">Reviewed By : <?= $article->reviewer->full_name ?></h4>
</div>
<div class="modal-body">
    <div class="row">

        <?php
        $reviewArray = \yii\helpers\Json::decode($article->article_review);
        $article->article_review = $reviewArray['comment'];
        $editor_comment = isset($reviewArray['editor_comment'])?$reviewArray['editor_comment']:null;
        if(isset($reviewArray['que_1'])){
            $reviews = $reviewArray['que_1'];
        }else{
            $reviews = $reviewArray;
        }
        ?>

        <?php $form = ActiveForm::begin(['id' => 'edit-review-form', 'enableClientValidation'=>true,'validateOnSubmit'=>true,'options' => ['class' => 'm-t']]);?>
        <div class='row table-responsive'>
            <div class="col-sm-12">
                <table class='table-bordered review-table'>
                    <thead>
                    <tr>
                        <th>Sr.No.</th>
                        <th>Topics</th>
                        <th>Fully Agree</th>
                        <th>Agree</th>
                        <th>Partial Agree</th>
                        <th>Disagree</th>
                        <th>Not Necessary</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach (\backend\models\Published::$reviewQuestions as $key => $question): ?>
                        <tr>
                            <td><?= $key+1 ?></td>
                            <td><?= $question?></td>
                            <?php foreach(\backend\models\Published::$reviewAnswers as $answer): ?>
                                <td><?= Html::radio("review_q[$question]", $reviews[$question] == $answer, ['value'=>$answer,'class'=>'review_q_required']);?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
        <?php if(isset($reviewArray['que_2'])){ ?>
            <div class="row">
                <table class='table-responsive table-bordered col-sm-12 review-table'>
                    <thead><tr><th colspan="2">Recommendation</th></tr></thead>
                    <tbody>
                    <?php
                    $count = 1;
                    foreach(\backend\models\Published::$recommendation as $answer): ?>
                        <tr>
                            <td style="width: 50px;">&nbsp;<?= Html::radio("que_2[Recommendation]", $reviewArray['que_2']['Recommendation'] == $answer, ['id'=>'recom_'.$count,'value'=>$answer,'class'=>'review_q_required']);?>&nbsp;</td>
                            <td><label class="normal-font" for="<?='recom_'.$count?>"><?=$answer?></label></td>
                        </tr>
                        <?php
                        $count++;
                    endforeach; ?>

                    </tbody>
                </table>
            </div>
            <div class="row">
                <table class='table-responsive table-bordered col-sm-12 review-table'>
                    <thead><tr><th colspan="2">How would you rate this article?</th></tr></thead>
                    <tbody>
                    <?php
                    $count = 1;
                    foreach(\backend\models\Published::$article_ratting as $answer): ?>
                        <tr>
                            <td style="width: 50px;">&nbsp;<?= Html::radio("que_2[How would you rate this article?]", $reviewArray['que_2']['How would you rate this article?'] == $answer, ['id'=>'rate_'.$count,'value'=>$answer,'class'=>'review_q_required']);?>&nbsp;</td>
                            <td><label class="normal-font" for="<?='rate_'.$count?>"><?=$answer?></label></td>
                        </tr>
                        <?php
                        $count++;
                    endforeach; ?>

                    </tbody>
                </table>
            </div>
            <div class="row">
                <table class='table-responsive table-bordered col-sm-12 review-table'>
                    <thead><tr><th colspan="2"><?php echo $re_quest = \backend\models\Published::$re_review_question?></th></tr></thead>
                    <tbody>
                    <tr>
                        <td style="width: 50px;">&nbsp;<?= Html::radio("que_2[$re_quest]", $reviewArray['que_2'][$re_quest] == 'Yes', ['id'=>'rq_1','value'=>'Yes','class'=>'review_q_required']);?>&nbsp;</td>
                        <td><label class="normal-font" for="rq_1">Yes</label></td>
                    </tr>
                    <tr>
                        <td style="width: 50px;">&nbsp;<?= Html::radio("que_2[$re_quest]", $reviewArray['que_2'][$re_quest] == 'No', ['id'=>'rq_2','value'=>'No','class'=>'review_q_required']);?>&nbsp;</td>
                        <td><label class="normal-font" for="rq_2">No</label></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <table class='table-responsive table-bordered col-sm-12 review-table'>
                    <thead><tr><th colspan="2">Revision Recommendation</th></tr></thead>
                    <tbody>
                    <?php
                    $count = 1;
                    foreach(\backend\models\Published::$revision_text as $answer): ?>
                        <tr>
                            <td style="width: 50px;">&nbsp;<?= Html::radio("que_2[Revision Recommendation]", $reviewArray['que_2']['Revision Recommendation'] == $answer, ['id'=>'rr_'.$count,'value'=>$answer,'class'=>'review_q_required']);?>&nbsp;</td>
                            <td><label class="normal-font" for="<?='rr_'.$count?>"><?=$answer?></label></td>
                        </tr>
                        <?php
                        $count++;
                    endforeach; ?>

                    </tbody>
                </table>
            </div>
        <?php } ?>

        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($article, 'article_review')->textarea(['placeholder' => "Write Your review comment here", 'rows' => 5])->label(false); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group field-article-editor-comment">
                    <?= Html::textarea('editor_comment',$editor_comment,['rows'=>5,'placeholder' => "Editor's Comment",'class'=>'form-control']) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3 pull-right">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary block full-width m-b', 'name' => 'submit-button']); ?>
            </div>
        </div>
        <?php  ActiveForm::end();?>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
</div>
