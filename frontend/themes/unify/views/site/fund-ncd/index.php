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
            <li><?=Html::a($mText,['/fund-ncd/index']);;?></li>
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
                             <span class='h5 margin-left-10'>คลิกเลือกรายงาน !!</span>                             
                         </a>   
                             <ul id="collapse1" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. ผู้ป่วยเบาหวานสามารถควบคุมระดับน้าตาลได้ร้อยละ 40',
                                                          ['/service-plan/service-plan15-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. ผู้ป่วยเบาหวานสามารถควบคุมระดับน้าตาลได้ร้อยละ 40',
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
                                                          2. ผู้ป่วยเบาหวานสามารถควบคุมระดับน้าตาลได้ร้อยละ 40',
                                                          ['/service-plan/service-plan16-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2. ผู้ป่วยความดันโลหิตสูงสามารถควบคุมความดันโลหิตสูงได้ ร้อยละ 50',
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
                                                          3. ผู้ป่วยเบาหวานความครอบคลุมการตรวจ HbA1c LDL Microalbuminuria 
                                                             ตรวจตา ตรวจเท้าอย่างละเอียด   ',
                                                          ['/service-plan/service-plan17-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          3. ผู้ป่วยเบาหวานความครอบคลุมการตรวจ HbA1c LDL Microalbuminuria 
                                                             ตรวจตา ตรวจเท้าอย่างละเอียด   ',
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
                                                          4. อัตราผู้ป่วยโรคความดันโลหิตสูงที่มีความดันโลหิตอยู่ในเกณฑ์ที่ควบคุมได้ 
                                                              (SBP ต่ำกว่า 140 และ DBP ต่ำกว่า 90)  ',
                                                          ['/service-plan/service-plan18-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          4. อัตราผู้ป่วยโรคความดันโลหิตสูงที่มีความดันโลหิตอยู่ในเกณฑ์ที่ควบคุมได้ 
                                                              (SBP ต่ำกว่า 140 และ DBP ต่ำกว่า 90)  ',
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
                                                          5. อัตราผู้ป่วยโรคเบาหวาน ที่มีระดับ HbA1c ต่ำกว่า 7%  ',
                                                          ['/service-plan/service-plan19-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          5. อัตราผู้ป่วยโรคเบาหวาน ที่มีระดับ HbA1c ต่ำกว่า 7%  ',
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
                                                          6. อัตราผู้ป่วยโรคเบาหวานที่ได้รับการเจาะ HbA1c ประจำปี  ',
                                                          ['/service-plan/service-plan20-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          6. อัตราผู้ป่วยโรคเบาหวานที่ได้รับการเจาะ HbA1c ประจำปี  ',
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
                                                          7. อัตราผู้ป่วยโรคเบาหวานที่มีค่า HbA1c ต่ำกว่า 7 % ',
                                                          ['/service-plan/service-plan21-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          7. อัตราผู้ป่วยโรคเบาหวานที่มีค่า HbA1c ต่ำกว่า 7 % ',
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
                                                          8. อัตราผู้ป่วยโรคเบาหวานที่มีค่า LDL ตำกว่า 100 mgต่อdl ',
                                                          ['/service-plan/service-plan22-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          8. อัตราผู้ป่วยโรคเบาหวานที่มีค่า LDL ตำกว่า 100 mgต่อdl ',
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
                                                          9. อัตราผู้ป่วยโรคความดันโลหิตสูงที่มีค่า BP ต่ำกว่า 140ต่อ90 mmHg ',
                                                          ['/service-plan/service-plan23-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          9. อัตราผู้ป่วยโรคความดันโลหิตสูงที่มีค่า BP ต่ำกว่า 140ต่อ90 mmHg ',
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
                                                          10. อัตราการรับไว้รักษาของผู้ป่วยที่ยังไม่มีแทรกซ้อนแต่ควบคุมไม่ได้  ',
                                                          ['/service-plan/service-plan24-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          10. อัตราการรับไว้รักษาของผู้ป่วยที่ยังไม่มีแทรกซ้อนแต่ควบคุมไม่ได้  ',
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
                                                          11. อัตราการรับไว้รักษาภาวะแทรกซ้อนระยะสั้น  ',
                                                          ['/service-plan/service-plan25-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          11. อัตราการรับไว้รักษาภาวะแทรกซ้อนระยะสั้น  ',
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
                                                          12. อัตราการรับไว้รักษาภาวะแทรกซ้อนระยะยาว  ',
                                                          ['/service-plan/service-plan26-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          12. อัตราการรับไว้รักษาภาวะแทรกซ้อนระยะยาว  ',
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
                                                          13. อัตราการกลับมารักษาซ้ำในแผนกผู้ป่วยในภายใน 28 วัน  ',
                                                          ['/service-plan/service-plan18-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          13. อัตราการกลับมารักษาซ้ำในแผนกผู้ป่วยในภายใน 28 วัน  ',
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
                                                          14. ผู้ป่วยความดันโลหติสงูความครอบคลุมการตรวจ Lipid Urine protein และตรวจ FBS  ',
                                                          ['/service-plan/service-plan18-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          14. ผู้ป่วยความดันโลหติสงูความครอบคลุมการตรวจ Lipid Urine protein และตรวจ FBS  ',
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
                                                          15. อัตราผู้ป่วยโรคความดันโลหิตสูงที่ได้รับการตรวจร่างกายประจำาปี  ',
                                                          ['/service-plan/service-plan17-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          15. อัตราผู้ป่วยโรคความดันโลหิตสูงที่ได้รับการตรวจร่างกายประจำาปี  ',
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
                                                          16. อัตราผู้ป่วยโรคความดันโลหิตสูงได้รับการตรวจทางห้องปฏิบัติการประจำปี  ',
                                                          ['/service-plan/service-plan18-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          16. อัตราผู้ป่วยโรคความดันโลหิตสูงได้รับการตรวจทางห้องปฏิบัติการประจำปี  ',
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
                                                          17. อัตราผู้ป่วยโรคความดันโลหิตสูงที่มีภาวะแทรกซ้อนหัวใจและหลอดเลือด  ',
                                                          ['/service-plan/service-plan18-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          17. อัตราผู้ป่วยโรคความดันโลหิตสูงที่มีภาวะแทรกซ้อนหัวใจและหลอดเลือด  ',
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
                                                          18. อัตราผู้ป่วยโรคความดันโลหิตสูงที่มีภาวะแทรกซ้อนหลอดเลือดสมอง  ',
                                                          ['/service-plan/service-plan18-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          18. อัตราผู้ป่วยโรคความดันโลหิตสูงที่มีภาวะแทรกซ้อนหลอดเลือดสมอง  ',
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
                                                          19. อัตราผู้ป่วยโรคความดันโลหิตสูงที่มีภาวะแทรกซ้อนทางไต  ',
                                                          ['/service-plan/service-plan18-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          19. อัตราผู้ป่วยโรคความดันโลหิตสูงที่มีภาวะแทรกซ้อนทางไต  ',
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
                                                          20. อัตราผู้ป่วยโรคความดันโลหิตสูงที่สูบบุหรี่ซึ่งได้รับคำแนะนำปรึกษาให้เลิกสูบบุหรี่ ',
                                                          ['/service-plan/service-plan18-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          20. อัตราผู้ป่วยโรคความดันโลหิตสูงที่สูบบุหรี่ซึ่งได้รับคำแนะนำปรึกษาให้เลิกสูบบุหรี่ ',
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
                                                          21. อัตราผู้ป่วยเบาหวานที่มีระดับ Fasting Blood Sugar อยู่ในเกณฑ์ที่ควบคุมได้
                                                               (สูงกว่าหรือเท่ากับ 70 mgต่อdl และต่ำกว่าหรือเท่ากับ 130 mgต่อdl)  ',
                                                          ['/service-plan/service-plan17-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          21. อัตราผู้ป่วยเบาหวานที่มีระดับ Fasting Blood Sugar อยู่ในเกณฑ์ที่ควบคุมได้
                                                               (สูงกว่าหรือเท่ากับ 70 mgต่อdl และต่ำกว่าหรือเท่ากับ 130 mgต่อdl)  ',
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
                                                          22. อัตราการรับไว้รักษาในโรงพยาบาลเนื่องจากภาวะแทรกซ้อนเฉียบพลันจากโรคเบาหวาน
                                                               TZN005 อัตราผู้ป่วยโรคเบาหวานที่ได้รับการตรวจ Lipid profile ประจำาปี  ',
                                                          ['/service-plan/service-plan18-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          22. อัตราการรับไว้รักษาในโรงพยาบาลเนื่องจากภาวะแทรกซ้อนเฉียบพลันจากโรคเบาหวาน
                                                               TZN005 อัตราผู้ป่วยโรคเบาหวานที่ได้รับการตรวจ Lipid profile ประจำาปี  ',
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
                                                          23. อัตราผู้ป่วยโรคเบาหวานที่มีระดับ LDL ต่ำกว่า 100 mgต่อdl  TZN007 
                                                               อัตราระดับความดันโลหิตในผู้ป่วยเบาหวานที่มีระดับความดันโลหิตต่ำกว่า 
                                                               140ต่อ80 mmHg  ',
                                                          ['/service-plan/service-plan18-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          23. อัตราผู้ป่วยโรคเบาหวานที่มีระดับ LDL ต่ำกว่า 100 mgต่อdl  TZN007 
                                                               อัตราระดับความดันโลหิตในผู้ป่วยเบาหวานที่มีระดับความดันโลหิตต่ำกว่า 
                                                               140ต่อ80 mmHg  ',
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
                                                          24. อัตราผู้ป่วยโรคเบาหวานที่ได้รับการตรวจ Microalbuminuria ประจำปี  ',
                                                          ['/service-plan/service-plan18-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          24. อัตราผู้ป่วยโรคเบาหวานที่ได้รับการตรวจ Microalbuminuria ประจำปี  ',
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
                                                          25. อัตราผู้ป่วยโรคเบาหวานที่มี Microalbuminuria ที่ได้รับการรักษาด้วยยา 
                                                               ACE inhibitor หรือ ARB  ',
                                                          ['/service-plan/service-plan18-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          25. อัตราผู้ป่วยโรคเบาหวานที่มี Microalbuminuria ที่ได้รับการรักษาด้วยยา 
                                                               ACE inhibitor หรือ ARB  ',
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
                                                          26. อัตราผู้ป่วยโรคเบาหวานที่ได้รับการตรวจจอประสาทตาประจำปี  ',
                                                          ['/service-plan/service-plan18-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          26. อัตราผู้ป่วยโรคเบาหวานที่ได้รับการตรวจจอประสาทตาประจำปี  ',
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
                                                          27. อัตราผู้ป่วยโรคเบาหวานที่ได้รับการตรวจสุขภาพช่องปากประจำปี  ',
                                                          ['/service-plan/service-plan17-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          27. อัตราผู้ป่วยโรคเบาหวานที่ได้รับการตรวจสุขภาพช่องปากประจำปี  ',
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
                                                          28. อัตราผู้ป่วยโรคเบาหวานที่ได้รับการตรวจเท้าอย่างละเอียดประจำปี  ',
                                                          ['/service-plan/service-plan18-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          28. อัตราผู้ป่วยโรคเบาหวานที่ได้รับการตรวจเท้าอย่างละเอียดประจำปี  ',
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
                                                          29. อัตราผู้ป่วยโรคเบาหวานที่มีแผลที่เท้า  ',
                                                          ['/service-plan/service-plan18-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          29. อัตราผู้ป่วยโรคเบาหวานที่มีแผลที่เท้า  ',
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
                                                          30. อัตราผู้ป่วยโรคเบาหวานที่ได้รับการตัดนิ้วเท้า เท้า หรือขา  ',
                                                          ['/service-plan/service-plan18-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          30. อัตราผู้ป่วยโรคเบาหวานที่ได้รับการตัดนิ้วเท้า เท้า หรือขา  ',
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
                                                          31. อัตราผู้ป่วยโรคเบาหวานที่ได้รับการสอนให้ตรวจและดูเท้าด้วยตนเองหรือ 
                                                               สอนผู้ดูแล อย่างน้อย 1ครั้งต่อปี  ',
                                                          ['/service-plan/service-plan18-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          31. อัตราผู้ป่วยโรคเบาหวานที่ได้รับการสอนให้ตรวจและดูเท้าด้วยตนเองหรือ 
                                                               สอนผู้ดูแล อย่างน้อย 1ครั้งต่อปี  ',
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
                                                          32. อัตราผู้ป่วยโรคเบาหวานที่สูบบุหรี่ซึ่งได้รับคำาแนะนำาปรึกษาให้เลิกสูบบุหรี่  ',
                                                          ['/service-plan/service-plan18-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          32. อัตราผู้ป่วยโรคเบาหวานที่สูบบุหรี่ซึ่งได้รับคำาแนะนำาปรึกษาให้เลิกสูบบุหรี่  ',
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
                                                          33. อัตราผู้ป่วยโรคเบาหวานที่เป็น Diabetic Retinopathy  ',
                                                          ['/service-plan/service-plan17-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          33. อัตราผู้ป่วยโรคเบาหวานที่เป็น Diabetic Retinopathy  ',
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
                                                          34. อัตราผู้ป่วยเบาหวานที่เป็น Diabetic Nephropathy  ',
                                                          ['/service-plan/service-plan18-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          34. อัตราผู้ป่วยเบาหวานที่เป็น Diabetic Nephropathy  ',
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
                                                          35. อัตราผู้ป่วยโรคเบาหวานรายใหมจากกลุ่มเสี่ยง Impaired Fasting Glucose',
                                                          ['/service-plan/service-plan18-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          35. อัตราผู้ป่วยโรคเบาหวานรายใหมจากกลุ่มเสี่ยง Impaired Fasting Glucose',
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