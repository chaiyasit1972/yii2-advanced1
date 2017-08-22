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
            <li><?=Html::a($mText,['/er/index']);;?></li>
        </ul>
    </div>
</div>
<div class="margin-bottom-10"></div>       
<div class="row margin-left-5 margin-right-5">
    <div class="col-md-4">
        <div id="myCarousel" class="carousel slide carousel-v1">
            <div class="carousel-inner">
                <div class="item active">
                    <img src="<?= $baseUrl ?>/assets/img/er4.jpg" alt="">
                </div>
                <div class="item">
                    <img src="<?= $baseUrl ?>/assets/img/er3.jpg" alt="">
                </div>
                <div class="item">
                    <img src="<?= $baseUrl ?>/assets/img/er2.jpg" alt="">
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
                          <a class="btn-u btn-u-orange" data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse1">
                             <span class='h5 margin-left-10'>คลิกเลือกรายงาน !!</span>                             
                         </a>   
                            <ul id="collapse1" class="collapse">
                                 <li>
                                    <?= !Yii::$app->user->isGuest?
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานส่งต่อผู้ป่วย(refer out) with ambulance',
                                                          ['/er/er1']) :
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          1. รายงานส่งต่อผู้ป่วย(refer out) with ambulance',
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
                                                          2. รายงานส่งต่อผู้ป่วย ภายในจังหวัด(with ambulance/ไปเอง)', 
                                                          ['/er/er2']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          2. รายงานส่งต่อผู้ป่วย ภายในจังหวัด(with ambulance/ไปเอง)', 
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
                                                          3. รายงานส่งต่อผู้ป่วย เขต 9 ไม่รวม บร.(with ambulance/ไปเอง)',
                                                          ['/er/er3']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          3. รายงานส่งต่อผู้ป่วย เขต 9 ไม่รวม บร.(with ambulance/ไปเอง)',
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
                                                          4. รายงานส่งต่อผู้ป่วย นอกเขต 9 (ขอนแก่น,อื่นๆ) with Ambulance/ไปเอง ', 
                                                          ['/er/er4'])  : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          4. รายงานส่งต่อผู้ป่วย นอกเขต 9 (ขอนแก่น,อื่นๆ) with Ambulance/ไปเอง ', 
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
                                                          5. รายงานส่งต่อผู้ป่วย ส่วนกลาง (ก.ท.ม.) with Ambulance/ไปเอง ',
                                                          ['/er/er5']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          5. รายงานส่งต่อผู้ป่วย ส่วนกลาง (ก.ท.ม.) with Ambulance/ไปเอง ',
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
                                                          6. รายงานสาเหตุการส่งต่อ (with Ambulance/ไปเอง) ', 
                                                          ['/er/er6']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          6. รายงานสาเหตุการส่งต่อ (with Ambulance/ไปเอง) ',  
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
                                                          7. รายงานการส่งต่อผู้ป่วย on ETT (with Ambulance/ไปเอง) ',
                                                          ['/er/er7']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          7. รายงานการส่งต่อผู้ป่วย on ETT (with Ambulance/ไปเอง) ',
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
                                                          8. รายงานการส่งต่อผู้ป่วย high-volume (with Ambulance/ไปเอง)', 
                                                          ['/er/er8']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          8. รายงานการส่งต่อผู้ป่วย high-volume (with Ambulance/ไปเอง)',  
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
                                                          9 รายงานการส่งต่อผู้ป่วย high-risk (with Ambulance/ไปเอง)',
                                                          ['/er/er9']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          9. รายงานการส่งต่อผู้ป่วย high-risk (with Ambulance/ไปเอง)',
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
                                                          10. รายงานการส่งต่อผู้ป่วย แยกตามสถานบริการส่งต่อ(with Ambulance/ไปเอง)', 
                                                          ['/er/er10']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          10. รายงานการส่งต่อผู้ป่วย แยกตามสถานบริการส่งต่อ(with Ambulance/ไปเอง)', 
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
                                                          11. รายงานการส่งต่อผู้ป่วย แยกตามแผนก (with Ambulance/ไปเอง)',
                                                          ['/er/er11']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          11. รายงานการส่งต่อผู้ป่วย แยกตามแผนก (with Ambulance/ไปเอง)',
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
                                                          12. รายงานการส่งต่อผู้ป่วย แยกตามตึกผู้ป่วย (with Ambulance/ไปเอง)', 
                                                          ['/er/er12']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          12. รายงานการส่งต่อผู้ป่วย แยกตามตึกผู้ป่วย (with Ambulance/ไปเอง)', 
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
                                                          13. รายงานการรับการส่งต่อผู้ป่วย(refer in) ตามการวินิจฉัย',
                                                          ['/er/er13']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          13. รายงานการรับการส่งต่อผู้ป่วย(refer in) ตามการวินิจฉัย',
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
                                                          14. รายงานผู้ป่วยอุบัติเหตุฉุกเฉินแยกตามกลุ่มหัตถการ', 
                                                          ['/er/er14']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          14. รายงานผู้ป่วยอุบัติเหตุฉุกเฉินแยกตามกลุ่มหัตถการ', 
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
                                                          15. รายงานผู้ป่วย case ฉุกเฉิน',
                                                          ['/er/er15']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          15. รายงานผู้ป่วย case ฉุกเฉิน',
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
                                                          16. รายงานส่งต่อผู้ป่วย(refer out) นอกเขต 9 แยกตามสิทธิ์',
                                                          ['/er/er16']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          16. รายงานส่งต่อผู้ป่วย(refer out) นอกเขต 9 แยกตามสิทธิ์',
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
                                                          17. รายงานรับส่งต่อผู้ป่วย(refer in) แยกแผนก(PCT)/โรค',
                                                          ['/er/er17']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          17. รายงานรับส่งต่อผู้ป่วย(refer in) แยกแผนก(PCT)/โรค',
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
                                                          18. รายงานรับส่งต่อผู้ป่วย(refer in) RW <= 0.5 แยกแผนก(PCT)/โรค',
                                                          ['/er/er18']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          18. รายงานรับส่งต่อผู้ป่วย(refer in) RW <= 0.5 แยกแผนก(PCT)/โรค',
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
                                                          19. รายงานส่งต่อผู้ป่วย(refer out เฉพาะ รพ.ที่มีศักยภาพสูงกว่า) แยกแผนก(PCT)/โรค',
                                                          ['/er/er19']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          19. รายงานส่งต่อผู้ป่วย(refer out เฉพาะ รพ.ที่มีศักยภาพสูงกว่า) แยกแผนก(PCT)/โรค',
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
                                                          20. รายงานส่งต่อผู้ป่วย(refer out เฉพาะ รพ.ที่มีศักยภาพสูงกว่า) RW <= 0.5 แยกแผนก(PCT)/โรค',
                                                          ['/er/er20']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          20. รายงานส่งต่อผู้ป่วย(refer out เฉพาะ รพ.ที่มีศักยภาพสูงกว่า) RW <= 0.5 แยกแผนก(PCT)/โรค',
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
                                                          21. รายงานส่งต่อผู้ป่วยจาก สาเหตุ 19 กลุ่มโรค(แยก refer out/ refer in)',
                                                          ['/er/er21']) : 
                                            Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                          21. รายงานส่งต่อผู้ป่วยจาก สาเหตุ 19 กลุ่มโรค(แยก refer out/ refer in)',
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
<div class="margin-bottom-100"></div>