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
            <li><?=Html::a($names,['/service/index4']);;?></li>
        </ul>
    </div>
</div>
<div class="margin-bottom-10"></div>       
<div class="row margin-left-5 margin-right-5">
    <div class="col-md-4">
        <img class="img-responsive margin-bottom-20" src="<?= $baseUrl ?>/assets/img/bas10.png"  alt="">
    </div>
    <div class="col-md-8">
        <div class="tag-box tag-box-v3 form-page">
            <div class="headline"><h3><?= $names; ?></h3></div>
            <div class="margin-bottom-40"></div>                
            <ul class="list-group sidebar-nav-v1 lists-v1" id="sidebar-nav">
                <!-- Typography -->
                <li class="list-group-item list-toggle">
                    <a data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse1"><span class="h5">1. กลุ่มงานกุมารเวชกรรม</span></a>
                    <ul id="collapse1" class="collapse">
                        <li>
                            <?=
                            !Yii::$app->user->isGuest ?
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.1 &nbsp; DHF(A91/A91) ', ['pct-child/index1']) :
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.1 &nbsp; DHF(A91/A91) ', ['site/modal'], [
                                        'class' => 'xmodal',
                                        'title' => 'เปิดดูข้อมูล',
                                        'data-target' => '#vmodal',
                                        'data-pjax' => '0',
                                            ]
                            );
                            ?>
                        </li>
                        <li>
                            <?=
                            !Yii::$app->user->isGuest ?
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.2 &nbsp; VLBW 0-999 กรัม', ['pct-child/index2']) :
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.2 &nbsp; VLBW 0-999 กรัม', ['site/modal'], [
                                        'class' => 'xmodal',
                                        'title' => 'เปิดดูข้อมูล',
                                        'data-target' => '#vmodal',
                                        'data-pjax' => '0',
                                            ]
                            );
                            ?> 
                        </li>
                        <li>
<?=
!Yii::$app->user->isGuest ?
        Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.3 &nbsp; VLBW 1000-1499 กรัม ', ['pct-child/index3']) :
        Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.3 &nbsp; VLBW 1000-1499 กรัม ', ['site/modal'], [
            'class' => 'xmodal',
            'title' => 'เปิดดูข้อมูล',
            'data-target' => '#vmodal',
            'data-pjax' => '0',
                ]
);
?> 
                        </li>
                        <li>
                            <?=
                            !Yii::$app->user->isGuest ?
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.4 &nbsp; VLBW 1500-2499 กรัม', ['pct-child/index4']) :
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.4 &nbsp; VLBW 1500-2499 กรัม', ['site/modal'], [
                                        'class' => 'xmodal',
                                        'title' => 'เปิดดูข้อมูล',
                                        'data-target' => '#vmodal',
                                        'data-pjax' => '0',
                                            ]
                            );
                            ?>                             
                        </li>
                        <li>
                            <?=
                            !Yii::$app->user->isGuest ?
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.5 &nbsp; Asthma', ['pct-child/index5']) :
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         1.5 &nbsp; Asthma', ['site/modal'], [
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
                    <a data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse2"><span class="h5">2. กลุ่มงานอายุรกรรม</span></a>
                    <ul id="collapse2" class="collapse">
                        <li>
<?=
!Yii::$app->user->isGuest ?
        Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.1 &nbsp;  โรค Stemi(I21-I214) ', ['pct-med/index1']) :
        Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.1 &nbsp; โรค Stemi(I21-I214) ', ['site/modal'], [
            'class' => 'xmodal',
            'title' => 'เปิดดูข้อมูล',
            'data-target' => '#vmodal',
            'data-pjax' => '0',
                ]
);
?>      
                        </li>
                        <li>
                            <?=
                            !Yii::$app->user->isGuest ?
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.2 &nbsp;  โรค Stroke(I60-I69) ', ['pct-med/index2']) :
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.2 &nbsp; โรค Stroke(I60-I69) ', ['site/modal'], [
                                        'class' => 'xmodal',
                                        'title' => 'เปิดดูข้อมูล',
                                        'data-target' => '#vmodal',
                                        'data-pjax' => '0',
                                            ]
                            );
                            ?>  
                        </li>
                        <li>
                            <?=
                            !Yii::$app->user->isGuest ?
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.3 &nbsp;  โรคเบาหวาน(E11-E119) ', ['pct-med/index3']) :
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.3 &nbsp;  โรคเบาหวาน(E11-E119) ', ['site/modal'], [
                                        'class' => 'xmodal',
                                        'title' => 'เปิดดูข้อมูล',
                                        'data-target' => '#vmodal',
                                        'data-pjax' => '0',
                                            ]
                            );
                            ?> 
                        </li>
                        <li>
                            <?=
                            !Yii::$app->user->isGuest ?
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.4 &nbsp;  โรคความดันโลหิต(I10-I15)', ['pct-med/index4']) :
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.4 &nbsp;  โรคความดันโลหิต(I10-I15)', ['site/modal'], [
                                        'class' => 'xmodal',
                                        'title' => 'เปิดดูข้อมูล',
                                        'data-target' => '#vmodal',
                                        'data-pjax' => '0',
                                            ]
                            );
                            ?>  
                        </li>
                        <li>
                            <?=
                            !Yii::$app->user->isGuest ?
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.5 &nbsp;  โรค Copd(J44-J449) ', ['pct-med/index5']) :
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.5 &nbsp;  โรค Copd(J44-J449) ', ['site/modal'], [
                                        'class' => 'xmodal',
                                        'title' => 'เปิดดูข้อมูล',
                                        'data-target' => '#vmodal',
                                        'data-pjax' => '0',
                                            ]
                            );
                            ?>  
                        </li>
                        <li>
                            <?=
                            !Yii::$app->user->isGuest ?
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.6 &nbsp;  โรค Sepsis(A41-A419)', ['pct-med/index6']) :
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         2.6 &nbsp;  โรค Sepsis(A41-A419)', ['site/modal'], [
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
                    <a class="accordion-toggle" href="#collapse3" data-toggle="collapse"><span class="h5">3. กลุ่มงานสูตินรีเวชกรรม</span></a>
                    <ul id="collapse3" class="collapse">
                        <li>
                            <?=
                            !Yii::$app->user->isGuest ?
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         3.1 &nbsp;  โรค PPH(O72-O723) ', ['pct-ops/index1']) :
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         3.1 &nbsp;  โรค PPH(O72-O723) ', ['site/modal'], [
                                        'class' => 'xmodal',
                                        'title' => 'เปิดดูข้อมูล',
                                        'data-target' => '#vmodal',
                                        'data-pjax' => '0',
                                            ]
                            );
                            ?> 
                        </li>
                        <li>
                            <?=
                            !Yii::$app->user->isGuest ?
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         3.2 &nbsp;  โรค Pre-eclampsia', ['pct-ops/index2']) :
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         3.2 &nbsp;  โรค Pre-eclampsia', ['site/modal'], [
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
                    <a class="accordion-toggle" href="#collapse4" data-toggle="collapse"><span class="h5">4. กลุ่มงานศัลยกรรม</span></a>
                    <ul id="collapse4" class="collapse">
                        <li>
                            <?=
                            !Yii::$app->user->isGuest ?
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.1 &nbsp;  Acute appendicitis(K35-K389)', ['pct-sur/index1']) :
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.1 &nbsp;  Acute appendicitis(K35-K389)', ['site/modal'], [
                                        'class' => 'xmodal',
                                        'title' => 'เปิดดูข้อมูล',
                                        'data-target' => '#vmodal',
                                        'data-pjax' => '0',
                                            ]
                            );
                            ?>    
                        </li>
                        <li>
<?=
!Yii::$app->user->isGuest ?
        Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.2 &nbsp;  โรค Ugih(K922-K929) ', ['pct-sur/index2']) :
        Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.2 &nbsp; โรค Ugih(K922-K929) ', ['site/modal'], [
            'class' => 'xmodal',
            'title' => 'เปิดดูข้อมูล',
            'data-target' => '#vmodal',
            'data-pjax' => '0',
                ]
);
?> 
                        </li>
                        <li>
                            <?=
                            !Yii::$app->user->isGuest ?
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.3 &nbsp;  Necrotizing Fasciitis', ['pct-sur/index3']) :
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.3 &nbsp;  Necrotizing Fasciitis', ['site/modal'], [
                                        'class' => 'xmodal',
                                        'title' => 'เปิดดูข้อมูล',
                                        'data-target' => '#vmodal',
                                        'data-pjax' => '0',
                                            ]
                            );
                            ?>   
                        </li>
                        <li>
                            <?=
                            !Yii::$app->user->isGuest ?
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.4 &nbsp;  Head injury(S00-S09)', ['pct-sur/index4']) :
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         4.4 &nbsp;  Head injury(S00-S09)', ['site/modal'], [
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
                <!-- Accordion and Tabs -->
                <li class="list-group-item list-toggle">
                    <a  class="accordion-toggle" data-toggle="collapse" href="#collapse5"><span class="h5">5. กลุ่มงานศัลยกรรมกระดูก</span></a>
                    <ul id="collapse5" class="collapse">
                        <li>
                            <?=
                            !Yii::$app->user->isGuest ?
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         5.1 &nbsp;   Closed Fracture', ['pct-ortho/index1']) :
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         5.1 &nbsp;   Closed Fracture', ['site/modal'], [
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
                <!-- End Accordion and Tabs -->
                <!-- Thumbails -->
                <li class="list-group-item list-toggle">
                    <a class="accordion-toggle" data-toggle="collapse" href="#collapse6"><span class="h5">6. กลุ่มงานจักษุ</span></a>
                    <ul id="collapse6" class="collapse">
                        <li>
                            <?=
                            !Yii::$app->user->isGuest ?
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         6.1 &bsp; Cataract(H25-H28)', ['pct-opt/index1']) :
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         6.1 &nbsp; Cataract(H25-H28)', ['site/modal'], [
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
                <!-- End Thumbails -->                
                <!-- Thumbails -->
                <li class="list-group-item list-toggle ">
                    <a class="accordion-toggle" data-toggle="collapse" href="#collapse7"><span class="h5">7. กลุ่มงานโสต ศอ นาสิก(EENT)</span></a>
                    <ul id="collapse7" class="collapse">
                        <li>
                            <?=
                            !Yii::$app->user->isGuest ?
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         7.1 &nbsp; <span> Tonsillectomy</span>', ['pct-eent/index1']) :
                                    Html::a('<i class="fa fa-arrow-right color-green"></i>
                                                                         7.1 &nbsp;   Tonsillectomy', ['site/modal'], [
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