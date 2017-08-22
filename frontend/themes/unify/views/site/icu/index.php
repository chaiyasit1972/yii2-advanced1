<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;

?>

<div class="breadcrumbs">
    <div class="container">
        <h4 class="pull-left"><?=$names;?></h4>
        <ul class="pull-right breadcrumb">
            <li><?=Html::a('Home',['/site/index']);?></li>
            <li><?=Html::a($mText,['/ipd-icu/index']);;?></li>
        </ul>
    </div>
</div>
   <div class="service-info margin-bottom-100">           
        <div class="container content-boxes-v2">        
            <div class="row service-block-v6">
                <div class="col-md-6 md-margin-bottom-50">
                 <i class="icon-custom rounded-x icon-sm icon-color-u icon-line">1</i>
                    <div class="service-desc">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <?=Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                     รายงานข้อมูลผู้ป่วยใน(<small>sepsis,sepsis shock</small>)  ',['/ipd-icu/icu1']);?>
                                </h4>
                            </div>                        
                        
                    </div>
                </div>                               
 
               
                </div>
                 
                 
                 
                
                
                
                
                <div class="col-md-6 md-margin-bottom-50">
                
                 
                </div> 
            
            
            
            </div>            

        </div>
   </div>







  