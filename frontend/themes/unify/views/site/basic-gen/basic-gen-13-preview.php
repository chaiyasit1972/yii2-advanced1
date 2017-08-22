<?php

use kartik\helpers\Html;

?>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?= $mText; ?></h3>
        <ul class="pull-right breadcrumb">
            <li><?= Html::a('Home', ['/site/index']); ?></li>
            <li><?= Html::a($mText, ['/service/index1']); ?></li>
            <li class="active"><?=Html::a($names, ['/basic-gen/basic-gen13']); ?></li>
        </ul>
    </div>
</div>
<section class="page-content service-info">
          <div class="row">              
              <div class="col-xs-1"></div>
              <div class="col-xs-10">              
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title color-orange"><?=$names;?>  ตั้งแต่ <?=Yii::$app->mycomponent->ShortDateThai($date1) ;?>   ถึงวันที่  
                      <?=Yii::$app->mycomponent->ShortDateThai($date2);?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                          <th class="text-center">รายการ</th>
                          <th class="text-center">จำนวนผู้ป่วยจำหน่าย</th>
                          <th class="text-center">จำนวนวันนอน</th>
                          <th class="text-center">อัตราเฉลี่ย(คนต่อวัน)</th>                          
                      </tr>
                    </thead>
                    <tbody>
                     <?php                      
                        foreach ($dataProvider as $value1) {
                     ?>
                        <tr>
                            <td class="text-right">รายงานจำนวนวันนอนเฉลี่ย</td>                            
                            <td class="text-center"><?=  number_format($value1['man']);?></td>        
                            <td class="text-center"><?=  number_format($value1['days']);?></td>                            
                            <td class="text-center"><?=  number_format($value1['rate'],2);?></td>                                                    
                        </tr> 
                     <?php   
                        }
                     ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->


            </div>
              <div class="col-xs-1"></div>
          </div>
        </section>