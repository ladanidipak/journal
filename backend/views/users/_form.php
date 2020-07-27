<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\vendors\Common;

?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?php echo common::getTitle($model->isNewRecord ? "users/create" : "users/update"); ?></h5>
            </div>

            <div class="ibox-content users-form" style="display: block;">

                <?php
                $form = ActiveForm::begin(['options' => ['onsubmit' => "return validateAddmore();", 'enctype' => 'multipart/form-data','autocomplete'=>'off'],
                            'enableAjaxValidation' => false,
                            'enableClientValidation' => true,
                ]);
                ?>
                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-4">
                            <?= $form->field($model, 'first_name')->textInput(['maxlength' => 64]) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'last_name')->textInput(['maxlength' => 64]) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group">
                            <div class="col-sm-4">
                                <?= $form->field($model, 'phone')->textInput(['maxlength' => 10]) ?>
                            </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => 255]) ?>
                        </div>

                    </div>
                </div>

                

                <div class="row">
                    <div class="form-group">
                        
                        <div class="col-sm-4">
                            
                            <div class="col-sm-6">                            
                                <label class="control-label">&nbsp;</label>
                                <?=$form->field($model, 'profile_pic',['template' => '<label for="users-profile_pic" class="btn btn-primary">{input}Profile Pic</label>{error}{hint}'])->fileInput(['class' => 'hide'])?>
                            </div>
                            <div class="col-sm-6 avtarcol">   
                                <label class="control-label">&nbsp;</label>
                                <?= Html::img(Yii::$app->user->getProfilePicture($model->profile_pic, $model->id), ["class" => "img-circle"]); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                                                
                    </div>
                </div>


                <div class="row">
                    <div class="hr-line-dashed"></div>
                    <div class="form-group col-sm-12">
                        <a class="btn btn-white pull-right" onclick="location.href = '<?= Url::to(['index']) ?>'"><?= common::translateText("CANCEL_BTN_TEXT") ?></a>
                        <?= Html::submitButton($model->isNewRecord ? (common::translateText("CREATE_BTN_TEXT")) : (common::translateText("UPDATE_BTN_TEXT")), ['class' => $model->isNewRecord ? 'btn btn-primary pull-right' : 'btn btn-primary pull-right']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>