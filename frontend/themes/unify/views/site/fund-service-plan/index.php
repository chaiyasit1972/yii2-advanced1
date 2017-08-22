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
        <h4 class="pull-left"><?=$names;?></h4>
        <ul class="pull-right breadcrumb">
            <li><?=Html::a('Home',['/site/index']);?></li>
            <li><?=Html::a($mText,['/fund-service-plan/index']);;?></li>
        </ul>
    </div>
</div>
<div class="margin-bottom-10"></div>       
<div class="row margin-left-5 margin-right-5">
    <div class="col-md-4">

        
        <div id="myCarousel" class="carousel slide carousel-v1">
            <div class="carousel-inner">
                <div class="item active">
                    <img src="<?= $baseUrl ?>/assets/img/pharo1.jpg" alt="">
                </div>
                <div class="item">
                    <img src="<?= $baseUrl ?>/assets/img/pharo2.jpg" alt="">
                </div>
                <div class="item">
                    <img src="<?= $baseUrl ?>/assets/img/pharo3.jpg" alt="">
                </div>
                <div class="item">
                    <img src="<?= $baseUrl ?>/assets/img/pharo4.jpg" alt="">
                </div>
                <div class="item">
                    <img src="<?= $baseUrl ?>/assets/img/pharo5.jpg" alt="">
                </div>
                <div class="item">
                    <img src="<?= $baseUrl ?>/assets/img/pharo6.jpg" alt="">
                </div>
                <div class="item">
                    <img src="<?= $baseUrl ?>/assets/img/pharo7.jpg" alt="">
                </div>
                <div class="item">
                    <img src="<?= $baseUrl ?>/assets/img/pharo8.jpg" alt="">
                </div>
                <div class="item">
                    <img src="<?= $baseUrl ?>/assets/img/pharo9.jpg" alt="">
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
                             <span class='h5 margin-left-10'>1. สาขาหัวใจและหลอดเลือด !!</span>                             
                         </a>   
                             <ul id="collapse1" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. ร้อยละของผู้ป่วยกล้ามเนื้อหัวใจขาดเลือดเฉียบพลัน (STEMI) ได้รับยาละลายลิ่มเลือด
                                                             และ/หรือการขยายหลอดเลือดหัวใจ (PPCI) ร้อยละ 75  ',
                                                          ['/service-plan/service-plan1-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. ร้อยละของผู้ป่วยกล้ามเนื้อหัวใจขาดเลือดเฉียบพลัน (STEMI) ได้รับยาละลายลิ่มเลือด
                                                             และ/หรือการขยายหลอดเลือดหัวใจ (PPCI) ร้อยละ 75  ',
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
                                                          2. ร้อยละของผู้ป่วยกล้ามเนื้อหัวใจขาดเลือดเฉียบพลัน (STEMI) 
                                                              เสียชีวิตในโรงพยาบาลน้อยกว่าร้อยละ 10 ',
                                                          ['/service-plan/service-plan2-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2. ร้อยละของผู้ป่วยกล้ามเนื้อหัวใจขาดเลือดเฉียบพลัน (STEMI) 
                                                              เสียชีวิตในโรงพยาบาลน้อยกว่าร้อยละ 10 ',
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
                             <span class='h5 margin-left-10'>2. สาขา STROKE!!</span>                             
                         </a>   
                             <ul id="collapse2" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. ร้อยละการได้รับ Thrombolytic agent ภายใน 4.5 ชั่วโมง 
                                                              ตั้งแต่เริ่มมีอาการภาวะหลอดเลือดสมองตีบมากกว่าร้อยละ 3',
                                                          ['/service-plan/service-plan3-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. ร้อยละการได้รับ Thrombolytic agent ภายใน 4.5 ชั่วโมง 
                                                              ตั้งแต่เริ่มมีอาการภาวะหลอดเลือดสมองตีบมากกว่าร้อยละ 3',
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
                                                          2. โรงพยาบาลระดับ A มี stroke unit ร้อยละ 100 และระดับ S มี stroke unitร้อยละ 50',
                                                          ['/service-plan/service-plan4-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2. โรงพยาบาลระดับ A มี stroke unit ร้อยละ 100 และระดับ S มี stroke unitร้อยละ 50',
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
                                                          3. โรงพยาบาลระดับ M1 มี stroke unit ร้อยละ 100 มี stroke unitร้อยละ 50',
                                                          ['/service-plan/service-plan5-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          3. โรงพยาบาลระดับ M1 มี stroke unit ร้อยละ 100 มี stroke unitร้อยละ 50',
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
<!--                      
                      <li class="list-group-item list-toggle">
                          <a class="btn-u btn-u-green" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse3">
                             <span class='h5 margin-left-10'>3. สาขา มะเร็ง !!</span>                             
                         </a>   
                             <ul id="collapse3" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
                                                          ['/phar-out/phar-out1-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
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
                          <a class="btn-u btn-u-green" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse4">
                             <span class='h5 margin-left-10'>4. สาขาอุบัติเหตุฉุกเฉิน !!</span>                             
                         </a>   
                             <ul id="collapse4" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
                                                          ['/phar-out/phar-out1-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
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
                             <span class='h5 margin-left-10'>5. สาขาทารกแรกเกิด !!</span>                             
                         </a>   
                             <ul id="collapse5" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
                                                          ['/phar-out/phar-out1-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
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
                             <span class='h5 margin-left-10'>6. สาขาจิตเวช !!</span>                             
                         </a>   
                             <ul id="collapse6" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
                                                          ['/phar-out/phar-out1-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
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
                          <a class="btn-u btn-u-green" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse7">
                             <span class='h5 margin-left-10'>7. สาขาทันตกรรม !!</span>                             
                         </a>   
                             <ul id="collapse7" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
                                                          ['/phar-out/phar-out1-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
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
                          <a class="btn-u btn-u-green" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse8">
                             <span class='h5 margin-left-10'>8. สาขาตา !!</span>                             
                         </a>   
                             <ul id="collapse8" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
                                                          ['/phar-out/phar-out1-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
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
                          <a class="btn-u btn-u-green" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse9">
                             <span class='h5 margin-left-10'>9. สาขาไต !!</span>                             
                         </a>   
                             <ul id="collapse9" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
                                                          ['/phar-out/phar-out1-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
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
                          <a class="btn-u btn-u-green" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse10">
                             <span class='h5 margin-left-10'>10. สาขา 5 สาขาหลัก (สูต-นรีเวชกรรม) !!</span>                             
                         </a>   
                             <ul id="collapse10" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
                                                          ['/phar-out/phar-out1-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
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
                          <a class="btn-u btn-u-green" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse11">
                             <span class='h5 margin-left-10'>11. สาขา 5 สาขาหลัก (ศัลยกรรม) !!</span>                             
                         </a>   
                             <ul id="collapse11" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
                                                          ['/phar-out/phar-out1-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
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
                          <a class="btn-u btn-u-green" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse12">
                             <span class='h5 margin-left-10'>12. สาขา 5 สาขาหลัก (อายุรกรรม) !!</span>                             
                         </a>   
                             <ul id="collapse12" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
                                                          ['/phar-out/phar-out1-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
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
                          <a class="btn-u btn-u-green" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse13">
                             <span class='h5 margin-left-10'>13. สาขา 5 สาขาหลัก (กุมารเวชกรรม) !!</span>                             
                         </a>   
                             <ul id="collapse13" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
                                                          ['/phar-out/phar-out1-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
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
                          <a class="btn-u btn-u-green" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse14">
                             <span class='h5 margin-left-10'>14. สาขา 5 สาขาหลัก (ศัลยกรรมกระดูกและข้อ) !!</span>                             
                         </a>   
                             <ul id="collapse14" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
                                                          ['/phar-out/phar-out1-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
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
                          <a class="btn-u btn-u-green" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse16">
                             <span class='h5 margin-left-10'>15. สาขา COPD !!</span>                             
                         </a>   
                             <ul id="collapse16" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
                                                          ['/phar-out/phar-out1-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
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
                          <a class="btn-u btn-u-green" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse17">
                             <span class='h5 margin-left-10'>16. สาขา การแพทย์แผนไทย !!</span>                             
                         </a>   
                             <ul id="collapse17" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
                                                          ['/phar-out/phar-out1-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานผู้ป่วยแพ้ยา  ',
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
-->
<ul style="list-style-type: none;">
                                 <li class="list-toggle">
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. ร้อยละของผู้ป่วยที่ได้รับยาต้านการแข็งตัวของเลือดชนิดรับประทาน',
                                                          ['#']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. ร้อยละของผู้ป่วยที่ได้รับยาต้านการแข็งตัวของเลือดชนิดรับประทาน',
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
                                 <li class="list-toggle">
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2. ร้อยละของผู้ป่วยโรคหัวใจขาดเลือดชนิด STEMI ที่มีเกณฑ์ในการให้ยาละลายลิ่มเลือด
                                                                 และได้รับยาละลายลิ่มเลือด (M1-F2) ',
                                                          ['#']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2. ร้อยละของผู้ป่วยโรคหัวใจขาดเลือดชนิด STEMI ที่มีเกณฑ์ในการให้ยาละลายลิ่มเลือด
                                                                 และได้รับยาละลายลิ่มเลือด (M1-F2) ',
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
                                 <li class="list-toggle">
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          3. ร้อยละของผู้ป่วย STEMI ที่มีเกณฑ์ในการขยายหลอดเลือดหัวใจ
                                                              และได้รับการขยายหลอดเลือดหัวใจด้วยบอลลูน (PCI)',
                                                          ['#']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          3. ร้อยละของผู้ป่วย STEMI ที่มีเกณฑ์ในการขยายหลอดเลือดหัวใจ
                                                              และได้รับการขยายหลอดเลือดหัวใจด้วยบอลลูน (PCI)',
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
                                 <li class="list-toggle">
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          4. ร้อยละผู้ป่วย DM/HT ที่มีภาวะเสี่ยงต่อการ เกิดหลอดเลือดแดง
                                                                 ส่วนปลายอุดตันได้รับการตรวจคัดกรองด้วยเครื่อง ABI_CAVI  ',
                                                          ['#']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          4. ร้อยละผู้ป่วย DM/HT ที่มีภาวะเสี่ยงต่อการ เกิดหลอดเลือดแดง
                                                                 ส่วนปลายอุดตันได้รับการตรวจคัดกรองด้วยเครื่อง ABI_CAVI  ',
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
                                 <li class="list-toggle">
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          5. ร้อยละของเด็กที่ได้รับการคัดกรองโรคหัวใจพิการแต่กำเนิด ',
                                                          ['#']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          5. ร้อยละของเด็กที่ได้รับการคัดกรองโรคหัวใจพิการแต่กำเนิด ',
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
                                 <li class="list-toggle">
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          6. อัตราของผู้ป่วยมะเร็งระยะสุดท้ายที่ได้รับการดูแลแบบประคับประคองที่บ้าน ',
                                                          ['#']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          6. อัตราของผู้ป่วยมะเร็งระยะสุดท้ายที่ได้รับการดูแลแบบประคับประคองที่บ้าน ',
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
                                 <li class="list-toggle">
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          7. อัตราการให้บริการการดูแลทวารเทียมแก่ผู้ป่วยในหน่วยบริการ  ',
                                                          ['#']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          7. อัตราการให้บริการการดูแลทวารเทียมแก่ผู้ป่วยในหน่วยบริการ  ',
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
                                 <li class="list-toggle">
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          8. อัตราผู้ป่วยโรคมะเร็งเต้านมและลำไส้ใหญ่ที่ได้รับเคมีบำบัดโดยหน่วยบริการ(เฉพาะA S) ',
                                                          ['#']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          8. อัตราผู้ป่วยโรคมะเร็งเต้านมและลำไส้ใหญ่ที่ได้รับเคมีบำบัดโดยหน่วยบริการ(เฉพาะA S) ',
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