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
            <li><?=Html::a($mText,['/phar-out/index']);;?></li>
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
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2. รายงานผู้ป่วยใช้ยา&nbsp;Clopidogrel&nbsp;(เฉพาะสิทธิ์ UC)  ',
                                                          ['/phar-out/phar-out2-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2. รายงานผู้ป่วยใช้ยา&nbsp;Clopidogrel&nbsp;(เฉพาะสิทธิ์ UC)  ',
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
                                                          3. รายงาน ASU',
                                                          ['/phar-out/phar-out3-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          3. รายงาน ASU',
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
                                                          4. รายงานผู้ป่วยที่ได้รับยา TB',
                                                          ['/phar-out/phar-out4-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          4. รายงานผู้ป่วยที่ได้รับยา T',
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
                                                          5. รายงานผู้ป่วยที่ได้รับยา Warfarin แยกราย รพ.สต.',
                                                          ['/phar-out/phar-out5-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          5. รายงานผู้ป่วยที่ได้รับยา Warfarin แยกราย รพ.สต.',
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
                                                          6. รายงานยาราคาสูงแจ้งคลังยา',
                                                          ['/phar-out/phar-out6-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          6. รายงานยาราคาสูงแจ้งคลังยา',
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
                             <span class='h5 margin-left-10'>คลิกเลือกรายงานตัวชี้วัด RDU</span>                             
                         </a>   
                             <ul id="collapse2" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. ร้อยละการใช้ยาปฎิชีวนะในโรคติดเชื้อที่ระบบหายใจช่วงบน
                                                                 และหลอดลมอักเสบเฉียบพลันผู้ป่วยนอก',
                                                          ['/phar-out/phar-out-kpi1-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                           1. ร้อยละการใช้ยาปฎิชีวนะในโรคติดเชื้อที่ระบบหายใจช่วงบน
                                                                 และหลอดลมอักเสบเฉียบพลันผู้ป่วยนอก',
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
                                                          2. ร้อยละการใช้ยาปฎิชีวนะในโรคอุจาระร่วงเสบเฉียบพลัน',
                                                          ['/phar-out/phar-out-kpi2-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2. ร้อยละการใช้ยาปฎิชีวนะในโรคอุจาระร่วงเสบเฉียบพลัน',
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
                                                          3. อัตราการใช้ยาปฎิชีวนะในบาดแผลสดจากอุบัติเหตุ',
                                                          ['/phar-out/phar-out-kpi3-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          3. อัตราการใช้ยาปฎิชีวนะในบาดแผลสดจากอุบัติเหตุ',
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
                                                          4. อัตราการใช้ยาปฎิชีวนะในหญิงคลอดปกติครบกำหนดทางช่องคลอด',
                                                          ['/phar-out/phar-out-kpi4-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          4. อัตราการใช้ยาปฎิชีวนะในหญิงคลอดปกติครบกำหนดทางช่องคลอด',
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
                                                          5. ร้อยละของการใช้ RAS blockade (ACEL/ARB/Renin inhibitor) 2 ชนิดรวมกัน
                                                                 ในการรักษาความดันเลือดสูง',
                                                          ['/phar-out/phar-out-kpi5-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          5. ร้อยละของการใช้ RAS blockade (ACEL/ARB/Renin inhibitor) 2 ชนิดรวมกัน
                                                                 ในการรักษาความดันเลือดสูง',
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
                                                          6. ร้อยละของการใช้ glibenclamide ในผู้ป่วยที่มีอายุมากกว่า 65 ปี 
                                                                 หรือมี eGFR < 60 มล./นาที/1.73 ตรม. ',
                                                          ['/phar-out/phar-out-kpi6-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          6. ร้อยละของการใช้ glibenclamide ในผู้ป่วยที่มีอายุมากกว่า 65 ปี 
                                                                 หรือมี eGFR < 60 มล./นาที/1.73 ตรม. ',
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
                                                          7. ร้อยละของผู้ป่วยเบาหวานที่ใช้ยา metformin เป็นยาชนิดเดียวกันหรือร่วมกับยาอื่น 
                                                                 เพื่อควบคุมระดับน้ำตาล โดยไม่มีข้อห้ามใช้',
                                                          ['/phar-out/phar-out-kpi7-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          7. ร้อยละของผู้ป่วยเบาหวานที่ใช้ยา metformin เป็นยาชนิดเดียวกันหรือร่วมกับยาอื่น 
                                                                 เพื่อควบคุมระดับน้ำตาล โดยไม่มีข้อห้ามใช้',
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
                                                          8. ร้อยละของผู้ป่วยที่มีการใช้ยากลุ่ม NSAIDs ซ้ำซ้อน',
                                                          ['/phar-out/phar-out-kpi8-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          8. ร้อยละของผู้ป่วยที่มีการใช้ยากลุ่ม NSAIDs ซ้ำซ้อน',
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
                                                          9. ร้อยละของผู้ป่วยโรคไตเรื้อรังระดับ 3 ขึ้นไปที่ได้รับยา NSAIDs',
                                                          ['/phar-out/phar-out-kpi9-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          9. ร้อยละของผู้ป่วยโรคไตเรื้อรังระดับ 3 ขึ้นไปที่ได้รับยา NSAIDs',
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
                                                          10. ร้อยละของผู้ป่วยโรคหืดเรื้อรังที่ได้รับยา inhaled corticosteroid',
                                                          ['/phar-out/phar-out-kpi10-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          10. ร้อยละของผู้ป่วยโรคหืดเรื้อรังที่ได้รับยา inhaled corticosteroid',
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
                                                          11. ร้อยละผู้ป่วยนอกสูงอายุ(เกิน 65 ปี) ที่ใช้ยากลุ่ม long-acting benzodiazepine',
                                                          ['/phar-out/phar-out-kpi11-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          11. ร้อยละผู้ป่วยนอกสูงอายุ(เกิน 65 ปี) ที่ใช้ยากลุ่ม long-acting benzodiazepine',
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
                                                          12. จำนวนสตรีตั้งครรภ์ที่ได้รับยาที่ควรหลีกเลี่ยง ได้แก่ Warfarin/Statins/Ergot',
                                                          ['/phar-out/phar-out-kpi12-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          12. จำนวนสตรีตั้งครรภ์ที่ได้รับยาที่ควรหลีกเลี่ยง ได้แก่ Warfarin/Statins/Ergot',
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
                                                          13. อัตราการได้รับยาต้านฮีสตามีนชนิด non-sedating* 
                                                                 ในเด็กที่ได้รับการวินิจฉัยเป็นโรคติดเชื้อของทางเดินหายใจ',
                                                          ['/phar-out/phar-out-kpi13-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          13. อัตราการได้รับยาต้านฮีสตามีนชนิด non-sedating* 
                                                                 ในเด็กที่ได้รับการวินิจฉัยเป็นโรคติดเชื้อของทางเดินหายใจ',
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
                                                          14. ต้นทุนค่ายาผู้ป่วยนอกต่อผู้ป่วย OPD Visit',
                                                          ['/phar-out/phar-out-kpi14-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          14. ต้นทุนค่ายาผู้ป่วยนอกต่อผู้ป่วย OPD Visit',
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
                                                          15. ต้นทุนค่ายาผู้ป่วยในต่อผลรวม Adj.Rw',
                                                          ['/phar-out/phar-out-kpi15-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          15. ต้นทุนค่ายาผู้ป่วยในต่อผลรวม Adj.Rw',
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
                                                          16. รายงานร้อยละการสั่งยาในบัญชียาหลักแห่งชาติ',
                                                          ['/phar-out/phar-out-kpi16-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          16. รายงานร้อยละการสั่งยาในบัญชียาหลักแห่งชาติ',
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