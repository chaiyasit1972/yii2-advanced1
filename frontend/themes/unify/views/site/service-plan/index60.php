<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii2assets\fullscreenmodal\FullscreenModal;
use yii\widgets\Pjax;

$asset = frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;


?>

<div class="breadcrumbs">
    <div class="container">
        <h4 class="pull-left"><?= $names;?></h4>
        <ul class="pull-right breadcrumb">
            <li><?=Html::a('Home',['/site/index']);?></li>
            <li><?=Html::a($mText,['/service-plan/index']);;?></li>
        </ul>
    </div>
</div>
<div class="margin-bottom-10"></div>       
<div class="row margin-left-5 margin-right-5">
    <div class="col-md-4">

        
        <div id="myCarousel" class="carousel slide carousel-v1">
            <div class="carousel-inner">
                <div class="item active">
                    <img src="<?= $baseUrl ?>/assets/img/bas9.jpg" alt="">
                </div>
                <div class="item">
                    <img src="<?= $baseUrl ?>/assets/img/bas3.jpg" alt="">
                </div>
              
            </div>

            <div class="carousel-arrow">
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </div>        
        
        
        
        
    </div>
    <div class="col-md-8">
        <div class="tag-box tag-box-v3 form-page">
            <div class="headline"><h3><?= $names; ?></h3></div>
            <div class="margin-bottom-40"></div>                
            <ul class="list-group sidebar-nav-v1 lists-v1" id="sidebar-nav">         
                      <li class="list-group-item list-toggle">
                          <a class="btn-u btn-u-green" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse1">
                             <span class='h5 margin-left-10'>1. สาขาสูติกรรม  </span>                             
                         </a>   
                             <ul id="collapse1" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. ร้อยละของผู้ป่วยที่ได้รับการผ่าตัดคลอดในโรงพยาบาลระดับ M2 ลงไป เป้าหมาย >25%',
                                                          ['/service-plan/service-plan601_1','year'=>'25'.$select1]) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. ร้อยละของผู้ป่วยที่ได้รับการผ่าตัดคลอดในโรงพยาบาลระดับ M2 ลงไป เป้าหมาย >25%',
                                                          ['site/modal'],
                                                          [
                                                                 'class' => 'xmodal',
                                                                 'title' => 'เปิดดูข้อมูล',
                                                                 'data-target' => '#vmodal',
                                                                 'data-pjax' => '0',
                                                          ]
                                                      );                  
                                     ?>
                                 </li>    
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2. อัตราตายมารดาจากการตกเลือดหลังคลอด  เป้าหมาย 0 % ',
                                                          ['/service-plan/service-plan601_2','year'=>'25'.$select1]) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2. อัตราตายมารดาจากการตกเลือดหลังคลอด  เป้าหมาย 0 % ',
                                                          ['site/modal'],
                                                          [
                                                                 'class' => 'xmodal',
                                                                 'title' => 'เปิดดูข้อมูล',
                                                                 'data-target' => '#vmodal',
                                                                 'data-pjax' => '0',
                                                          ]
                                                      );                  
                                     ?>
                                 </li>                                   
                             </ul>
                      </li>    
                      <li class="list-group-item list-toggle">
                          <a class="btn-u btn-u-green" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse2">
                             <span class='h5 margin-left-10'>2. สาขากุมารเวชกรรม</span>                             
                         </a>   
                             <ul id="collapse2" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. อัตราป่วยตายโรคปอดบวมในเด็ก อายุ 1 เดือน ถึง 5 ปี บริบูรณ์ ลดลงร้อยละ 10',
                                                          ['/service-plan/service-plan602_1','year'=>'25'.$select1]) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. อัตราป่วยตายโรคปอดบวมในเด็ก อายุ 1 เดือน ถึง 5 ปี บริบูรณ์ ลดลงร้อยละ 10',
                                                          ['site/modal'],
                                                          [
                                                                 'class' => 'xmodal',
                                                                 'title' => 'เปิดดูข้อมูล',
                                                                 'data-target' => '#vmodal',
                                                                 'data-pjax' => '0',
                                                          ]
                                                      );                  
                                     ?>
                                 </li>                                                                                            
                             </ul>  
                      </li>       
                      <li class="list-group-item list-toggle">
                          <a class="btn-u btn-u-green" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse3">
                             <span class='h5 margin-left-10'>3. สาขาอายุรกรรม</span>                             
                         </a>   
                             <ul id="collapse3" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. อัตราตายจาก Sepsis/Septic Shock เป้าหมาย <  &nbsp;ร้อยละ 30',
                                                          ['/service-plan/service-plan603_1','year'=>'25'.$select1]) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. อัตราตายจาก Sepsis/Septic Shock เป้าหมาย <  ร้อยละ 30',
                                                          ['site/modal'],
                                                          [
                                                                 'class' => 'xmodal',
                                                                 'title' => 'เปิดดูข้อมูล',
                                                                 'data-target' => '#vmodal',
                                                                 'data-pjax' => '0',
                                                          ]
                                                      );                  
                                     ?>
                                 </li>
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2. อัตราตายจากการติดเชื้อในกระแสเลือด (Community Acquired Sepsis)
                                                              เป้าหมาย <  &nbsp;ร้อยละ 30',
                                                          ['/service-plan/service-plan603_2','year'=>'25'.$select1]) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2. อัตราตายจากการติดเชื้อในกระแสเลือด (Community Acquired Sepsis)
                                                              เป้าหมาย <  ร้อยละ 30',
                                                          ['site/modal'],
                                                          [
                                                                 'class' => 'xmodal',
                                                                 'title' => 'เปิดดูข้อมูล',
                                                                 'data-target' => '#vmodal',
                                                                 'data-pjax' => '0',
                                                          ]
                                                      );                  
                                     ?>
                                 </li>            
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          3. อัตราการเกิด การกำเริบเฉียบพลันในผู้ป่วยโรคปอดอุดกั้นเรื้อรัง(PDX= J440,J441)',
                                                          ['/service-plan/service-plan603_3','year'=>'25'.$select1]) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          3. อัตราการเกิด การกำเริบเฉียบพลันในผู้ป่วยโรคปอดอุดกั้นเรื้อรัง(PDX= J440,J441)',
                                                          ['site/modal'],
                                                          [
                                                                 'class' => 'xmodal',
                                                                 'title' => 'เปิดดูข้อมูล',
                                                                 'data-target' => '#vmodal',
                                                                 'data-pjax' => '0',
                                                          ]
                                                      );                  
                                     ?>
                                 </li>                                      
                             </ul>  
                      </li>                         
                      </li>       
                      <li class="list-group-item list-toggle">
                          <a class="btn-u btn-u-green" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse4">
                             <span class='h5 margin-left-10'>4. สาขาศัลยกรรม</span>                             
                         </a>   
                             <ul id="collapse4" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. อัตราไส้ติ่งแตกในผู้ป่วยไส้ติ่งอักเสบ',
                                                          ['/service-plan/service-plan604_1','year'=>'25'.$select1]) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. อัตราไส้ติ่งแตกในผู้ป่วยไส้ติ่งอักเสบ',
                                                          ['site/modal'],
                                                          [
                                                                 'class' => 'xmodal',
                                                                 'title' => 'เปิดดูข้อมูล',
                                                                 'data-target' => '#vmodal',
                                                                 'data-pjax' => '0',
                                                          ]
                                                      );                  
                                     ?>
                                 </li>
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2. ร้อยละของผู้ป่วยเสียชีวิตด้วยอาการปวดท้องเฉียบพลัน Acute Abdomen',
                                                          ['/service-plan/service-plan604_2','year'=>'25'.$select1]) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2. ร้อยละของผู้ป่วยปวดท้องเฉียบพลัน Acute Abdomen',
                                                          ['site/modal'],
                                                          [
                                                                 'class' => 'xmodal',
                                                                 'title' => 'เปิดดูข้อมูล',
                                                                 'data-target' => '#vmodal',
                                                                 'data-pjax' => '0',
                                                          ]
                                                      );                  
                                     ?>
                                 </li>        
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          3. ร้อยละของผู้ป่วยที่เสียชีวิตด้วยอาการภาวะขาดเลือดที่แขนหรือขา',
                                                          ['/service-plan/service-plan604_3','year'=>'25'.$select1]) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          3. ร้อยละของผู้ป่วยที่เสียชีวิตด้วยอาการภาวะขาดเลือดที่แขนหรือขา',
                                                          ['site/modal'],
                                                          [
                                                                 'class' => 'xmodal',
                                                                 'title' => 'เปิดดูข้อมูล',
                                                                 'data-target' => '#vmodal',
                                                                 'data-pjax' => '0',
                                                          ]
                                                      );                  
                                     ?>
                                 </li>    
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          4. ร้อยละของการถูกตัดขาตั้งแต่ระดับข้อเท้าขึ้นมาของผู้ป่วยภาวะขาดเลือดที่ขา',
                                                          ['/service-plan/service-plan604_4','year'=>'25'.$select1]) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          4. ร้อยละของการถูกตัดขาตั้งแต่ระดับข้อเท้าขึ้นมาของผู้ป่วยภาวะขาดเลือดที่ขา',
                                                          ['site/modal'],
                                                          [
                                                                 'class' => 'xmodal',
                                                                 'title' => 'เปิดดูข้อมูล',
                                                                 'data-target' => '#vmodal',
                                                                 'data-pjax' => '0',
                                                          ]
                                                      );                  
                                     ?>
                                 </li>                                     
                             </ul>  
                      </li>                   
                      <li class="list-group-item list-toggle">
                          <a class="btn-u btn-u-green" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse5">
                             <span class='h5 margin-left-10'>5. สาขาศัลยกรรมกระดูก</span>                             
                         </a>   
                             <ul id="collapse5" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. ร้อยละของการดูแลรักษาของผู้ป่วยที่มีกระดูกหักไม่ซับซ้อนใน รพ.
                                                              ระดับ M2 ลงไป เป้าหมาย >  &nbsp;ร้อยละ 70',
                                                          ['/service-plan/service-plan605_1','year'=>'25'.$select1]) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. ร้อยละของการดูแลรักษาของผู้ป่วยที่มีกระดูกหักไม่ซับซ้อนใน รพ.
                                                              ระดับ M2 ลงไป เป้าหมาย >  &nbsp;ร้อยละ 70',
                                                          ['site/modal'],
                                                          [
                                                                 'class' => 'xmodal',
                                                                 'title' => 'เปิดดูข้อมูล',
                                                                 'data-target' => '#vmodal',
                                                                 'data-pjax' => '0',
                                                          ]
                                                      );                  
                                     ?>
                                 </li>                                                                                       
                             </ul>  
                      </li>  
                      <li class="list-group-item list-toggle">
                          <a class="btn-u btn-u-green" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse6">
                             <span class='h5 margin-left-10'>6. สาขามะเร็ง</span>                             
                         </a>   
                             <ul id="collapse6" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงาน 5 อันดับโรคของผู้ป่วยมะเร็ง(PDX C00-C99)',
                                                          ['/service-plan/service-plan606_1','year'=>'25'.$select1]) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงาน 5 อันดับโรคของผู้ป่วยมะเร็ง(PDX C00-C99)',
                                                          ['site/modal'],
                                                          [
                                                                 'class' => 'xmodal',
                                                                 'title' => 'เปิดดูข้อมูล',
                                                                 'data-target' => '#vmodal',
                                                                 'data-pjax' => '0',
                                                          ]
                                                      );                  
                                     ?>
                                 </li>       
                                 
                                 
                             </ul>  
                      </li>  
                      
            </ul>
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
    <div class="margin-bottom-40"></div>    