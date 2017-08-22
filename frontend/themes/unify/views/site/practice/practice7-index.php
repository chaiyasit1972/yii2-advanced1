<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;
use kartik\checkbox\CheckboxX;

?>
<head>
    <style type="text/css">
        .indent{ 
                    /*padding-left: 1.0em;*/
                    padding-top: 0.25em;
                 }
    </style>
</head>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?= $mText; ?></h3>
        <ul class="pull-right breadcrumb">
            <li><?= Html::a('Home', ['/site/index']); ?></li>
            <li><?= Html::a($mText, ['/practice/index']);?></li>
            <li class="active"><?= $names; ?></li>
        </ul>
    </div>
</div>
            <?php
            $form = ActiveForm::begin([
                        'id' => 'login-form-inline',
                        'type' => ActiveForm::TYPE_INLINE,
                        'options' => [                           
                            'class' => 'sky-form',
                           // 'target' => '_blank'
                        ],
                        'formConfig' => [
                            'labelSpan' => 1,
                            'deviceSize' => ActiveForm::SIZE_SMALL,
                        ]
            ]);
            ?>
<fieldset>            
    <div class="row">
        <div class="panel panel-success margin-bottom-5">            
            <div class="panel-heading">
                <h3><?= $names; ?></h3>
            </div>
            <div class="panel">      
                <div class="panel-body">
                    <div class="col col-2"></div>
                    <label class="label col col-1">วันที่รายงาน :</label>
                    <section class="col col-2 text-right">               
                        <label class="input text-right">
                        <?= DatePicker::widget([
                                    'model' => $model,
                                    'attribute' => 'date1',
                                    'name' =>'date1', 
                                    'language' => 'th',
                                    'dateFormat' => 'yyyy-MM-dd',       
                                    'options' => [
                                          'style' => 'width:190px;height:35px;text-align:center;',
                                          'placeholder' => '    /  /  ',  
                                          'class' => 'form-control'
                                     ],       
                                ]); 
                        ?>
                        </label>
                    </section>                    
                    <section class="col col-3 indent">
                        <label class="select">
                                            <?php
                                echo Select2::widget([
                                     'model' => $model,
                                     'attribute' => 'select1',
                                     'data' => $data,
                                     'size' => Select2::SMALL,
                                     'theme' => 'bootstrap',
                                     'options' => [
                                         'placeholder' => '============ เลือกชมรม ============',
                                         'style' => 'height:56px;',
                                      ],
                                     'pluginOptions' => [
                                         'allowClear' => true
                                     ],
                                 ]);
                ?> 
                        </label>
                    </section>
                    <div class="col col-1"></div>     
                    <?php echo Html::submitButton('Previews', ['class' => 'btn-u btn-u-red']); ?>
                </div>   
                </div>
            </div>
         </div>
  </div>      
</fieldset>
            <?php ActiveForm::end(); ?>  