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
                    padding-top: 0.4em;
                 }
    </style>
</head>
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
                           // 'target' => '_blank'
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
                    <div class="col-md-4 text-right">
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
                        <label class="select state-success"> 
                                <?php
                                echo Select2::widget([
                                    'name' => 'type',
                                    'data' => [
                                        '51,กลุ่มผู้สูงอายุติดบ้าน' => 'กลุ่มผู้สูงอายุติดบ้าน',
                                        '52,กลุ่มผู้สูงอายุติดเตียง' => 'กลุ่มผู้สูงอายุติดเตียง',
                                        '53,กลุ่มผู้สูงอายุติดสังคม' => 'กลุ่มผู้สูงอายุติดสังคม',
                                    ],
                                    'size' => Select2::SMALL,
                                    'theme' => 'krajee',
                                    'options' => ['placeholder' => '=========  เลือกประเภท  =========', 'style' => 'width:220px;'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>  
                        </label>    
                    </div>
                    <div class="col col-md-3 indent">
                           <label class="select state-success">   
                                <?php
                                echo Select2::widget([
                                    'name' => 'village',
                                    'data' => $data,
                                    'size' => Select2::SMALL,
                                    'theme' => 'krajee',
                                    'options' => ['placeholder' => '=========  เลือกหมู่  =========', 'style' => 'width:200px;'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>  
                           </label>
                    </div>  
                    <?php echo Html::submitButton('Previews', ['class' => 'btn-u btn-u-blue']); ?>

                </div>     
            </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />