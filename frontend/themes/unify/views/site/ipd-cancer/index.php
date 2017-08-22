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
            <li><?=Html::a($mText,['/ipd-cancer/index']);;?></li>
        </ul>
    </div>
</div>
<div class="margin-bottom-10"></div>       
<div class="row margin-left-5 margin-right-5">
    <div class="col-md-4">
        <img class="img-responsive margin-bottom-20" src="<?= $baseUrl ?>/assets/img/cancer.jpg"  alt="">
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
                                    <?=!Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานทะเบียนผู้ป่วยมะเร็งที่มารับบริการตามช่วงเวลาที่กำหนด',
                                                          ['/ipd-cancer/cancer1-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานทะเบียนผู้ป่วยมะเร็งที่มารับบริการตามช่วงเวลาที่กำหนด',
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
                                    <?=!Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2. รายงานทะเบียนผู้ป่วยมะเร็งรายใหม่(ผู้ป่วยนอก)',
                                                          ['/ipd-cancer/cancer2-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2. รายงานทะเบียนผู้ป่วยมะเร็งรายใหม่(ผู้ป่วยนอก)',
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
                                    <?=!Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          3. อัตราการนอนนานเกิน 45 วัน',
                                                          ['/ipd-cancer/cancer3-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          3. อัตราการนอนนานเกิน 45 วัน',
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
                                    <?=!Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          4. รายงานผู้ที่เสียชีวิตจากมะเร็ง (C00-C970)',
                                                          ['/ipd-cancer/cancer4-index']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          4. รายงานผู้ที่เสียชีวิตจากมะเร็ง (C00-C900)',
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