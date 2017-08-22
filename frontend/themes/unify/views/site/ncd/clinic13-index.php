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
                            'labelSpan' => 1,
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
                    <div class="col col-md-4 text-right">
                        <div class="form-group">
                            <label class="label">วันที่รับบริการ :
               <?= DatePicker::widget([
                             'model' => $model,
                             'attribute' => 'date1',
                             'name' =>'date1', 
                             'language' => 'th',
                             'dateFormat' => 'yyyy-MM-dd',       
                             'options' => [
                                   'style' => 'width:105px;height:36px;text-align:center;',
                                   'placeholder' => '    /  /  ',  
                                   'class' => 'form-control state-success'
                             ],       
                      ]); 
               ?>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="label">---
               <?= DatePicker::widget([
                             'model' => $model,
                             'attribute' => 'date2',
                             'name' =>'date2', 
                             'language' => 'th',
                             'dateFormat' => 'yyyy-MM-dd',
                             'options' => [
                                   'style' => 'width:105px;height:36px;text-align:center;',
                                   'placeholder' => '    /  /  ',
                                   'class' => 'form-control state-success'
                             ],
                      ]);
                ?> 
                            </label>
                        </div>
                    </div>
                    <div class="col col-md-3 indent">
                        <label class="label"> 
                                <?php
                                            echo Select2::widget([
                                                'model' => $model,
                                                'attribute' => 'select1',
                                                'name' => 'select1',
                                                'data' => [
                                                    '001,เบาหวาน' => 'คลินิกเบาหวาน',
                                                    '002,ความดันโลหิตสูง' => 'คลินิกความดันโลหิตสูง',
                                                ],
                                                'size' => Select2::SMALL,
                                                'theme' => 'krajee',
                                                'options' => ['placeholder' => '=========  เลือกคลินิก ========='],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ]);
                                ?>  
                        </label>    
                    </div>
                    <div class="col col-md-3 indent">
                           <label class="label">   
                                <?php
                                            echo Select2::widget([
                                                'model' => $model,
                                                'attribute' => 'select2',
                                                'name' => 'select2',
                                                'data' => [
                                                    '10897,รพ.นางรอง' => 'รพ.นางรอง',                        
                                                    '02921,รพ.สต.หนองกก' => 'รพ.สต.หนองกก',
                                                    '02922,รพ.สต.บ้านเขว้า' => 'รพ.สต.บ้านเขว้า',
                                                    '02923,รพ.สต.ทุ่งโพธิ์' => 'รพ.สต.ทุ่งโพธิ์',
                                                    '02924,รพ.สต.หนองทองลิ่ม' => 'รพ.สต.หนองทองลิ่ม',
                                                    '02925,รพ.สต.โคกศรีพัฒนา' => 'รพ.สต.โคกศรีพัฒนา',
                                                    '02926,รพ.สต.ผักหวาน' => 'รพ.สต.ผักหวาน',
                                                    '02927,รพ.สต.หนองไทร' => 'รพ.สต.หนองไทร',
                                                    '02928,รพ.สต.ก้านเหลือง' => 'รพ.สต.ก้านเหลือง',
                                                    '02929,รพ.สต.บ้านสิงห์' => 'รพ.สต.บ้านสิงห์',
                                                    '02930,รพ.สต.โคกแร่' => 'รพ.สต.โคกแร่',
                                                    '02931,รพ.สต.โคกยาง' => 'รพ.สต.โคกยาง',
                                                    '02932,รพ.สต.หนองยาง(หนองยายพิมพ์)' => 'รพ.สต.หนองยาง(หนองยายพิมพ์)',
                                                    '02933,รพ.สต.หัวถนน' => 'รพ.สต.หัวถนน',
                                                    '02934,รพ.สต.ชุมแสง' => 'รพ.สต.ชุมแสง',
                                                    '02935,รพ.สต.หนองโสน' => 'รพ.สต.หนองโสน',
                                                    '13837,รพ.สต.หนองยาง(หนองโบสถ์)' => 'รพ.สต.หนองยาง(หนองโบสถ์)',
                                                    '14275,รพ.สต.หนองตาไก้' => 'รพ.สต.หนองตาไก้',
                                                ],
                                                'size' => Select2::SMALL,
                                                'theme' => 'krajee',
                                                'options' => ['placeholder' => '========  เลือก รพ.สต. ========='],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ]);
                                ?>  
                           </label>
                    </div>                    
                    <?php echo Html::submitButton('Previews', ['class' => 'btn-u btn-u-red']); ?>
                </div>     
            </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />