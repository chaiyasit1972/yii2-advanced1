<?php

use yii\helpers\Html;
use dosamigos\datepicker\DateRangePicker;
use kartik\widgets\ActiveForm;

?>
<head>
    <style type="text/css">
        .indent{ 
                    /*padding-left: 1.0em;*/
                    padding-top: 1.45em;
                 }
    </style>
</head>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?=$mText;?></h3>
        <ul class="pull-right breadcrumb">
            <li><?=Html::a('Home',['/site/index']);?></li>
            <li><?=Html::a($mText,['/ncd-clinic/index']);;?></li>
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
                           // 'labelSpan' => 1,
                            'deviceSize' => ActiveForm::SIZE_SMALL,
                        ]
            ]);
            ?>     
        <div class="panel panel-sea margin-bottom-5">            
            <div class="panel-heading">
                <h3><?= $names; ?></h3>
            </div><label class="label"></label>
            <div class="panel">
                <div class="panel-body">
                    <div class="col col-md-5 text-right">
                        <div class="form-group">
                            <label class="label">วันที่ข้อมูลชุด A :
                                <?=
                                        $form->field($model, 'date1')->widget(DateRangePicker::className(),
                                             [ 
                                                 'attributeTo' => 'date2', 
                                                 'language' => 'th', 'size' => 'sm',
                                                  'class' => 'input-group date',    
                                                 'clientOptions' => 
                                                   [ 
                                                       'autoclose' => true, 
                                                       'format' => 'yyyy-mm-dd',
                                                       'class' => 'input-group date'    
                                                   ]
                                             ]);
                                ?> 
                            </label>
                        </div>
                    </div>
                    <div class="col col-md-5 text-right">
                        <div class="form-group">
                            <label class="label">วันที่ข้อมูลชุด B :
                                <?=
                                        $form->field($model, 'date3')->widget(DateRangePicker::className(),
                                             [ 
                                                 'attributeTo' => 'date4', 
                                                 'language' => 'th', 'size' => 'sm',
                                                  'class' => 'input-group date',    
                                                 'clientOptions' => 
                                                   [ 
                                                       'autoclose' => true, 
                                                       'format' => 'yyyy-mm-dd',
                                                       'class' => 'input-group date'    
                                                   ]
                                             ]);
                                ?> 
                            </label>
                        </div>
                    </div>                
                    
                    <div class="col col-md-2 text-left indent">
                     <?php echo Html::submitButton('Previews', ['class' => 'btn-u btn-u-red']); ?>
                    </div>                        
                </div>     
            </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />