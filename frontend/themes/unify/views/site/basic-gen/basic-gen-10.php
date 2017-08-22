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
            <li><?=
                Html::a($mText, ['/service/index1']);
                ;
                ?></li>
            <li class="active"><?= $names; ?></li>
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
                            //'target' => '_blank'
                        ],
                        'formConfig' => [
                            'labelSpan' => 1,
                            'deviceSize' => ActiveForm::SIZE_SMALL,
                        ]
            ]);
            ?>     
        <div class="panel panel-aqua margin-bottom-5">            
            <div class="panel-heading">
                <h3><?= $names; ?></h3>
            </div><label class="label"></label>
            <div class="panel">
                <div class="panel-body">
                    <div class="col-md-5 text-right">
                        <div class="form-group">
                            <label class="label">วันที่รับบริการ :
                                <?= DatePicker::widget([
                                              'model' => $model,
                                              'attribute' => 'date1',
                                              'name' =>'date1', 
                                              'language' => 'th',
                                              'dateFormat' => 'yyyy-MM-dd',       
                                              'options' => [
                                                    'style' => 'width:120px;height:36px;text-align:center;',
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
                                                    'style' => 'width:120px;height:36px;text-align:center;',
                                                    'placeholder' => '    /  /  ',
                                                    'class' => 'form-control state-success'
                                              ],
                                       ]);
                                 ?> 
                            </label>
                        </div>
                    </div>
                    <div class="col col-md-2 indent">
                           <label class="label">   
                            <?php
                                    echo Select2::widget([
                                        'name' => 'type1',
                                        'data' => [
                                            '1,ทั้งหมด' => 'ทั้งหมด',
                                            '2,แผนก/สาขา' => 'แผนก/สาขา',
                                        ],
                                        'size' => Select2::SMALL,
                                        'theme' => 'krajee',
                                        'options' => ['placeholder' => ' เลือกประเภทรายงาน', 'style' => 'width:180px;'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                            ?>
                           </label>
                    </div> 
                    <div class="col col-md-4 indent">
                        <label class="label">รูปแบบแสดงผล  
                            <span style="border-left: 1px solid #ddd; margin:0 15px 0 11px;"></span>                            
                            <?php
                            echo '<label class="cbx-label" for="s1"></label>';
                            ?>
                                <div class="form-group has-error">
                                    <label class="cbx-label" for="s1">
                            <?php
                            //echo '<label class="cbx-label" for="s_2">คน</label>';
                            echo CheckboxX::widget([
                                'name' => 's1',
                                'value' => 0,
                                'options' => ['id' => 's1']
                            ]);
                            ?>
                                     คน
                                    </label>
                                </div>
                            <span style="border-left: 1px solid #ddd; margin:0 15px 0 11px;"></span>
                                <div class="form-group has-success">
                                    <label class="cbx-label" for="s2">
                            <?php
                            echo CheckboxX::widget([
                                'name' => 's2',
                                'value' => 0,
                                'options' => ['id' => 's2']
                            ]);?>
                                        ครั้ง    
                                    </label>
                                </div>
                            <?php
                            echo '<label class="cbx-label" for="s2"></label>';
                            ?>
                            <span style="border-left: 1px solid #ddd; margin:0 15px 0 11px;"></span>     
                        </label> 
                    </div>                     
                    <div class="col col-md-1 text-left">
                    <?php echo Html::submitButton('Previews', ['class' => 'btn-u btn-u-blue']); ?>
                    </div>
                </div>     
            </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />

