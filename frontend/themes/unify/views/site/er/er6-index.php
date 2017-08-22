<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;

?>
<head>
    <style type="text/css">
        .indent{ 
                    /*padding-left: 1.0em;*/
                    padding-top: 0.5em;
                 }
    </style>
</head>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?=$mText;?></h3>
        <ul class="pull-right breadcrumb">
            <li><?=Html::a('Home',['/site/index']);?></li>
            <li><?=Html::a($mText,['/er/index']);;?></li>
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
                    <div class="col-md-4 text-right">
                        <div class="form-group">
                            <label class="label">&nbsp;วันที่ส่งต่อ  :                
               <?= DatePicker::widget([
                             'model' => $model,
                             'attribute' => 'date1',
                             'name' =>'date1', 
                             'language' => 'th',
                             'dateFormat' => 'yyyy-MM-dd',       
                             'options' => [
                                   'style' => 'width:105px;height:36px;text-align:center;',
                                   'placeholder' => '    /  /  ',    
                                   'class' => 'form-control'                                 
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
                                   'class' => 'form-control'                                 
                             ],
                      ]);
                ?> 
                            </label>
                        </div>
                    </div>
               <div class="col-xs-5 indent">
                <?php
                       echo Select2::widget([
                            'model' => $model,
                            'attribute' => 'select1',
                            'data' => $data,
                             'size' => Select2::SMALL,
                            'theme' => 'bootstrap',
                            'options' => [
                                'placeholder' => '======== เลือกสาเหตุการส่งต่อ =========', 'style' => 'width:220px;height:36px;'
                             ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                ?> 
               </div>    

        <div class="col-xs-3 indent">
                <?php
                      $list = [0 => 'ambulance', 1 => 'ไปเอง'];
                      echo $form->field($model, 'radio_list')->radioList($list, ['inline'=>true]);
                ?>                 
        </div><br /><br /><br />
        <div class="row">         
            <div class="col-xs-4"></div>
            <div class="col-xs-4 center"> &nbsp;           
                    <?php echo Html::submitButton('Previews', ['class' => 'btn-u btn-u-purple']); ?>  
            </div>    
            <div class="col-xs-4"></div>            
       </div> 
                </div>
        <?php ActiveForm::end(); ?>    
       </div>  
    </div>   
        </div>
    </div>
</div>