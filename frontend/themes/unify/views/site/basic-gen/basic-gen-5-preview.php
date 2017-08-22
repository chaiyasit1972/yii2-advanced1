<?php
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\mpdf\Pdf;
use kartik\helpers\Html;


?>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?=$mText;?></h3>
        <ul class="pull-right breadcrumb">
            <li><?=Html::a('Home',['/site/index']);?></li>
            <li><?= Html::a($mText, ['/service/index1']); ?></li>
            <li class="active"><?=Html::a($names, ['/basic-gen/basic-gen5']); ?></li>
        </ul>
    </div>
</div>

<section class="service-info margin-left-5 margin-right-5 ">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"><?=$names;?>  ตั้งแต่ <?=Yii::$app->mycomponent->ShortDateThai($date1) ;?>   ถึงวันที่  
                      <?=Yii::$app->mycomponent->ShortDateThai($date2);?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                          <th class="text-center">รายการ</th>
                          <th class="text-center">จำนวนผู้ป่วย</th>
                          <th class="text-center">จำนวนวัน</th>
                          <th class="text-center">อัตราเฉลี่ยต่อวัน</th>                          
                      </tr>
                    </thead>
                    <tbody>
                     <?php                      
                        foreach ($dataProvider as $value1) {
                     ?>
                        <tr>
                            <td class="text-center">จำนวนผู้ป่วยนอก(ไม่รวมงานส่งเสริม)</td>                            
                            <td class="text-center"><?=  number_format($value1['total']);?></td>        
                            <td class="text-center"><?=$value1['days'];?></td>                            
                            <td class="text-center"><?=  number_format($value1['rate']);?></td>                                                    
                        </tr> 
                     <?php   
                        }
                     ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->


            </div>
          </div>
        </section>
</div>