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
            <li><?=Html::a($mText,['/kpi/index']);;?></li>
        </ul>
    </div>
</div>
<div class="margin-bottom-10"></div>       
<div class="row margin-left-5 margin-right-5">
    <div class="col-md-4">
                <div class="item active">
                    <img src="<?= $baseUrl ?>/assets/img/bas3.jpg" alt="">
                </div>                                                   
    </div>
    <div class="col-md-8">
        <div class="tag-box tag-box-v3 form-page">
            <div class="headline"><h3><?= $names; ?></h3></div>
            <div class="margin-bottom-40"></div>                
            <ul class="list-group sidebar-nav-v1 lists-v1" id="sidebar-nav" style="list-style-type: none;">         
                      <li class="list-group-item list-toggle">
                         <a class="btn-u btn-u-light" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse0">
                              <span class='h5 margin-left-10'>1.  รายงานตัวชี้วัดงาน ANC</span>                             
                        </a>   
                             <ul id="collapse0" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1.1  ร้อยละของหญิงมีครรภ์ได้รับการฝากครรภ์ครั้งแรกภายใน 12 สัปดาห์',
                                                          ['/kpi/kpi1-index','year'=>'25'.$select1]) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1.1  ร้อยละของหญิงมีครรภ์ได้รับการฝากครรภ์ครั้งแรกภายใน 12 สัปดาห์',
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
                                                          1.2  ร้อยละของหญิงมีครรภ์ได้รับการฝากครรภ์ครบ 5 ครั้งตามเกณฑ์',
                                                          ['/kpi/kpi2-index','year'=>'25'.$select1]) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1.2  ร้อยละของหญิงมีครรภ์ได้รับการฝากครรภ์ครบ 5 ครั้งตามเกณฑ์',
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
                                                          1.3  ร้อยละของหญิงตั้งครรภ์ได้รับยาเสริมไอโอดีน',
                                                          ['/kpi/kpi21-index','year'=>'25'.$select1]) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1.3  ร้อยละของหญิงตั้งครรภ์ได้รับยาเสริมไอโอดีน',
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
                                                          1.4  อัตราการคลอดมีชีพในหญิงอายุ 15 - 19 ปี',
                                                          ['/kpi/kpi22-index','year'=>'25'.$select1]) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1.4  อัตราการคลอดมีชีพในหญิงอายุ 15 - 19 ปี',
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
                                                          1.5  ร้อยละของการตั้งครรภ์ซ้ำในวัยรุ่นอายุ 15 - 19 ปี',
                                                          ['/kpi/kpi23-index','year'=>'25'.$select1]) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1.5  ร้อยละของการตั้งครรภ์ซ้ำในวัยรุ่นอายุ 15 - 19 ปี',
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
                         <a class="btn-u btn-u-light" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse1">
                              <span class='h5 margin-left-10'>2. รายงานตัวชี้วัดงานพัฒนาการ(WBC)</span>                             
                        </a>   
                             <ul id="collapse1" class="collapse">                      
                                    <li>
                                                  <?= !Yii::$app->user->isGuest?
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                        2.1  ร้อยละของเด็กอายุ 9,18,30,42 เดือน ได้รับการตรวจคัดกรองพัฒนาการ',
                                                                        ['/kpi/kpi3-index','year'=>'25'.$select1]) : 
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                        2.1  ร้อยละของเด็กอายุ 9,18,30,42 เดือน ได้รับการตรวจคัดกรองพัฒนาการ',
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
                                                                        2.2  ร้อยละของเด็กอายุ 9,18,30,42 เดือน ที่ได้รับการตรวจคัดกรองพัฒนาการพบส่งสัยล่าช้า',
                                                                        ['/kpi/kpi4-index','year'=>'25'.$select1]) : 
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                        2.2  ร้อยละของเด็กอายุ 9,18,30,42 เดือน ที่ได้รับการตรวจคัดกรองพัฒนาการพบส่งสัยล่าช้า',
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
                                                                        2.3  ร้อยละของเด็กอายุ 9,18,30,42 42 เดือน ที่ได้รับการตรวจคัดกรองพัฒนาการ
                                                                            และพบส่งสัยล่าช้าได้รับการตรวจกระตุ้นพัฒนาการ',
                                                                        ['/kpi/kpi5-index','year'=>'25'.$select1]) : 
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                        2.3  ร้อยละของเด็กอายุ 9,18,30,42 42 เดือน ที่ได้รับการตรวจคัดกรองพัฒนาการ
                                                                            และพบส่งสัยล่าช้าได้รับการตรวจกระตุ้นพัฒนาการ',
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
                                                                        2.4  ร้อยละของเด็กอายุ 9,18,30,42 42 เดือน มีพัฒนาการสมวัย',
                                                                        ['/kpi/kpi6-index','year'=>'25'.$select1]) : 
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                        2.4  ร้อยละของเด็กอายุ 9,18,30,42 42 เดือน มีพัฒนาการสมวัย',
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
                         <a class="btn-u btn-u-light" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse2">
                              <span class='h5 margin-left-10'>3. รายงานตัวชี้วัดงานโรคเรื้อรัง(NCD)</span>                             
                        </a>   
                             <ul id="collapse2" class="collapse">                          
                                    <li>
                                            <?= !Yii::$app->user->isGuest?
                                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                  3.1  ร้อยละของประชากรไทยอายุ 35 ปีขึ้นไป ได้รับการคัดกรองเบาหวาน',
                                                                  ['/kpi/kpi7-index','year'=>'25'.$select1]) : 
                                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                  3.1  ร้อยละของประชากรไทยอายุ 35 ปีขึ้นไป ได้รับการคัดกรองเบาหวาน',
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
                                                                  3.2  ร้อยละกลุ่มเสี่ยงเบาหวานได้รับการติดตามผลระดับน้ำตาลในเลือด',
                                                                  ['/kpi/kpi8-index','year'=>'25'.$select1]) : 
                                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                  3.2  ร้อยละกลุ่มเสี่ยงเบาหวานได้รับการติดตามผลระดับน้ำตาลในเลือด',
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
                                                                  3.3  ร้อยละของประชากรไทยอายุ 35 ปีขึ้นไป ได้รับการคัดกรองความดันโลหิตสูง',
                                                                  ['/kpi/kpi9-index','year'=>'25'.$select1]) : 
                                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                  3.3  ร้อยละของประชากรไทยอายุ 35 ปีขึ้นไป ได้รับการคัดกรองความดันโลหิตสูง',
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
                                                                  3.4  ร้อยละกลุ่มเสี่ยงความดันโลหิตสูงได้รับการติดตามผลระดับความดันโลหิต ',
                                                                  ['/kpi/kpi10-index','year'=>'25'.$select1]) : 
                                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                  3.4  ร้อยละกลุ่มเสี่ยงความดันโลหิตสูงได้รับการติดตามผลระดับความดันโลหิต ',
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
                                                                3.5  อัตราผู้ป่วยเบาหวานรายใหม่ลดลง (ร้อยละ) ',
                                                                ['/kpi/kpi11-index','year'=>'25'.$select1]) : 
                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                3.5  อัตราผู้ป่วยเบาหวานรายใหม่ลดลง (ร้อยละ) ',
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
                                                                3.6  อัตราผู้ป่วยความดันโลหิตสูงรายใหม่ลดลง (ร้อยละ) ',
                                                                ['/kpi/kpi12-index','year'=>'25'.$select1]) : 
                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                3.6  อัตราผู้ป่วยความดันโลหิตสูงรายใหม่ลดลง (ร้อยละ) ',
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
                                                                 3.7  ร้อยละของผู้ป่วยโรคเบาหวานที่ควบคุมได้',
                                                                ['/kpi/kpi15-index','year'=>'25'.$select1]) : 
                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                 3.7  ร้อยละของผู้ป่วยโรคเบาหวานที่ควบคุมได้',
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
                                                                 3.8  ร้อยละของผู้ป่วยโรคความดันโลหิตสูงที่ควบคุมได้ ',
                                                                ['/kpi/kpi16-index','year'=>'25'.$select1]) : 
                                                  Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                 3.8  ร้อยละของผู้ป่วยโรคความดันโลหิตสูงที่ควบคุมได้ ',
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
                                                                  3.9  ร้อยละของผู้ป่วยเบาหวาน ที่ขึ้นทะเบียนได้รับการประเมินโอกาสเสี่ยงต่อโรคหัวใจ
                                                                            และหลอดเลือด (CVD Risk)',
                                                                    ['/kpi/kpi17a-index','year'=>'25'.$select1]) : 
                                                      Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                  3.9  ร้อยละของผู้ป่วยเบาหวาน ที่ขึ้นทะเบียนได้รับการประเมินโอกาสเสี่ยงต่อโรคหัวใจ
                                                                            และหลอดเลือด (CVD Risk)',
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
                                                                 3.10  ร้อยละของผู้ป่วยความดันโลหิตสูง ที่ขึ้นทะเบียนได้รับการประเมินโอกาสเสี่ยง
                                                                            ต่อโรคหัวใจและหลอดเลือด (CVD Risk)',
                                                                    ['/kpi/kpi17b-index','year'=>'25'.$select1]) : 
                                                      Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                 3.10  ร้อยละของผู้ป่วยความดันโลหิตสูง ที่ขึ้นทะเบียนได้รับการประเมินโอกาสเสี่ยง
                                                                            ต่อโรคหัวใจและหลอดเลือด (CVD Risk)',
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
                                                                 3.11  ร้อยละของผู้ป่วย DM ที่ได้รับการตรวจภาวะแทรกซ้อนทาง ตา ',
                                                                        ['/kpi/kpi18a-index','year'=>'25'.$select1]) : 
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                 3.11  ร้อยละของผู้ป่วย DM ที่ได้รับการตรวจภาวะแทรกซ้อนทาง ตา ',
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
                                                                  3.12  ร้อยละของผู้ป่วย DM ที่ได้รับการตรวจภาวะแทรกซ้อนทาง เท้า',
                                                                        ['/kpi/kpi18b-index','year'=>'25'.$select1]) : 
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                  3.12  ร้อยละของผู้ป่วย DM ที่ได้รับการตรวจภาวะแทรกซ้อนทาง เท้า',
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
                                                                  3.13  ร้อยละของผู้ป่วย DM ที่ได้รับการตรวจ Hba1C ',
                                                                        ['/kpi/kpi18c-index','year'=>'25'.$select1]) : 
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                  3.13  ร้อยละของผู้ป่วย DM ที่ได้รับการตรวจ Hba1C ',
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
                                                                  3.14  ร้อยละของผู้ป่วย DM ที่ได้รับการตรวจ Lipid Profile',
                                                                        ['/kpi/kpi18d-index','year'=>'25'.$select1]) : 
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                  3.14  ร้อยละของผู้ป่วย DM ที่ได้รับการตรวจ Lipid Profile',
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
                                                                  3.15  ร้อยละของผู้ป่วย DM ที่ได้รับการตรวจ eGFR',
                                                                        ['/kpi/kpi18e-index','year'=>'25'.$select1]) : 
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                  3.15  ร้อยละของผู้ป่วย DM ที่ได้รับการตรวจ eGFR',
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
                                                                 3.16  ร้อยละของผู้ป่วย DM ที่ได้รับการตรวจ micro albumin',
                                                                        ['/kpi/kpi18f-index','year'=>'25'.$select1]) : 
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                  3.16  ร้อยละของผู้ป่วย DM ที่ได้รับการตรวจ micro albumin',
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
                                                                  3.17  ร้อยละของผู้ป่วย HT ที่ได้รับการตรวจ Lipid Profile',
                                                                        ['/kpi/kpi19a-index','year'=>'25'.$select1]) : 
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                  3.17  ร้อยละของผู้ป่วย HT ที่ได้รับการตรวจ Lipid Profile',
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
                                                                  3.18  ร้อยละของผู้ป่วย HT ที่ได้รับการตรวจ Urine Protein  ',
                                                                        ['/kpi/kpi19b-index','year'=>'25'.$select1]) : 
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                  3.18  ร้อยละของผู้ป่วย HT ที่ได้รับการตรวจ Urine Protein  ',
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
                                                                  3.19  ร้อยละของผู้ป่วย HT ที่ได้รับการตรวจ FBS ',
                                                                        ['/kpi/kpi19c-index','year'=>'25'.$select1]) : 
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                  3.19  ร้อยละของผู้ป่วย HT ที่ได้รับการตรวจ FBS ',
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
                                                                  3.20  ร้อยละของผู้ป่วย HT ที่ได้รับการตรวจ eGFR',
                                                                        ['/kpi/kpi19d-index','year'=>'25'.$select1]) : 
                                                          Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                  3.20  ร้อยละของผู้ป่วย HT ที่ได้รับการตรวจ eGFR',
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
                                                          4. ความชุกของผู้สูบบุหรี่ของประชากรไทย อายุ 15 ปีขึ้นไป ',
                                                          ['/kpi/kpi13-index','year'=>'25'.$select1]) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          4. ความชุกของผู้สูบบุหรี่ของประชากรไทย อายุ 15 ปีขึ้นไป ',
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
                                                          5.  ความชุกของผู้ดื่มสุราของประชากรไทย อายุ 15 ปีขึ้นไป',
                                                          ['/kpi/kpi14-index','year'=>'25'.$select1]) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          5.  ความชุกของผู้ดื่มสุราของประชากรไทย อายุ 15 ปีขึ้นไป',
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
                                                          6. อัตราตายของผู้ป่วยโรคหลอดเลือดสมอง',
                                                          ['/kpi/kpi20-index','year'=>'25'.$select1]) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          6. อัตราตายของผู้ป่วยโรคหลอดเลือดสมอง',
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