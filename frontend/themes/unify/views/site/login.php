<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
?>
<div class="breadcrumbs">
    <div class="container">
        <ul class="pull-right breadcrumb">
            <li><?= Html::a('Home', ['site/index']) ?></li>
            <li class="active">Login</li>
        </ul>
    </div>

    <div class="container content">
        <div class="row margin-bottom-60">
            <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
                <div class="service">
                    <i class="fa fa-rocket service-icon"></i>
                    <div class="desc">
                        <?php
                        $form = ActiveForm::begin([
                                    'id' => 'form-signup',
                                    'options' => [
                                        'class' => 'reg-page',
                                    ],
                        ]);
                        ?>
                        <div class="reg-header">
                            <h1><?= Html::encode($this->title) ?></h1>                                
                            <h5>Please fill out the following fields to login:</h5>
                        </div>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div style="color:#999;margin:1em 0">
                    If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
                    </div>
                </div>                
            </div>
        </div>
    </div>