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
            <li><?=Html::a($mText,['/fund-aid/index']);;?></li>
        </ul>
    </div>
</div>
<div class="margin-bottom-10"></div>       
<div class="row margin-left-5 margin-right-5">
    <div class="col-md-4">
        <div id="myCarousel" class="carousel slide carousel-v1">
            <div class="carousel-inner">
                <div class="item">
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
                <div class="item active">
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
                                                          1. ร้อยละของผู้ติดเชื้อเอชไอวีได้รับการรักษาด้วยยาต้านไวรัส ',
                                                          ['/fund-aid/aid1-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. ร้อยละของผู้ติดเชื้อเอชไอวีได้รับการรักษาด้วยยาต้านไวรัส ',
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
                                                          2.ร้อยละของผู้ที่รับประทานยาต้านไวรัสที่สามารถควบคุมปริมาณไวรัสได้
                                                                 (Viral load น้อยกว่า 50 copiesต่อml) ณ สิ้นเดือนที่ 12 หลังเริ่มยาต้านไวรัส  ',
                                                          ['/fund-aid/aid2-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2.ร้อยละของผู้ที่รับประทานยาต้านไวรัสที่สามารถควบคุมปริมาณไวรัสได้
                                                                 (Viral load น้อยกว่า 50 copiesต่อml) ณ สิ้นเดือนที่ 12 หลังเริ่มยาต้านไวรัส  ',
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
                                                          3. จำนวนผู้ที่มีพฤติกรรมเสี่ยงที่ได้รับบริการให้คำาปรึกษาและตรวจหาการติดเชื้อเอชไอวี ',
                                                          ['/fund-aid/aid3-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          3. จำนวนผู้ที่มีพฤติกรรมเสี่ยงที่ได้รับบริการให้คำาปรึกษาและตรวจหาการติดเชื้อเอชไอวี ',
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
                                                          4. ร้อยละของผู้เริ่มรับประทานยาต้านไวรัสที่เป็นรายใหม่และมีระดับภูมิคุ้มกัน
                                                                 ขณะรับประทานยาอยู่ในระดับต่ำกว่า(CD4 น้อยกว่า 200 Cellต่อ mm3)  ',
                                                          ['/fund-aid/aid4-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          4. ร้อยละของผู้เริ่มรับประทานยาต้านไวรัสที่เป็นรายใหม่และมีระดับภูมิคุ้มกัน
                                                                 ขณะรับประทานยาอยู่ในระดับต่ำกว่า(CD4 น้อยกว่า 200 Cellต่อ mm3)  ',
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
                                                          5. ร้อยละของผู้ติดเชื้อเอชไอวีที่เสียชีวิตภายในปีแรกหลังเริ่มการรักษาด้วยยาต้านไวรัส',
                                                          ['/fund-aid/aid5-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          5. ร้อยละของผู้ติดเชื้อเอชไอวีที่เสียชีวิตภายในปีแรกหลังเริ่มการรักษาด้วยยาต้านไวรัส',
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
                                                          6. ร้อยละของผู้รับประทานยาต้านไวรัสที่ขาดการติดตามการรักษา  ',
                                                          ['/fund-aid/aid6-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          6. ร้อยละของผู้รับประทานยาต้านไวรัสที่ขาดการติดตามการรักษา  ',
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
                                                          7. จำนวนผู้ป่วยขึ้นทะเบียนรักษาวัณโรค  ',
                                                          ['/fund-aid/aid7-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          7. จำนวนผู้ป่วยขึ้นทะเบียนรักษาวัณโรค  ',
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
                                                          8. จำนวนผู้ป่วยวัณโรคดื้อยาหลายขนาน (MDR-TB)  ',
                                                          ['/fund-aid/aid8-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          8. จำนวนผู้ป่วยวัณโรคดื้อยาหลายขนาน (MDR-TB)  ',
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
                                                          9. จำนวนผู้ต้องขังได้รับการตรวจคัดกรองวัณโรคในเรือนจำ',
                                                          ['/fund-aid/aid9-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          9. จำนวนผู้ต้องขังได้รับการตรวจคัดกรองวัณโรคในเรือนจำ',
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
                                                          10. อัตราผลสำาเร็จของการรักษา (Success rate)  ',
                                                          ['/fund-aid/aid10-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          10. อัตราผลสำาเร็จของการรักษา (Success rate)  ',
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
                                                          11. อัตราการขาดการรักษา (Default rate)  ',
                                                          ['/fund-aid/aid11-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          11. อัตราการขาดการรักษา (Default rate)  ',
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
                                                          12. อัตราการเสียชีวิต (Death rate)',
                                                          ['/fund-aid/aid12-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          12. อัตราการเสียชีวิต (Death rate)',
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