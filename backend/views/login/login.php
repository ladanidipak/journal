<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\vendors\Common;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
$pageTitle = 'Login';
$this->params['breadcrumbs'][] = $pageTitle;
?>

<div>
    <div>
        <h1 class="logo-name"><img alt="G+" src="<?= DOCURL; ?>design_elements/images/logo.png"></h1>
    </div>
    <?php
    $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'm-t']]);
    echo $form->field($model, 'email', ['inputOptions' => ['autofocus' => 'autofocus', 'placeholder' => $model->getAttributeLabel("email")]])->label(false);
    echo $form->field($model, 'password')->passwordInput(array('placeholder' => $model->getAttributeLabel("password")))->label(false);
    echo Html::submitButton('Login', ['class' => 'btn btn-primary block full-width m-b', 'name' => 'login-button']);
    ?>
    <a href="#"><small>Forgot password?</small></a>

    <?php ActiveForm::end(); ?>

    <p class="m-t"> <small><?= Yii::$app->name . " &copy;" . date('Y') ?> </small> </p>
</div>
