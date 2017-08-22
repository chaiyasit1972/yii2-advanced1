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
        <h4 class="pull-left">งานผู้ป่วยโรคเรื้อรัง(NCD)</h4>
        <ul class="pull-right breadcrumb">
            <li><?=Html::a('Home',['/site/index']);?></li>
            <li><?=Html::a($mText,['/ncd-clinic/index']);;?></li>
        </ul>
    </div>
</div>
<div class="margin-bottom-10"></div>       
<div class="row margin-left-5 margin-right-5">
    <div class="col-md-4">
       <div id="myCarousel" class="carousel slide carousel-v1">
            <div class="carousel-inner">
                <div class="item active">
                    <img src="<?= $baseUrl ?>/assets/img/ncd1.jpg" alt="">
                </div>
                <div class="item">
                    <img src="<?= $baseUrl ?>/assets/img/ncd2.jpg" alt="">
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
                                                          1. รายงานสภาวะผู้ป่วยโรคเรื้อรัง ',
                                                          ['/ncd-clinic1/clinic1-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานสภาวะผู้ป่วยโรคเรื้อรัง ',
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
                                                          2. ทะเบียนรายชื่อผู้ป่วยคลิกนิกโรคเรื้อรัง',
                                                          ['/ncd-clinic1/clinic2-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2. ทะเบียนรายชื่อผู้ป่วยคลิกนิกโรคเรื้อรัง',
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
                                                          3. รายงานผู้ป่วยโรคเรื้อรัง ที่ยังไม่เข้าคลินิก',
                                                          ['/ncd-clinic1/clinic3-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          3. รายงานผู้ป่วยโรคเรื้อรัง ที่ยังไม่เข้าคลินิก',
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
                                                          4. รายงานการประเมินโอกาสเสี่ยง(CVD) ทราบผลคลอเรตเตอรอล',
                                                          ['/ncd-clinic1/clinic4-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          4. รายงานการประเมินโอกาสเสี่ยง(CVD) ทราบผลคลอเรตเตอรอล',
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
                                                          5. รายงานการประเมินโอกาสเสี่ยง(CVD) ไม่ทราบผลคลอเรตเตอรอล',
                                                          ['/ncd-clinic1/clinic5-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          5. รายงานการประเมินโอกาสเสี่ยง(CVD) ไม่ทราบผลคลอเรตเตอรอล',
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
                                                          6. รายงานผลการดำเนินงานผู้ป่วยโรคเรื้อรัง(อิงบัญชี 1)',
                                                          ['/ncd-clinic1/clinic6-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          6. รายงานผลการดำเนินงานผู้ป่วยโรคเรื้อรัง(อิงบัญชี 1)',
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
                                                          7. รายงานผลการดำเนินงานผู้ป่วยโรคเรื้อรัง(ไม่อิงบัญชี 1)',
                                                          ['/ncd-clinic1/clinic7-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          7. รายงานผลการดำเนินงานผู้ป่วยโรคเรื้อรัง(ไม่อิงบัญชี 1)',
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
                                                          8. รายงานคัดกรองกลุ่มเสี่ยงโรคเรื้อรัง(DM/HT/Stroke/Obesity)',
                                                          ['/ncd-clinic2/clinic8-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          8. รายงานคัดกรองกลุ่มเสี่ยงโรคเรื้อรัง(DM/HT/Stroke/Obesity)',
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
                                                          9. รายงานสรุปผลการคัดกรอง(ภาวะแทรกซ้อน โรคหลอดเลือดสมอง)',
                                                          ['/ncd-clinic2/clinic9-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          9. รายงานสรุปผลการคัดกรอง(ภาวะแทรกซ้อน โรคหลอดเลือดสมอง)',
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
                                                          10. รายงานคัดกรองภาวะแทรงซ้อนทางไต (GFR) ',
                                                          ['/ncd-clinic2/clinic10-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          10. รายงานคัดกรองภาวะแทรงซ้อนทางไต (GFR) ',
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
                                                          11. รายงาน BSA ผู้ป่วยไต',
                                                          ['/ncd-clinic2/clinic11-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          11. รายงาน BSA ผู้ป่วยไต',
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
                                                          12. รายงานคัดกรองภาวะแทรกซ้อนทางตา(เบาหวาน)',
                                                          ['/ncd-clinic2/clinic12-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          12. รายงานคัดกรองภาวะแทรกซ้อนทางตา(เบาหวาน)',
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
                                                          13. รายงานสรุปโรคเรื้อรัง(ผล Lab) ตรวจครั้งล่าสุด',
                                                          ['/ncd-clinic2/clinic13-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          13. รายงานสรุปโรคเรื้อรัง(ผล Lab) ตรวจครั้งล่าสุด',
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
                                                          14. รายงานผู้ป่วยเบาหวานตรวจ HB A1C',
                                                          ['/ncd-clinic2/clinic14-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          14. รายงานผู้ป่วยเบาหวานตรวจ HB A1C',
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
                                                          15. รายงานอัตราการรับไว้รักษา(Admission Rate) ด้วยโรคไม่ติดต่อเรื้อรังที่มีภาวะแทรกซ้อน สิทธิ UC',
                                                          ['/ncd-clinic2/clinic15-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          15. รายงานอัตราการรับไว้รักษา(Admission Rate) ด้วยโรคไม่ติดต่อเรื้อรังที่มีภาวะแทรกซ้อน สิทธิ UC',
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
                                                          16. รายงานการลดลงของอัตราการนอน รพ. ด้วยภาวะที่ควรควบคุมด้วยบริการผู้ป่วยนอก(ACSC) ใน
                                                                โรค epilepsy,copd,asthma,dm,ht ',
                                                          ['/ncd-clinic2/clinic16-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          16. รายงานการลดลงของอัตราการนอน รพ. ด้วยภาวะที่ควรควบคุมด้วยบริการผู้ป่วยนอก(ACSC) ใน
                                                                โรค epilepsy,copd,asthma,dm,ht',
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
                                                          17. รายงานคัดกรองภาวะแทรกซ้อนทางเท้า(เบาหวาน)',
                                                          ['/ncd-clinic2/clinic17-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          17. รายงานคัดกรองภาวะแทรกซ้อนทางเท้า(เบาหวาน)',
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
                                                          18. รายงานผู้ป่วยเบาหวานชนิดที่ 1 E10.0 - E10.9 (Type I) ',
                                                          ['/ncd-clinic2/clinic18-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          18. รายงานผู้ป่วยเบาหวานชนิดที่ 1 E10.0 - E10.9 (Type I) ',
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
<div class="margin-bottom-100"></div>&nbsp;<div class="margin-bottom-90"></div>