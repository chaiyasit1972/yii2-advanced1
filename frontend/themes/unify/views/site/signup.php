<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';

?>
<div class="breadcrumbs">
    <div class="container">
        <ul class="pull-right breadcrumb">
            <li><?= Html::a('Home', ['site/index']) ?></li>
            <li class="active">SignUp</li>
        </ul>
    </div>
</div>
<div class="container content">
    <div class="row margin-bottom-60">
        <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
            <div class="service">
                <i class="fa fa-cogs service-icon"></i>
                  <div class="desc">
                                    <?php $form = ActiveForm::begin([
                                                                'id' => 'form-signup',
                                                                'options' => [
                                                                                   'class' => 'reg-page',
                                                                                 ],    
                                                            ]); 
                                    ?>
            <div class="reg-header">
                <h1><?= Html::encode($this->title) ?>&nbsp;: </h1>          
                <h5>  Please fill out the following fields to signup</h5>
            </div>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
              </div>
            </div>                
        </div>
    </div><!--/row-->
</div>