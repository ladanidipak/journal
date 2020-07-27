<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
$this->title = 'Article Feedback';
?>

<div class="open-box">
    <?php echo $this->render("@backend/views/layouts/_message"); ?>
    <?php
    if (empty($article_review->article_review)) {
        $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation'=>true,'validateOnSubmit'=>true,'options' => ['class' => 'm-t']]); ?>
        <div class='row'>
            <table class='table-responsive table-bordered col-sm-12 review-table'>
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
                            <td><?= Html::radio("review_q[$question]", true, ['value'=>$answer,'class'=>'review_q_required']);?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <table class='table-responsive table-bordered col-sm-12 review-table'>
                <thead><tr><th colspan="2">Recommendation</th></tr></thead>
                <tbody>
                <?php
                $count = 1;
                foreach(\backend\models\Published::$recommendation as $answer): ?>
                    <tr>
                        <td style="width: 50px;">&nbsp;<?= Html::radio("que_2[Recommendation]", false, ['id'=>'recom_'.$count,'value'=>$answer,'class'=>'review_q_required']);?>&nbsp;</td>
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
                        <td style="width: 50px;">&nbsp;<?= Html::radio("que_2[How would you rate this article?]", false, ['id'=>'rate_'.$count,'value'=>$answer,'class'=>'review_q_required']);?>&nbsp;</td>
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
                        <td style="width: 50px;">&nbsp;<?= Html::radio("que_2[$re_quest]", false, ['id'=>'rq_1','value'=>'Yes','class'=>'review_q_required']);?>&nbsp;</td>
                        <td><label class="normal-font" for="rq_1">Yes</label></td>
                    </tr>
                    <tr>
                        <td style="width: 50px;">&nbsp;<?= Html::radio("que_2[$re_quest]", false, ['id'=>'rq_2','value'=>'No','class'=>'review_q_required']);?>&nbsp;</td>
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
                        <td style="width: 50px;">&nbsp;<?= Html::radio("que_2[Revision Recommendation]", false, ['id'=>'rr_'.$count,'value'=>$answer,'class'=>'review_q_required']);?>&nbsp;</td>
                        <td><label class="normal-font" for="<?='rr_'.$count?>"><?=$answer?></label></td>
                    </tr>
                    <?php
                    $count++;
                endforeach; ?>

                </tbody>
            </table>
        </div>
        <div class="row">
            <?= $form->field($article_review, 'article_review')->textarea(['placeholder' => "Write Your review comment here", 'rows' => 10])->label(false); ?>
        </div>
        <div class="row">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary block full-width m-b', 'name' => 'submit-button']); ?>
        </div>

        <?php
        ActiveForm::end();
    } else {
        echo "<h1>You have submitted your review. To Update it contact us.</h1>";
    }
    ?>
    <p class="m-t">
        <small><?= Yii::$app->name . " &copy;" . date('Y') ?> </small>
    </p>
</div>
