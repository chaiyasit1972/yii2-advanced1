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
            <li><?=Html::a($mText,['/qof/index']);;?></li>
        </ul>
    </div>
</div>
<div class="margin-bottom-10"></div>       
<div class="row margin-left-5 margin-right-5">
    <div class="col-md-4">
        <div id="myCarousel" class="carousel slide carousel-v1">
            <div class="carousel-inner">
                <div class="item active">
                    <img src="<?= $baseUrl ?>/assets/img/qof1.jpg" alt="">
                </div>
                <div class="item">
                    <img src="<?= $baseUrl ?>/assets/img/qof2.jpg" alt="">
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
            <ul class="list-group sidebar-nav-v1 lists-v1 list-unstyled" id="sidebar-nav">                                 
                      <li class="list-group-item list-toggle">
                             <a data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse1" class="fa fa-arrow-right color-green">
                               <span class="h5">&nbsp;&nbsp;1 . ร้อยละผู้ได้รับการคัดกรองและวินิจฉัยเป็นเบาหวาน(สิทธิ์ประกันสุขภาพ)</span></a>
                                <ul id="collapse1" class="collapse">
                                   <li>
                                     <?=!Yii::$app->user->isGuest ?
                                           Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1.1  &nbsp;ร้อยละของประชากรไทยอายุ 35-74 ปี ได้รับการคัดกรองเบาหวาน
                                                                 โดยการตรวจวัด ระดับน้าตาลในเลือด(UC)',
                                                          ['qof/qof1-index']) :
                                           Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1.1  &nbsp;ร้อยละของประชากรไทยอายุ 35-74 ปี ได้รับการคัดกรองเบาหวาน
                                                                 โดยการตรวจวัด ระดับน้าตาลในเลือด(UC)',
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
                                     <?=!Yii::$app->user->isGuest ?
                                           Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1.2  &nbsp;ร้อยละของประชากรไทยอายุ 35-74 ปี ที่ได้รับการ
                                                                คัดกรองและวินิจฉัยเป็นเบาหวาน(UC)',
                                                          ['qof/qof2-index']) :
                                           Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1.2  &nbsp;ร้อยละของประชากรไทยอายุ 35-74 ปี ที่ได้รับการ
                                                                คัดกรองและวินิจฉัยเป็นเบาหวาน(UC)',
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
                             <a data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse2" class="fa fa-arrow-right color-green">
                               <span class="h5">&nbsp;&nbsp;2 . ร้อยละผู้ได้รับการคัดกรองและวินิจฉัยเป็นความดันโลหิตสูง(สิทธิ์ประกันสุขภาพ)</span></a>
                                <ul id="collapse2" class="collapse">
                                   <li>
                                     <?=!Yii::$app->user->isGuest ?
                                           Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2.1  &nbsp;ร้อยละของประชากรไทยอายุ 35-74ปี ได้รับการคัดกรองความดันโลหิตสูง (UC)',
                                                          ['qof/qof3-index']) :
                                           Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2.1  &nbsp;ร้อยละของประชากรไทยอายุ 35-74ปี ได้รับการคัดกรองความดันโลหิตสูง (UC)',
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
                                     <?=!Yii::$app->user->isGuest ?
                                           Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2.2  &nbsp;ร้อยละของประชากรไทยอายุ 35-74 ปี ที่ได้รับการคัดกรองและวินิจฉัยเป็น
                                                                ความดันโลหิตสูง (UC)',
                                                          ['qof/qof4-index']) :
                                           Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2.2  &nbsp;ร้อยละของประชากรไทยอายุ 35-74 ปี ที่ได้รับการคัดกรองและวินิจฉัยเป็น
                                                                ความดันโลหิตสูง (UC)',
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
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          3. ร้อยละของหญิงมีครรภ์ได้รับการฝากครรภ์ครั้งแรกภายใน 12 สัปดาห์',
                                                          ['qof/qof5-index']) :
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          3. ร้อยละของหญิงมีครรภ์ได้รับการฝากครรภ์ครั้งแรกภายใน 12 สัปดาห์',
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
                                                          4. ร้อยละสะสมความครอบคลุมการตรวจคัดกรองมะเร็งปากมดลูกในสตรี 30-60 ปี ภายใน 5 ปี',
                                                          ['qof/qof6-index']) :
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          4. ร้อยละสะสมความครอบคลุมการตรวจคัดกรองมะเร็งปากมดลูกในสตรี 30-60 ปี ภายใน 5 ปี',
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
                      <li class="list-group-item list-toggle">
                             <a data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse3" class="fa fa-arrow-right color-green">
                               <span class="h5">&nbsp;&nbsp;5 . ร้อยละการใช้ยาปฏิชีวนะอย่างรับผิดชอบในผู้ป่วยนอก</span></a>
                                <ul id="collapse3" class="collapse">                                 
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          5.1  &nbsp;ร้อยละการใช้ยาปฏิชีวนะในโรคอุจจาระร่วงเฉียบพลันในผู้ป่วยนอก
                                                                โรคอุจจาระร่วงเฉียบพลัน Acute Diarrhea (AD) ',
                                                          ['qof/qof7-index']) :
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          5.1  &nbsp; ร้อยละการใช้ยาปฏิชีวนะในโรคอุจจาระร่วงเฉียบพลันในผู้ป่วยนอก
                                                                โรคอุจจาระร่วงเฉียบพลัน Acute Diarrhea (AD) ',
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
                                                          5.2. ร้อยละการใช้ยาปฏิชีวนะในโรคอุจจาระร่วงเฉียบพลันในผู้ป่วยนอก
                                                                โรคติดเชื้อระบบทางเดินหายใจ Respiratory ',
                                                          ['qof/qof8-index']) :
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          5.2. ร้อยละการใช้ยาปฏิชีวนะในโรคอุจจาระร่วงเฉียบพลันในผู้ป่วยนอก
                                                                โรคติดเชื้อระบบทางเดินหายใจ Respiratory ',
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
                             <a data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse4" class="fa fa-arrow-right color-green">
                               <span class="h6">&nbsp;&nbsp;6 . การลดลงของอัตราการนอนโรงพยาบาลด้วยภาวะที่ควรควบคุมด้วยบริการผู้ป่วยนอก
                                                             (ACSC: ambulatory care sensitive condition) สิทธิ UC</span></a>
                                <ul id="collapse4" class="collapse">
                                   <li>
                                     <?=!Yii::$app->user->isGuest ?
                                           Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          6.1  &nbsp;ในโรคลมชัก (epilepsy) สิทธิ UC',
                                                          ['qof/qof9-index']) :
                                           Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          6.1  &nbsp;ในโรคลมชัก (epilepsy) สิทธิ UC',
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
                                     <?=!Yii::$app->user->isGuest ?
                                           Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          6.2  &nbsp;ในโรคปอดอุดกั้นเรื้อรัง (COPD) สิทธิ UC',
                                                          ['qof/qof10-index']) :
                                           Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          6.2  &nbsp;ในโรคปอดอุดกั้นเรื้อรัง (COPD) สิทธิ UC',
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
                                     <?=!Yii::$app->user->isGuest ?
                                           Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          6.3  &nbsp;ในโรคหืด (asthma) สิทธิ UC',
                                                          ['qof/qof11-index']) :
                                           Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          6.3  &nbsp;ในโรคหืด (asthma) สิทธิ UC',
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
                                     <?=!Yii::$app->user->isGuest ?
                                           Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          6.4  &nbsp;ในโรคเบาหวาน (DM) สิทธิ UC',
                                                          ['qof/qof12-index']) :
                                           Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          6.4  &nbsp;ในโรคเบาหวาน (DM) สิทธิ UC',
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
                                     <?=!Yii::$app->user->isGuest ?
                                           Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          6.5  &nbsp;ในโรคความดันโลหิตสูง (HT) สิทธิ UC',
                                                          ['qof/qof13-index']) :
                                           Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          6.5  &nbsp;ในโรคความดันโลหิตสูง (HT) สิทธิ UC',
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
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          7. &nbsp;เด็กสงสัยพัฒนาการล่าช้าได้รับการตรวจกระตุ้นพัฒนาการ',
                                                          ['qof/qof14-index']) :
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          7. &nbsp;เด็กสงสัยพัฒนาการล่าช้าได้รับการตรวจกระตุ้นพัฒนาการ',
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
                                                          8. ร้อยละของเด็กนักเรียนมีภาวะเริ่มอ้วนและอ้วน',
                                                          ['qof/qof15-index']) :
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          8. ร้อยละของเด็กนักเรียนมีภาวะเริ่มอ้วนและอ้วน',
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
                                                          9. ร้อยละการตั้งครรภ์ซ้ำในหญิงอายุน้อยกว่า 20 ปี',
                                                          ['qof/qof16-index']) :
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          9. ร้อยละการตั้งครรภ์ซ้ำในหญิงอายุน้อยกว่า 20 ปี',
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
                                                          10. ร้อยละผู้สูงอายุที่มีภาวะพึ่งพิง(ติดเตียง) และกลุ่มเป้า หมายที่ส้าคัญ
                                                               ได้รับการดูแลต่อเนื่องที่บ้าน โดยทีมหมอ ครอบครัวระดับต้าบล ',
                                                          ['qof/qof17-index']) :
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          10. ร้อยละผู้สูงอายุที่มีภาวะพึ่งพิง(ติดเตียง) และกลุ่มเป้า หมายที่ส้าคัญ
                                                               ได้รับการดูแลต่อเนื่องที่บ้าน โดยทีมหมอ ครอบครัวระดับต้าบล ',
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
                                                          11. อัตราป่วยโรคไข้เลือดออกลดลง',
                                                          ['qof/qof18-index']) :
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          11. อัตราป่วยโรคไข้เลือดออกลดลง',
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