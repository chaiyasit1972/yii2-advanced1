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
        <h4 class="pull-left"><?=$mText;?></h4>
        <ul class="pull-right breadcrumb">
            <li><?=Html::a('Home',['/site/index']);?></li>
            <li><?=Html::a($names,['/service/index1']);;?></li>
        </ul>
    </div>
</div>
<div class="margin-bottom-10"></div>       
<div class="row margin-left-5 margin-right-5">
    <div class="col-md-4">
        <img class="img-responsive margin-bottom-20" src="<?= $baseUrl ?>/assets/img/bas1.jpg"  alt="">
    </div>
    <div class="col-md-8">
        <div class="tag-box tag-box-v3 form-page">
            <div class="headline"><h3><?= $names; ?></h3></div>
            <div class="margin-bottom-40"></div>                
            <ul class="list-group sidebar-nav-v1 lists-v1" id="sidebar-nav">
                      <li class="list-group-item list-toggle">
                          <a class="btn-u" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse1">
                             <span class='h5 margin-left-10'>1. คลิกเลือกรายงานพื้นฐานทั่วไป !!</span>                             
                         </a>   
                             <ul id="collapse1" class="collapse">
                                 <li>
                                            <?=  !Yii::$app->user->isGuest?
                                                                 Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.1 &nbsp;ประชาการในเขตรับผิดชอบ(บัญชี 1) ทั้งหมด',
                                                                                ['basic-gen/basic-gen1']):
                                                                 Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.1 &nbsp;ประชาการในเขตรับผิดชอบ(บัญชี 1) ทั้งหมด',
                                                                                       ['site/modal'],[
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
                                                                               1.2 &nbsp;รายชื่อประชากรในเขตรับผิดชอบ(บัญชี 1)',
                                                                                ['basic-gen/basic-gen2']) :
                                                                 Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                               1.2 &nbsp;รายชื่อประชากรในเขตรับผิดชอบ(บัญชี 1)',     
                                                                                ['site/modal'],[
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
                                                                               1.3 &nbsp;รายงานเด็กเกิด 5 ปีย้อนหลัง',
                                                                                ['basic-gen/basic-gen3']) : 
                                                                 Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                               1.3 &nbsp;รายงานเด็กเกิด 5 ปีย้อนหลัง',     
                                                                                ['site/modal'],[
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
                                                                               1.4 &nbsp;ทะเบียนการเกิด(คลอด)',
                                                                                ['basic-gen/basic-gen4']) :
                                                                 Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.4 &nbsp;ทะเบียนการเกิด(คลอด)',     
                                                                                ['site/modal'],[
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
                                                                                1.5 &nbsp;รายงานสาเหตุการตายสูงสุด(ทั้งหมด/รายโรค)
                                                                                       แยก ใน/นอก รพ. ',
                                                                                ['basic-gen/basic-gen6']) :
                                                                 Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.5 &nbsp;รายงานสาเหตุการตายสูงสุด(ทั้งหมด/รายโรค)
                                                                                       แยก ใน/นอก รพ. ',     
                                                                                ['site/modal'],[
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
                                                                                1.6 &nbsp;รายงานการส่งต่อผู้ป่วย(refer-out) ',
                                                                                ['basic-gen/basic-gen7']) :
                                                                 Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.6 &nbsp;รายงานการส่งต่อผู้ป่วย(refer-out) ',     
                                                                                ['site/modal'],[
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
                                                                                1.7 &nbsp;รายงานการรับส่งต่อผู้ป่วย(refer-in) ',
                                                                                ['basic-gen/basic-gen8']) :
                                                                 Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.7 &nbsp;รายงานการรับส่งต่อผู้ป่วย(refer-in) ',     
                                                                                ['site/modal'],[
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
                                                                                1.8 &nbsp;รายงานส่งต่อผู้ป่วย(refer out) แยกตามสถานบริการส่งต่อ',
                                                                                ['basic-gen/basic-gen23']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.8 &nbsp;รายงานส่งต่อผู้ป่วย(refer out) แยกตามสถานบริการส่งต่อ',
                                                                                ['site/modal'],[
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
                                                                         1.9 &nbsp;รายงานการรับส่งต่อผู้ป่วย(refer in) แยกตามสถานบริการส่งต่อ',
                                                                         ['basic-gen/basic-gen24']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.9 &nbsp;รายงานการรับส่งต่อผู้ป่วย(refer in) แยกตามสถานบริการส่งต่อ',
                                                                         ['site/modal'],[
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
                                                                         1.10 &nbsp;รายงานการรับส่งต่อผู้ป่วย(refer out) โรงพยาบาลเครื่อข่าย',
                                                                         ['basic-gen/basic-gen25']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.10 &nbsp;รายงานการรับส่งต่อผู้ป่วย(refer out) โรงพยาบาลเครื่อข่าย',
                                                                         ['site/modal'],[
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
                                                                         1.11 &nbsp;รายงานการรับส่งต่อผู้ป่วย(refer in) โรงพยาบาลเครือข่าย',
                                                                         ['basic-gen/basic-gen26']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.11 &nbsp;รายงานการรับส่งต่อผู้ป่วย(refer in) โรงพยาบาลเครือข่าย',
                                                                         ['site/modal'],[
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
                                                                         1.12 &nbsp;รายงานการรับส่งต่อผู้ป่วย(refer out) 
                                                                               โรงพยาบาลเครือข่าย ที่มี Adj RW <=0.5',
                                                                         ['basic-gen/basic-gen27']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.12 &nbsp;รายงานการรับส่งต่อผู้ป่วย(refer out) 
                                                                               โรงพยาบาลเครือข่าย ที่มี Adj RW <=0.5',
                                                                         ['site/modal'],[
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
                                                                         1.13 &nbsp;รายงานการรับส่งต่อผู้ป่วย(refer in) 
                                                                               โรงพยาบาลเครือข่าย ที่มี Adj RW <=0.5',
                                                                         ['basic-gen/basic-gen28']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.13 &nbsp;รายงานการรับส่งต่อผู้ป่วย(refer in) 
                                                                               โรงพยาบาลเครือข่าย ที่มี Adj RW <=0.5',
                                                                         ['site/modal'],[
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
                                                                         1.14 &nbsp;รายงานจำนวนผู้รับบริการ(ในเขตรับผิดชอบ[20 ชุมชน + 14 หมู่]) 
                                                                                แยกตามสิทธิ์การรักษา',
                                                                         ['basic-gen/basic-gen32']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.14 &nbsp;รายงานจำนวนผู้รับบริการ(ในเขตรับผิดชอบ[20 ชุมชน + 14 หมู่]) 
                                                                                แยกตามสิทธิ์การรักษา',
                                                                         ['site/modal'],[
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
                                                                         1.15 &nbsp;รายงานจำนวนผู้รับบริการ(ทั้งหมด) แยกตามสิทธิ์การรักษา',
                                                                         ['basic-gen/basic-gen33']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.15 &nbsp;รายงานจำนวนผู้รับบริการ(ทั้งหมด) แยกตามสิทธิ์การรักษา',
                                                                         ['site/modal'],[
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
                          <a  class="btn-u" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse2">
                             <span class='h5 margin-left-10'>2. คลิกเลือกรายงานพื้นฐานผู้ป่วยนอก !!</span>                             
                         </a>   
                             <ul id="collapse2" class="collapse">
                                    <li>
                                            <?= !Yii::$app->user->isGuest?
                                                                 Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                               2.1 &nbsp;รายงานจำนวนผู้ป่วยนอก(ยกเว้นงานส่งเสริม)',
                                                                                ['basic-gen/basic-gen5']) :
                                                                 Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                2.1 &nbsp;รายงานจำนวนผู้ป่วยนอก(ยกเว้นงานส่งเสริม)',     
                                                                                ['site/modal'],[
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
                                                                                2.2 &nbsp;รายงานโรคที่พบบ่อยสุดผู้ป่วยนอก',
                                                                                ['basic-gen/basic-gen10']) :
                                                                 Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                2.2 &nbsp;รายงานโรคที่พบบ่อยสุดผู้ป่วยนอก',     
                                                                                ['site/modal'],[
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
                                                                                2.3 &nbsp;รายงานจำนวนผู้รับบริการผู้ป่วยนอก(ในเครือข่าย 7 อำเภอ)',
                                                                                ['basic-gen/basic-gen29']) :
                                                                 Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                2.3 &nbsp;รายงานจำนวนผู้รับบริการผู้ป่วยนอก(เครือข่าย)',
                                                                                ['site/modal'],[
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
                                                                                2.4 &nbsp;รายงานจำนวนผู้รับบริการผู้ป่วยนอก
                                                                                      (ในเขตรับผิดชอบ[20 ชุมชน + 14 หมู่] )',
                                                                                ['basic-gen/basic-gen30']) :
                                                                 Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                2.4 &nbsp;รายงานจำนวนผู้รับบริการผู้ป่วยนอก
                                                                                      (ในเขตรับผิดชอบ[20 ชุมชน + 14 หมู่] )',
                                                                                ['site/modal'],[
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
                                                                                2.5 &nbsp;รายงานจำนวนผู้รับบริการผู้ป่วยนอก
                                                                                      (ในเขตอำเภอ[ ไม่รวม 20 ชุมชน + 14 หมู่] )',
                                                                                ['basic-gen/basic-gen31']) :
                                                                 Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                2.5 &nbsp;รายงานจำนวนผู้รับบริการผู้ป่วยนอก
                                                                                      (ในเขตอำเภอ[ ไม่รวม 20 ชุมชน + 14 หมู่] )',
                                                                                ['site/modal'],[
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
                          <a class="btn-u" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse3">
                             <span class='h5 margin-left-10'>3. คลิกเลือกรายงานพื้นฐานผู้ป่วยใน !!</span>                             
                         </a>   
                             <ul id="collapse3" class="collapse">
                                    <li>
                                            <?= !Yii::$app->user->isGuest?
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                3.1 &nbsp;รายงาน 10 อันดับโรคแรกผู้ป่วยใน ',
                                                                                ['basic-gen/basic-gen11']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                3.1 &nbsp;รายงาน 10 อันดับโรคแรกผู้ป่วยใน ',   
                                                                                ['site/modal'],[
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
                                                                                3.2 &nbsp;รายงานอัตราการครองเตียง ',
                                                                                ['basic-gen/basic-gen12']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                3.2 &nbsp;รายงานอัตราการครองเตียง ', 
                                                                                ['site/modal'],[
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
                                                                                3.3 &nbsp;รายงานจำนวนวันนอนเฉลี่ยต่อคนต่อวัน ',
                                                                            ['basic-gen/basic-gen13']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                3.3 &nbsp;รายงานจำนวนวันนอนเฉลี่ยต่อคนต่อวัน ',
                                                                                ['site/modal'],[
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
                                                                                3.4 &nbsp;รายงานค่าใช้จ่ายสูงสุดรายโรค(ผู้ป่วยใน)',
                                                                                ['basic-gen/basic-gen14']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                3.4 &nbsp;รายงานค่าใช้จ่ายสูงสุดรายโรค(ผู้ป่วยใน)',
                                                                                ['site/modal'],[
                                                                                                'class' => 'xmodal',
                                                                                                'title' => 'เปิดดูข้อมูล',
                                                                                                'data-target' => '#vmodal',
                                                                                                'data-pjax' => '0',
                                                                                             ]
                                                                            );                                                         
                                            ?>
                                    </li>
                                    <li>
                                            <?=   !Yii::$app->user->isGuest?
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                3.5 &nbsp;รายงานค่าใช้จ่ายสูงสุดรายหัตถการ(ผู้ป่วยใน)',
                                                                                ['basic-gen/basic-gen15']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                3.5 &nbsp;รายงานค่าใช้จ่ายสูงสุดรายหัตถการ(ผู้ป่วยใน)',
                                                                                ['site/modal'],[
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
                                                                                3.6 &nbsp;รายงานวันนอนสูงสุดรายโรค',
                                                                                ['basic-gen/basic-gen16']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                3.6 &nbsp;รายงานวันนอนสูงสุดรายโรค',
                                                                                ['site/modal'],[
                                                                                                'class' => 'xmodal',
                                                                                                'title' => 'เปิดดูข้อมูล',
                                                                                                'data-target' => '#vmodal',
                                                                                                'data-pjax' => '0',
                                                                                             ]
                                                                            );                                                          
                                            ?> 
                                    </li>
                                    <li>
                                            <?=   !Yii::$app->user->isGuest?
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                3.7 &nbsp;รายงานสรุปรายงานผู้ป่วยใน(แยกตามตึกผู้ป่วย)',
                                                                                ['basic-gen/basic-gen17']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                3.7 &nbsp;รายงานสรุปรายงานผู้ป่วยใน(แยกตามตึกผู้ป่วย)',
                                                                                ['site/modal'],[
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
                                                                                3.8 &nbsp;รายงานโรคที่พบบ่อยสุด(ผู้ป่วยใน)ทั้งหมด,แยกสาขา/แผนก',
                                                                                ['basic-gen/basic-gen18']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                3.8 &nbsp;รายงานโรคที่พบบ่อยสุด(ผู้ป่วยใน)ทั้งหมด,แยกสาขา/แผนก',
                                                                                ['site/modal'],[
                                                                                                'class' => 'xmodal',
                                                                                                'title' => 'เปิดดูข้อมูล',
                                                                                                'data-target' => '#vmodal',
                                                                                                'data-pjax' => '0',
                                                                                             ]
                                                                            );                                                          
                                            ?>                             
                                    </li>
                                    <li>
                                             <?=   !Yii::$app->user->isGuest?
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                3.9 &nbsp;รายงาน Re admit 28 วัน ',
                                                                                ['basic-gen/basic-gen19']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                3.9 &nbsp;รายงาน Re admit 28 วัน ',
                                                                                ['site/modal'],[
                                                                                                'class' => 'xmodal',
                                                                                                'title' => 'เปิดดูข้อมูล',
                                                                                                'data-target' => '#vmodal',
                                                                                                'data-pjax' => '0',
                                                                                             ]
                                                                            );                                                         
                                            ?>                               
                                    </li>
                                    <li>
                                             <?=   !Yii::$app->user->isGuest?
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                3.10 &nbsp;รายงานดัชนีส่วนผสมผู้ป่วยใน(CMI) ',
                                                                                ['basic-gen/basic-gen20']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                3.10 &nbsp;รายงานดัชนีส่วนผสมผู้ป่วยใน(CMI) ',
                                                                                ['site/modal'],[
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
                                                                                3.11 &nbsp;รายงานดัชนีส่วนผสมผู้ป่วยใน(CMI)แยกแผนก',
                                                                                ['basic-gen/basic-gen21']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                3.11 &nbsp;รายงานดัชนีส่วนผสมผู้ป่วยใน(CMI)แยกแผนก',
                                                                                ['site/modal'],[
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
                                                                                3.12 &nbsp;รายงาน 20 กลุ่มโรค(MDC)ตาม DRG ',
                                                                                ['basic-gen/basic-gen22']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                3.12 &nbsp;รายงาน 20 กลุ่มโรค(MDC)ตาม DRG ',
                                                                                ['site/modal'],[
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
                                $('#zmodal').modal('show')
                                .find('#zmodalContent')
                                .load($(this).attr('href'));
                             return false;
                            });
                            
                            $('.xmodal').click(function (){
                                $('#vmodal').modal('show')
                                .find('#vmodalContent')
                                .load($(this).attr('href'));
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
                           ,
            
                 /* '<a href="#" class="btn btn-primary" data-dismiss="modal">SingUp</a>
                            <a href="#" class="btn btn-primary" data-dismiss="modal">Login</a>
                           ',*/
                      
        ]);

        echo "<div id='vmodalContent'></div>";

        Modal::end();
        ?>
<div class="margin-bottom-40"></div>