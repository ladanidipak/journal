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
    if ($article->status == 1) {
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
            <?= $form->field($article, 'article_review')->textarea(['placeholder' => $article->getAttributeLabel("Write Your review comment here"), 'rows' => 10])->label(false); ?>
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
