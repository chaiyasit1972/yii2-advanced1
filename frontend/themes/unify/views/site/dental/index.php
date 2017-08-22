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
            <li><?=Html::a($mText,['/dental/index']);;?></li>
        </ul>
    </div>
</div>
<div class="margin-bottom-10"></div>       
<div class="row margin-left-5 margin-right-5">
    <div class="col-md-4">
        <div id="myCarousel" class="carousel slide carousel-v1">
            <div class="carousel-inner">
                <div class="item">
                    <img src="<?= $baseUrl ?>/assets/img/den1.jpg" alt="">
                </div>
                <div class="item">
                    <img src="<?= $baseUrl ?>/assets/img/den2.jpg" alt="">
                </div>
                <div class="item active">
                    <img src="<?= $baseUrl ?>/assets/img/den3.jpg" alt="">
                </div>
                <div class="item">
                    <img src="<?= $baseUrl ?>/assets/img/den4.jpg" alt="">
                </div>  
                <div class="item">
                    <img src="<?= $baseUrl ?>/assets/img/den5.jpg" alt="">
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
                          <a class="btn-u btn-u-purple" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse1">
                             <span class='h5 margin-left-10'>คลิกเลือกรายงาน !!</span>                             
                         </a>   
                             <ul id="collapse1" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานตรวจสุขภาพช่องปาก(dental care)',
                                                          ['/dental/dental1-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานตรวจสุขภาพช่องปาก(dental care)',
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
                                                          2. หญิงมีครรภ์ได้รับการตรวจสุขภาพช่องปากไม่น้อยกว่าร้อยละ 90 
                                                          (คนที่คลอดในช่วง)(kpi 1.1)',
                                                          ['/dental/dental2-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2. หญิงมีครรภ์ได้รับการตรวจสุขภาพช่องปากไม่น้อยกว่าร้อยละ 90 
                                                          (คนที่คลอดในช่วง)(kpi 1.1)',
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
                                                          3. หญิงมีครรภ์ได้รับการตรวจสุขภาพช่องปากไม่น้อยกว่าร้อยละ 90
                                                          (คนตั้งครรภ์ที่ LMP ในช่วง) (kpi 1.1.1)',
                                                          ['/dental/dental3-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          3. หญิงมีครรภ์ได้รับการตรวจสุขภาพช่องปากไม่น้อยกว่าร้อยละ 90
                                                          (คนตั้งครรภ์ที่ LMP ในช่วง) (kpi 1.1.1)',
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
                                                          4. เด็กต่ำกว่า 3 ปี ได้รับการตรวจสุขภาพช่องปาก
                                                          ไม่น้อยกว่าร้อยละ 80(kpi 1.2)',
                                                          ['/dental/dental4-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          4. เด็กต่ำกว่า 3 ปี ได้รับการตรวจสุขภาพช่องปาก
                                                          ไม่น้อยกว่าร้อยละ 80(kpi 1.2)',
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
                                                          5. เด็กต่ำกว่า 3 ปี ได้รับการฝึกทักษะการแปรงฟัน 
                                                          ไม่น้อยกว่าร้อยละ 80(kpi 1.3)',
                                                          ['/dental/dental5-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          5. เด็กต่ำกว่า 3 ปี ได้รับการฝึกทักษะการแปรงฟัน 
                                                          ไม่น้อยกว่าร้อยละ 80(kpi 1.3)',
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
                                                          6. เด็กต่ำกว่า 3 ปี ได้รับฟลูออไรด์ไม่น้อยกว่าร้อยละ 50(kpi 1.4)',
                                                          ['/dental/dental6-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          6. เด็กต่ำกว่า 3 ปี ได้รับฟลูออไรด์ไม่น้อยกว่าร้อยละ 50(kpi 1.4)',
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
                                                          7. เด็กนักเรียน ป. 1 ได้รับการตรวจสุขภาพช่องปาก
                                                          ไม่น้อยกว่าร้อยละ 90(kpi 2.1)',
                                                          ['/dental/dental7-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          7. เด็กนักเรียน ป. 1 ได้รับการตรวจสุขภาพช่องปาก
                                                          ไม่น้อยกว่าร้อยละ 90(kpi 2.1)',
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
                                                          8. เด็กนักเรียน ป. 1 ได้รับการเคลือบปิดหลุมร่องฟันไม่น้อยกว่าร้อยละ
                                                          50(kpi 2.2)',
                                                          ['/dental/dental8-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          8. เด็กนักเรียน ป. 1 ได้รับการเคลือบปิดหลุมร่องฟันไม่น้อยกว่าร้อยละ
                                                          50(kpi 2.2)',
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
                                                          9. รายงานเด็ก ป.1-6 (อายุ 6-12 ปี) ได้รับบริการทันตกรรม(kpi 2.3)',
                                                          ['/dental/dental9-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          9. รายงานเด็ก ป.1-6 (อายุ 6-12 ปี) ได้รับบริการทันตกรรม(kpi 2.3)',
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
                                                          10. ร้อยละเด็กนักเรียน ป.1 และ ป.6 ที่ได้รับบริการทันตกรรม(kpi 2.4)',
                                                          ['/dental/dental10-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          10. ร้อยละเด็กนักเรียน ป.1 และ ป.6 ที่ได้รับบริการทันตกรรม(kpi 2.4)',
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
                                                          11. ประชาชนได้รับบริการทางทันตกรรม(คน)ไม่น้อยกว่าร้อยละ 20(kpi 3.1)',
                                                          ['/dental/dental11-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          11. ประชาชนได้รับบริการทางทันตกรรม(คน)ไม่น้อยกว่าร้อยละ 20(kpi 3.1)',
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
                                                          12. ประชาชนได้รับบริการทางทันตกรรม(ครั้ง)ไม่น้อยกว่าร้อยละ 20(kpi 3.2)',
                                                          ['/dental/dental12-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          12. ประชาชนได้รับบริการทางทันตกรรม(ครั้ง)ไม่น้อยกว่าร้อยละ 20(kpi 3.2)',
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
                                                          13. ผู้สูงอายุได้รับการตรวจคัดกรองสุขภาพช่องปากไม่น้อยกว่าร้อยละ 50(kpi 4.1)',
                                                          ['/dental/dental13-index'])  : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          13. ผู้สูงอายุได้รับการตรวจคัดกรองสุขภาพช่องปากไม่น้อยกว่าร้อยละ 50(kpi 4.1)',
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
                                                          14. ผู้สูงอายุที่มีสภาวะการเกิดโรคเบาหวานและความดันได้รับการ
                                                               คัดกรองสุขภาพช่องปากไม่น้อยกว่าร้อยละ 50(kpi 4.2)',
                                                          ['/dental/dental14-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          14. ผู้สูงอายุที่มีสภาวะการเกิดโรคเบาหวานและความดันได้รับการ
                                                               คัดกรองสุขภาพช่องปากไม่น้อยกว่าร้อยละ 50(kpi 4.2)',
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
                                                          15. รายงานบริการทันตกรรม แยกตามกลุ่มกิจกรรมบริการ',
                                                          ['/dental/dental15-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          15. รายงานบริการทันตกรรม แยกตามกลุ่มกิจกรรมบริการ',
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
                                                          16. รายงานมะเร็งช่องปาก แยก(ทั้งหมด/ในอำเภอ)',
                                                          ['/dental/dental16-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          16. รายงานมะเร็งช่องปาก แยก(ทั้งหมด/ในอำเภอ)',
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
                                                          17. รายงานภาระงาน (FTE) สำหรับทันตแพทย์',
                                                          ['/dental/dental17-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          17. รายงานภาระงาน (FTE) สำหรับทันตแพทย์',
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
<div class="margin-bottom-50"></div>