<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;

?>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?=$mText;?></h3>
        <ul class="pull-right breadcrumb">
            <li><?=Html::a('Home',['/site/index']);?></li>
            <li><?=Html::a($mText,['/practice/index']);;?></li>
            <li class="active"><?=$names;?></li>
        </ul>
    </div>
</div>
<div class="container content">
    <div class="row">
        <div class="col-md-12">
            <?php
            $form = ActiveForm::begin([
                        'id' => 'login-form-inline',
                        'type' => ActiveForm::TYPE_INLINE,
                        'options' => [                           
                            'class' => 'sky-form',
                            'target' => '_blank'
                        ],
                        'formConfig' => [
                            'labelSpan' => 1,
                            'deviceSize' => ActiveForm::SIZE_SMALL,
                        ]
            ]);
            ?>   
        <div class="panel panel-success margin-bottom-5">            
            <div class="panel-heading">
                <h3><?= $names; ?></h3>
            </div><label class="label"></label>
            <div class="panel">
                <div class="panel-body">
                 <div class="col-xs-3">&nbsp;</div>
                <div class="col-xs-6">
                      <label for="inputEmail3" class="pull_right control-label">กรอกปี พ.ศ. ที่คัดกรอง :</label>   
                      &nbsp;&nbsp;
                <?= $form->field($model, 'text1',
                      [
                             'inputOptions' => [
                                     'style' => 'width:80px;text-align:center;',
                                     'placeholder' => '',
                             ]
                      ]        
                        );
                ?>              
                </div>       
                       <?= Html::submitButton('<span></span>Preview',['class' => 'btn btn-primary btn-bold btn-sm']) ?>                 
            </div> 
    <?php ActiveForm::end(); ?>    
</div>  
</div>
        </div>
    </div>
</div>