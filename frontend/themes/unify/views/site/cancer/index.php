<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;

?>

<div class="breadcrumbs">
    <div class="container">
        <h4 class="pull-left"><?=$names;?></h4>
        <ul class="pull-right breadcrumb">
            <li><?=Html::a('Home',['/site/index']);?></li>
            <li><?=Html::a($mText,['/ipd-cancer/index']);;?></li>
        </ul>
    </div>
</div>
   <div class="service-info margin-bottom-100">           
        <div class="container content-boxes-v2">        
            <div class="row service-block-v6">
                <div class="col-md-6 md-margin-bottom-50">
                 <i class="icon-custom rounded-x icon-sm icon-color-u icon-line">1</i>
                    <div class="service-desc">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          รายงานทะเบียนผู้ป่วยมะเร็ง   ',
                                                          ['/ipd-cancer/cancer1']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          รายงานทะเบียนผู้ป่วยมะเร็ง   ',
                                                          ['site/modal'],
                                                          [
                                                                 'class' => 'xmodal',
                                                                 'title' => 'เปิดดูข้อมูล',
                                                                 'data-target' => '#vmodal',
                                                                 'data-pjax' => '0',
                                                          ]
                                                      );                  
                                    ?>
                                </h4>
                            </div>                        
                        
                    </div>
                </div>                               
 
               
                </div>
                 
                 
                 
                
                
                
                
                <div class="col-md-6 md-margin-bottom-50">
                 <i class="icon-custom rounded-x icon-sm icon-color-u icon-line">2</i>
                    <div class="service-desc">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <?=Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                     รายงานทะเบียนผู้ป่วยมะเร็ง (<small>sepsis,sepsis shock</small>)  ',['/ipd-cancer/cancer1']);?>
                                </h4>
                            </div>                        
                        
                    </div>
                </div>                  
                 
                </div> 
            
            
            
            </div>            

        </div>
   </div>
<?php
        $this->registerJs("
                       $('.mPop').click(function (){
                              $('#zmodal').modal('show').find('#zmodalContent').load($(this).attr('href'));
                              return false;
                              });                            
                       $('.xmodal').click(function (){
                              $('#vmodal').modal('show').find('#vmodalContent').load($(this).attr('href'));
                              return false;
                              });
                        "     
                      );
?> 
<?php
        Modal::begin([
                              'id' => 'zmodal',
                              'header' => '<h4 class="modal-title">แสดงรายการ</h4>',
                              'size'=>'modal-lg',
                              'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">ปิด</a>',
                           ]);
        echo "<div id='zmodalContent'></div>";
        Modal::end();
?> 
 <?php
        Modal::begin([
                              'id' => 'vmodal',
                              'header' => '<h4 class="modal-title">ข้อความเตือน</h4>',
                              'size'=>'modal-lg',
                              'footer' =>  Html::a('SignUp', ['/site/signup'],['class'=>'btn btn-primary']) . 
                                               Html::a('Login', ['/site/login'],['class'=>'btn btn-primary'])                   
                           ]);
        echo "<div id='vmodalContent'></div>";
        Modal::end();
 ?>  