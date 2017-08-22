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
            <li><?=Html::a($mText,['/service/index']);;?></li>
        </ul>
    </div>
</div>
   <div class="service-info margin-bottom-100">           
        <div class="container content-boxes-v2">        
            <div class="row service-block-v6">
                <div class="col-md-6 md-margin-bottom-50">
                 <i class="icon-custom rounded-x icon-sm icon-color-u icon-line">1</i>
                    <div class="service-desc">
                        <div class="panel panel-warning">
                            <div class="panel-heading list-group-item list-toggle active">
                                <h4 class="panel-title">                                 
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-1" href="#collapse-One">
                                            ข้อมูลพื้นฐาน & ข้อมูลทั่วไป
                                        </a>                                                               
                                </h4>
                            </div>                        
                            <div id="collapse-One" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="list-unstyled lists-v1 margin-bottom-30">  
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
                                                    <?= !Yii::$app->user->isGuest?
                                                                 Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                               1.5 &nbsp;รายงานจำนวนผู้ป่วยนอก(ยกเว้นงานส่งเสริม)',
                                                                                ['basic-gen/basic-gen5']) :
                                                                 Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.5 &nbsp;รายงานจำนวนผู้ป่วยนอก(ยกเว้นงานส่งเสริม)',     
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
                                                                                1.6 &nbsp;รายงานสาเหตุการตายสูงสุด(ทั้งหมด/รายโรค)
                                                                                       แยก ใน/นอก รพ. ',
                                                                                ['basic-gen/basic-gen6']) :
                                                                 Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.6 &nbsp;รายงานสาเหตุการตายสูงสุด(ทั้งหมด/รายโรค)
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
                                                                                1.7 &nbsp;รายงานการส่งต่อผู้ป่วย(refer-out) ',
                                                                                ['basic-gen/basic-gen7']) :
                                                                 Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.7 &nbsp;รายงานการส่งต่อผู้ป่วย(refer-out) ',     
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
                                                                                1.8 &nbsp;รายงานการรับส่งต่อผู้ป่วย(refer-in) ',
                                                                                ['basic-gen/basic-gen8']) :
                                                                 Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.8 &nbsp;รายงานการรับส่งต่อผู้ป่วย(refer-in) ',     
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
                                                                                1.9 &nbsp;รายงาน 5 อันดับโรคการส่งต่อผู้ป่วยนอก',
                                                                                ['basic-gen/basic-gen9']) :
                                                                 Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.9 &nbsp;รายงาน 5 อันดับโรคการส่งต่อผู้ป่วยนอก',     
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
                                                                                1.10 &nbsp;รายงานโรคที่พบบ่อยสุดผู้ป่วยนอก',
                                                                                ['basic-gen/basic-gen10']) :
                                                                 Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.10 &nbsp;รายงานโรคที่พบบ่อยสุดผู้ป่วยนอก',     
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
                                                                                1.11 &nbsp;รายงาน 10 อันดับโรคแรกผู้ป่วยใน ',
                                                                                ['basic-gen/basic-gen11']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.11 &nbsp;รายงาน 10 อันดับโรคแรกผู้ป่วยใน ',   
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
                                                                                1.12 &nbsp;รายงานอัตราการครองเตียง ',
                                                                                ['basic-gen/basic-gen12']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                 1.12 &nbsp;รายงานอัตราการครองเตียง ', 
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
                                                                                1.13 &nbsp;รายงานจำนวนวันนอนเฉลี่ยต่อคนต่อวัน ',
                                                                            ['basic-gen/basic-gen13']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.13 &nbsp;รายงานจำนวนวันนอนเฉลี่ยต่อคนต่อวัน ',
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
                                                                                1.14 &nbsp;รายงานค่าใช้จ่ายสูงสุดรายโรค(ผู้ป่วยใน)',
                                                                                ['basic-gen/basic-gen14']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.14 &nbsp;รายงานค่าใช้จ่ายสูงสุดรายโรค(ผู้ป่วยใน)',
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
                                                                                1.15 &nbsp;รายงานค่าใช้จ่ายสูงสุดรายหัตถการ(ผู้ป่วยใน)',
                                                                                ['basic-gen/basic-gen15']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.15 &nbsp;รายงานค่าใช้จ่ายสูงสุดรายหัตถการ(ผู้ป่วยใน)',
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
                                                                                1.16 &nbsp;รายงานวันนอนสูงสุดรายโรค',
                                                                                ['basic-gen/basic-gen16']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.16 &nbsp;รายงานวันนอนสูงสุดรายโรค',
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
                                                                                1.17 &nbsp;รายงานสรุปรายงานผู้ป่วยใน',
                                                                                ['basic-gen/basic-gen17']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.17 &nbsp;รายงานสรุปรายงานผู้ป่วยใน',
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
                                                                                1.18 &nbsp;รายงานโรคที่พบบ่อยสุด(ผู้ป่วยใน)ทั้งหมด,แยกสาขา/แผนก',
                                                                                ['basic-gen/basic-gen18']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.18 &nbsp;รายงานโรคที่พบบ่อยสุด(ผู้ป่วยใน)ทั้งหมด,แยกสาขา/แผนก',
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
                                                                                1.19 &nbsp;รายงาน Re admit 28 วัน ',
                                                                                ['basic-gen/basic-gen19']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.19 &nbsp;รายงาน Re admit 28 วัน ',
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
                                                                                1.20 &nbsp;รายงานดัชนีส่วนผสมผู้ป่วยใน(CMI) ',
                                                                                ['basic-gen/basic-gen20']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.20 &nbsp;รายงานดัชนีส่วนผสมผู้ป่วยใน(CMI) ',
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
                                                                                1.21 &nbsp;รายงานดัชนีส่วนผสมผู้ป่วยใน(CMI)แยกแผนก',
                                                                                ['basic-gen/basic-gen21']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.21 &nbsp;รายงานดัชนีส่วนผสมผู้ป่วยใน(CMI)แยกแผนก',
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
                                                                                1.22 &nbsp;รายงาน 20 กลุ่มโรค(MDC)ตาม DRG ',
                                                                                ['basic-gen/basic-gen22']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.22 &nbsp;รายงาน 20 กลุ่มโรค(MDC)ตาม DRG ',
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
                                                                                1.23 &nbsp;รายงานส่งต่อผู้ป่วย(refer out) แยกตามสถานบริการส่งต่อ',
                                                                                ['basic-gen/basic-gen23']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                                1.23 &nbsp;รายงานส่งต่อผู้ป่วย(refer out) แยกตามสถานบริการส่งต่อ',
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
                                                                         1.24 &nbsp;รายงานการรับส่งต่อผู้ป่วย(refer in) แยกตามสถานบริการส่งต่อ',
                                                                         ['basic-gen/basic-gen24']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.24 &nbsp;รายงานการรับส่งต่อผู้ป่วย(refer in) แยกตามสถานบริการส่งต่อ',
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
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>                        
                    </div>
                </div>
                <div class="col-md-6 md-margin-bottom-50">
                   <i class="icon-custom rounded-x icon-sm icon-color-u icon-line">2</i>
                    <div class="service-desc">
                        <div class="panel panel-warning">
                            <div class="panel-heading list-group-item list-toggle active">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-1" href="#collapse-Two">
                                            ตัวชี้วัด
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse-Two" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                           <ul class="list-unstyled lists-v1 margin-bottom-30">
                                                <li>
                                                    <?= !Yii::$app->user->isGuest?
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.1 &nbsp;รายงานตัวชี้วัดกระทรวง ปีงบประมาณ 2559 ',
                                                                         ['kpi-ministry/index59']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.1 &nbsp;รายงานตัวชี้วัดกระทรวง ปีงบประมาณ 2559 ',
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
                                                                         2.2 &nbsp;ตัวชี้วัดปีงบประมาณ 2559 เขตสุขภาพที่ 9',
                                                                         ['kpi-area/index59']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.2 &nbsp;ตัวชี้วัดปีงบประมาณ 2559 เขตสุขภาพที่ 9',
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                                                                 
            </div>            
            <div class="row service-block-v6">       
                <div class="col-md-6 md-margin-bottom-50">
                   <i class="icon-custom rounded-x icon-sm icon-color-u icon-line">3</i>
                    <div class="service-desc">
                        <div class="panel panel-warning">
                            <div class="panel-heading list-group-item list-toggle active">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-1" href="#collapse-Tree">
                                            Service Plan
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse-Tree" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="list-unstyled lists-v1 margin-bottom-30">
                                                <li>
                                                    <?=  !Yii::$app->user->isGuest?
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         3.1.1 &nbsp;โรคหลอดเลือดสมอง',
                                                                         ['service-plan1/index']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         3.1.1 &nbsp;โรคหลอดเลือดสมอง',
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
                                                                         3.1.2 &nbsp;โรคหลอดเลือดสมอง (ใหม่)',
                                                                         ['service-plan1new/index']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         3.1.2 &nbsp;โรคหลอดเลือดสมอง (ใหม่)',
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
                                                                         3.2 &nbsp;โรคหลอดเลือดหัวใจ ',
                                                                         ['service-plan2/index']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         3.2 &nbsp;โรคหลอดเลือดหัวใจ ',
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
                                                                         3.3 &nbsp;โรคไต',
                                                                         ['service-plan3/index']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         3.3 &nbsp;โรคไต',
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
                                                                         3.4 &nbsp;โรค Copd&Asthma ',
                                                                         ['service-plan4/index']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         3.4 &nbsp;โรค Copd&Asthma ',
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                                                                                                                   
                <div class="col-md-6 md-margin-bottom-50">
                      <i class="icon-custom rounded-x icon-sm icon-color-u icon-line">4</i>
                    <div class="service-desc">
                        <div class="panel panel-warning">
                            <div class="panel-heading list-group-item list-toggle active">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-1" href="#collapse-Four">
                                            โรคที่น่าสนใจ & pct
                                    </a>                                                                            
                                </h4>
                            </div>                        
                            <div id="collapse-Four" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="list-unstyled lists-v1 margin-bottom-30">
                                                <li>
                                                    <?= !Yii::$app->user->isGuest?
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;กุมารเวชกรรม - DHF(A91/A91) ',
                                                                         ['pct-child/index1']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;กุมารเวชกรรม - DHF(A91/A91) ',
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
                                                                         &nbsp;กุมารเวชกรรม - VLBW 0-999 กรัม',
                                                                         ['pct-child/index2']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;กุมารเวชกรรม - VLBW 0-999 กรัม',
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
                                                                         &nbsp;กุมารเวชกรรม - VLBW 1000-1499 กรัม ',
                                                                         ['pct-child/index3']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;กุมารเวชกรรม - VLBW 1000-1499 กรัม ',
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
                                                                         &nbsp;กุมารเวชกรรม - VLBW 1500-2499 กรัม',
                                                                         ['pct-child/index4']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;กุมารเวชกรรม - VLBW 1500-2499 กรัม',
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
                                                                         &nbsp;กุมารเวชกรรม - Asthma',
                                                                         ['pct-child/index5']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;กุมารเวชกรรม - Asthma',
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
                                                                         &nbsp;อายุรกรรม - โรค Stemi(I21-I214) ',
                                                                         ['pct-med/index1']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;อายุรกรรม - โรค Stemi(I21-I214) ',
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
                                                                         &nbsp;อายุรกรรม - โรค Stroke(I60-I69) ',
                                                                         ['pct-med/index2']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;อายุรกรรม - โรค Stroke(I60-I69) ',
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
                                                                         &nbsp;อายุรกรรม - โรคเบาหวาน(E11-E119) ',
                                                                         ['pct-med/index3']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;อายุรกรรม - โรคเบาหวาน(E11-E119) ',
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
                                                                         &nbsp;อายุรกรรม - โรคความดันโลหิต(I10-I15)',
                                                                         ['pct-med/index4']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;อายุรกรรม - โรคความดันโลหิต(I10-I15)',
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
                                                                         &nbsp;อายุรกรรม - โรค Copd(J44-J449) ',
                                                                         ['pct-med/index5']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;อายุรกรรม - โรค Copd(J44-J449) ',
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
                                                                         &nbsp;อายุรกรรม - โรค Sepsis(A41-A419)',
                                                                         ['pct-med/index6']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;อายุรกรรม - โรค Sepsis(A41-A419)',
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
                                                                         &nbsp;สูตินรีเวชกรรม - โรค PPH(O72-O723) ',
                                                                         ['pct-ops/index1']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;สูตินรีเวชกรรม - โรค PPH(O72-O723) ',
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
                                                                         &nbsp;สูตินรีเวชกรรม - โรค Pre-eclampsia',
                                                                         ['pct-ops/index2']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;สูตินรีเวชกรรม - โรค Pre-eclampsia',
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
                                                                         &nbsp;ศัลยกรรม - NF',
                                                                         ['pct-sur/nf_index']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;ศัลยกรรม - NF',
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
                                                                         &nbsp;ศัลยกรรม - Appendicitis',
                                                                         ['pct-sur/appendicitis_index']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;ศัลยกรรม - Appendicitis',
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
                                                                         &nbsp;ศัลยกรรม - UGI Bleeding',
                                                                         ['pct-sur/ugibleeding_index']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;ศัลยกรรม - UGI Bleeding',
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
                                                                         &nbsp;ศัลยกรรม - EGD/Colonoscope/Hernioraphy/Wipple Operation',
                                                                         ['pct-sur/operation_index']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;ศัลยกรรม - EGD/Colonoscope/Hernioraphy/Wipple Operation',
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
                                                                         &nbsp;ศัลยกรรม - Acute appendicitis(K35-K389)',
                                                                         ['pct-sur/index1']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;ศัลยกรรม - Acute appendicitis(K35-K389)',
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
                                                                         &nbsp;ศัลยกรรม - โรค Ugih(K922-K929) ',
                                                                         ['pct-sur/index2']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;ศัลยกรรม - โรค Ugih(K922-K929) ',
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
                                                                         &nbsp;ศัลยกรรม - Necrotizing Fasciitis',
                                                                         ['pct-sur/index3']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;ศัลยกรรม - Necrotizing Fasciitis',
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
                                                                         &nbsp;ศัลยกรรม - Head injury(S00-S09)',
                                                                         ['pct-sur/index4']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;ศัลยกรรม - Head injury(S00-S09)',
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
                                                                         &nbsp;ศัลยกรรมกระดูก - Closed Fracture',
                                                                         ['pct-ortho/index1']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;ศัลยกรรมกระดูก - Closed Fracture',
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
                                                                         &nbsp;จักษุ -Cataract(H25-H28)',
                                                                         ['pct-opt/index1']) : 
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp;จักษุ -Cataract(H25-H28)',
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
                                                                         &nbsp; โสต ศอ นาสิก(EENT) - Tonsillectomy',
                                                                         ['pct-eent/index1']) :
                                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         &nbsp; โสต ศอ นาสิก(EENT) - Tonsillectomy',
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
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>                        
                    </div>
                </div>                              
            </div>
        </div>
   </div>

<div class="container content">
    <div class="row">
        <!-- Begin Sidebar Menu -->
        <div class="col-md-3">
            <img class="img-responsive margin-bottom-20" src="<?= $baseUrl ?>/assets/img/main/img18.jpg"  alt="">
        </div>
        <!-- End Sidebar Menu -->

        <!-- Begin Content -->
        <div class="col-md-9">
              <div class="alert alert-info fade in">
              
              </div>

 




            <!-- Standard Form Controls -->
            <div class="tag-box tag-box-v3 form-page">
                <div class="headline"><h3>Standard Form Controls</h3></div>
                <div class="margin-bottom-40"></div>
                
                <ul class="list-group sidebar-nav-v1" id="sidebar-nav">
                <!-- Typography -->
                <li class="list-group-item list-toggle">
                    <a data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse-typography">Typography</a>
                    <ul id="collapse-typography" class="collapse">
                        <li><a href="shortcode_typo_general.html"><i class="fa fa-sort-alpha-asc"></i> General Typography</a></li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_typo_headings.html"><i class="fa fa-magic"></i> Heading Options</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_typo_dividers.html"><i class="fa fa-ellipsis-h"></i> Dividers</a>
                        </li>
                        <li><a href="shortcode_typo_blockquote.html"><i class="fa fa-quote-left"></i> Blockquote Blocks</a></li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_typo_boxshadows.html"><i class="fa fa-asterisk"></i> Box Shadows</a>
                        </li>
                        <li><a href="shortcode_typo_testimonials.html"><i class="fa fa-comments"></i> Testimonials</a></li>
                        <li><a href="shortcode_typo_tagline_boxes.html"><i class="fa fa-tasks"></i> Tagline Boxes</a></li>
                        <li><a href="shortcode_typo_grid.html"><i class="fa fa-align-justify"></i> Grid Layout</a></li>
                    </ul>
                </li>
                <!-- End Typography -->

                <!-- Buttons UI -->
                <li class="list-group-item list-toggle">
                    <a data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse-buttons">Buttons UI</a>
                    <ul id="collapse-buttons" class="collapse">
                        <li><a href="shortcode_btn_general.html"><i class="fa fa-flask"></i> General Buttons</a></li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_btn_brands.html"><i class="fa fa-html5"></i> Brand &amp; Social Buttons</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_btn_effects.html"><i class="fa fa-bolt"></i> Loading &amp; Hover Effects</a>
                        </li>
                    </ul>
                </li>
                <!-- End Buttons UI -->
                <!-- Thumbails -->
                <li class="list-group-item"><a href="shortcode_thumbnails.html">Thumbnails</a></li>
                <!-- End Thumbails -->

                <!-- Components -->
                <li class="list-group-item list-toggle">
                    <a class="accordion-toggle" href="#collapse-components" data-toggle="collapse">Components</a>
                    <ul id="collapse-components" class="collapse">
                        <li><a href="shortcode_compo_messages.html"><i class="fa fa-comment"></i> Alerts &amp; Messages</a></li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_compo_labels.html"><i class="fa fa-tags"></i> Labels &amp; Badges</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_compo_progress_bars.html"><i class="fa fa-align-left"></i> Progress Bars</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_compo_media.html"><i class="fa fa-volume-down"></i> Audio/Videos &amp; Images</a>
                        </li>
                        <li><a href="shortcode_compo_panels.html"><i class="fa fa-columns"></i> Panels</a></li>
                        <li><a href="shortcode_compo_pagination.html"><i class="fa fa-arrows-h"></i> Pagination</a></li>
                    </ul>
                </li>
                <!-- End Components -->

                <!-- Accordion and Tabs -->
                <li class="list-group-item"><a href="shortcode_accordion_and_tabs.html">Accordion and Tabs</a></li>
                <!-- End Accordion and Tabs -->

                <!-- Timeline -->
                <li class="list-group-item list-toggle">
                    <a class="accordion-toggle" href="#collapse-timeline" data-toggle="collapse">Timeline</a>
                    <ul id="collapse-timeline" class="collapse">
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_timeline1.html"><i class="fa fa-dot-circle-o"></i> Timeline 1</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_timeline2.html"><i class="fa fa-dot-circle-o"></i> Timeline 2</a>
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


<?php 
 /*  FullscreenModal::begin([
                        'header' => '<h4 class="modal-title text-center">Fullscreen Modal</h4>',
                        'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>',

                        'toggleButton' => ['label' => 'Open','class'=>'btn btn-primary'],
                        ]);
  * 
  */
?>

<!--<p> Content </p>-->

<?php //FullscreenModal::end();?>
  
