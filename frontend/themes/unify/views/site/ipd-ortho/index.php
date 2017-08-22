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
        <h4 class="pull-left">งานศัลยกรรมกระดูก(อาคาร 4 ชั้น 1)</h4>
        <ul class="pull-right breadcrumb">
            <li><?=Html::a('Home',['/site/index']);?></li>
            <li><?=Html::a($mText,['/ipd-ortho/index']);;?></li>
        </ul>
    </div>
</div>
<div class="margin-bottom-10"></div>       
<div class="row margin-left-5 margin-right-5">
    <div class="col-md-4">
       <div id="myCarousel" class="carousel slide carousel-v1">
            <div class="carousel-inner">
                <div class="item active">
                    <img src="<?= $baseUrl ?>/assets/img/sur1.jpg" alt="">
                </div>
                <div class="item">
                    <img src="<?= $baseUrl ?>/assets/img/sur2.jpg" alt="">
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
                <!-- Typography -->
                <li class="list-group-item list-toggle">
                    <a data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse1">1. งานศัลยกรรมกระดูก(ผู้ป่วยนอก) </a>
                    <ul id="collapse1" class="collapse">
                        <li>
                             <?= !Yii::$app->user->isGuest?
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.1 รายงานผู้ป่วยนอกแผนกศัลยกรรมกระดูก',
                                                                         ['ipd-ortho-opd/opd1-index'])  :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.1 รายงานผู้ป่วยนอกแผนกศัลยกรรมกระดูก',
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
                                                                         1.2 &nbsp;รายงาน 5 อันดับโรคแรก',
                                                                         ['ipd-ortho-opd/opd2-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.2 &nbsp;รายงาน 5 อันดับโรคแรก',
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
                                                                         1.3 &nbsp;รายงาน 10 อันดับการส่งต่อแผนกศัลยกรรมกระดูก',
                                                                         ['ipd-ortho-opd/opd3-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.3 &nbsp;รายงาน 10 อันดับการส่งต่อแผนกศัลยกรรมกระดูก',
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
                                                                         1.4 &nbsp;รายงาน simple fracture จำหน่ายกลับบ้าน',
                                                                         ['ipd-ortho-opd/opd4-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.4 &nbsp;รายงาน simple fracture จำหน่ายกลับบ้าน',
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
                                                                        1.5 &nbsp;รายงาน Non displace fracture จำหน่ายกลับบ้าน',
                                                                         ['ipd-ortho-opd/opd5-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.5 &nbsp;รายงาน Non displace fracture จำหน่ายกลับบ้าน',
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
                                                                         1.6 &nbsp;รายงาน CF OPD เกิดจากอุบัติเหตุ จำหน่ายกลับบ้าน',
                                                                         ['ipd-ortho-opd/opd6-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.6 &nbsp;รายงาน CF OPD เกิดจากอุบัติเหตุ จำหน่ายกลับบ้าน',
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
                <!-- End Typography -->

                <!-- Buttons UI -->
                <li class="list-group-item list-toggle">
                    <a data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse2">2. งานศัลยกรรมกระดูก(ผู้ป่วยใน)</a>
                    <ul id="collapse2" class="collapse">
                        <li>
                             <?= !Yii::$app->user->isGuest?
                                                           Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.1 รายงานปริมาณผู้ป่วยในแผนกศัลยกรรมกระดูก',
                                                                         ['ipd-ortho-ipd/ipd1-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.1 รายงานปริมาณผู้ป่วยในแผนกศัลยกรรมกระดูก',
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
                                                                         2.2 รายงานการส่งต่อแผนกศัลยกรรมกระดูก',
                                                                         ['ipd-ortho-ipd/ipd2-index']) : 
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.2 รายงานการส่งต่อแผนกศัลยกรรมกระดูก',
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
                                                                         2.3 รายงานการรับการส่งต่อแผนกศัลยกรรมกระดูก',
                                                                         ['ipd-ortho-ipd/ipd3-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.3 รายงานการรับการส่งต่อแผนกศัลยกรรมกระดูก',
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
                                                                         2.4 รายงานศัลยกรรมกระดูก(simple fracture)',
                                                                         ['ipd-ortho-ipd/ipd4-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.4 รายงานศัลยกรรมกระดูก(simple fracture)',
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
                             <?=  !Yii::$app->user->isGuest?
                                                           Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.5 รายงานรับ Referin Admit Adjrw < 0.5',
                                                                         ['ipd-ortho-ipd/ipd5-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.5 รายงานรับ Referin Admit Adjrw < 0.5',
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
                                                                         2.6 รายงานส่ง Referout Admit Adjrw < 0.5',
                                                                         ['ipd-ortho-ipd/ipd6-index']):
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.6 รายงานส่ง Referout Admit Adjrw < 0.5',
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
                                                                         2.7 รายงานรับ Referin Simple Fracture',
                                                                         ['ipd-ortho-ipd/ipd7-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.7 รายงานรับ Referin Simple Fracture',
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
                                                                         2.8 รายงาน Non displace fracture เกิดจากอุบัติเหตุ ไม่ได้ผ่าตัด',
                                                                         ['ipd-ortho-ipd/ipd8-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.8 รายงาน Non displace fracture เกิดจากอุบัติเหตุ ไม่ได้ผ่าตัด',
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
                                                                         2.9 รายงาน CF IPD เกิดจากอุบัติเหตุ ไม่ได้ผ่าตัด',
                                                                         ['ipd-ortho-ipd/ipd9-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.9 รายงาน CF IPD เกิดจากอุบัติเหตุ ไม่ได้ผ่าตัด',
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
                <!-- End Buttons UI -->
                <!-- Components -->
                <li class="list-group-item list-toggle">
                    <a class="accordion-toggle" href="#collapse3" data-toggle="collapse">3. งานศัลยกรรมกระดูก(รายงานตัวชีวัด & Service Plan)</a>
                    <ul id="collapse3" class="collapse">
                        <li>
                             <?= !Yii::$app->user->isGuest?
                                                           Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         3.1 อัตราการผ่าตัดภายใน 4 ช.ม.(open fracture long bone)',
                                                                         ['ipd-ortho-kpi/kpi1-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         3.1 อัตราการผ่าตัดภายใน 4 ช.ม.(open fracture long bone)',
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
                                                                         3.2 รายงานร้อยละของการดูแลรักษาของผู้ป่วยที่มีกระดูกหักไม่ซับซ้อน',
                                                                         ['ipd-ortho-kpi/kpi2-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         3.2 รายงานร้อยละของการดูแลรักษาของผู้ป่วยที่มีกระดูกหักไม่ซับซ้อน',
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
                                                                         3.3 รายงานสาเหตุการตายสูงสุด(แยก ทั้งหมด/รายโรค)',
                                                                         ['ipd-ortho-kpi/kpi3-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         3.3 รายงานสาเหตุการตายสูงสุด(แยก ทั้งหมด/รายโรค)',
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
                <!-- End Components -->
                <!-- Timeline -->
                <li class="list-group-item list-toggle">
                    <a class="accordion-toggle" href="#collapse4" data-toggle="collapse">4. งานศัลยกรรมกระดูก(โรคที่สนใจ)</a>
                    <ul id="collapse4" class="collapse">
                        <li>
                             <?= !Yii::$app->user->isGuest?
                                                           Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.1 ข้อเสื่อม(Arthosis)-Polyarthosis',
                                                                         ['ipd-ortho-pct/pct1-index']) : 
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.1 ข้อเสื่อม(Arthosis)-Polyarthosis',
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
                                                                         4.2 ข้อเสื่อม(Arthosis)-gonathrosis',
                                                                         ['ipd-ortho-pct/pct2-index']) : 
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.2 ข้อเสื่อม(Arthosis)-gonathrosis',
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
                                                                         4.3 ข้อเสื่อม(Arthosis)-arthrosis of hip',
                                                                         ['ipd-ortho-pct/pct3-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.3 ข้อเสื่อม(Arthosis)-arthrosis of hip',
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
                                                                         4.4 (spine discease)-spondylolysis',
                                                                         ['ipd-ortho-pct/pct4-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.4 (spine discease)-spondylolysis',
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
                                                                         4.5 (spine discease)-spondylopathies',
                                                                         ['ipd-ortho-pct/pct5-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.5 (spine discease)-spondylopathies',
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
                                                                         4.6 (spine discease)-spondylosis',
                                                                         ['ipd-ortho-pct/pct6-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.6 (spine discease)-spondylosis',
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
                                                                         4.7 (spine discease)-stenosis',
                                                                         ['ipd-ortho-pct/pct7-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.7 (spine discease)-stenosis',
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
                                                                         4.8 spinal injury',
                                                                         ['ipd-ortho-pct/pct8-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.8 spinal injury',
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
                                                                         4.9 fracture around hips',
                                                                         ['ipd-ortho-pct/pct9-index']) :                                                       
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.9 fracture around hips',
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
                                                                         4.10 (closed fracture long bone)-closed fracture femur ',
                                                                         ['ipd-ortho-pct/pct10-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.10 (closed fracture long bone)-closed fracture femur ',
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
                                                                         4.11 (Closed fracture long bone)-Closed fracture tibia ',
                                                                         ['ipd-ortho-pct/pct11-index']) : 
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.11 (Closed fracture long bone)-Closed fracture tibia ',
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
                                                                         4.12 (Closed fracture long bone)-Closed fracture forarm',
                                                                         ['ipd-ortho-pct/pct12-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.12 (Closed fracture long bone)-Closed fracture forarm',
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
                                                                         4.13 (Closed fracture long bone)-Closed fracture hemerus',
                                                                         ['ipd-ortho-pct/pct13-index']) : 
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.13 (Closed fracture long bone)-Closed fracture hemerus',
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
                                                                         4.14 (Open fracture long bone)-Open fracture femur ',
                                                                         ['ipd-ortho-pct/pct14-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.14 (Open fracture long bone)-Open fracture femur ',
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
                                                                         4.15 (Open fracture long bone)-Open fracture tibia',
                                                                         ['ipd-ortho-pct/pct15-index']) : 
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.15 (Open fracture long bone)-Oopen fracture tibia',
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
                                                                         4.16 (Open fracture long bone)-Open fracture forarm',
                                                                         ['ipd-ortho-pct/pct16-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.16 (Open fracture long bone)-Open fracture forarm',
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
                                                                         4.17 (Open fracture long bone)-Open fracture hemerus',
                                                                         ['ipd-ortho-pct/pct17-index']) :
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.17 (Open fracture long bone)-Open fracture hemerus',
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
                <!-- End Timeline -->
            </ul>              
        </div>
        <!-- End Standard Form Controls -->
    </div>
    <!-- End Content -->
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