<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
$this->title = 'Upload Formatted File';
?>

<div class="open-box">
    <?php echo $this->render("@backend/views/layouts/_message"); ?>
    <?php
    
    if(!$article->formatted_file){
        $form = ActiveForm::begin(['id' => 'article-form', 'options' => ['class' => 'm-t','enctype'=>'multipart/form-data']]);
        echo $form->field($article, 'formatted_file',['labelOptions'=>['class'=>'col-sm-3']])->fileInput()->label('Upload Formatted File');
        echo Html::submitButton('Submit', ['class' => 'btn btn-primary block full-width m-b', 'name' => 'submit-button']);
        ActiveForm::end();
    }else{
        echo "<h1>You have uploaded formatted file. To Update it again contact us.</h1>";
    }
    ?>
    <p class="m-t"> <small><?= Yii::$app->name . " &copy;" . date('Y') ?> </small> </p>
</div>
