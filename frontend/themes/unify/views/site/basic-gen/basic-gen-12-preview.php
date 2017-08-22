<?php

use yii\helpers\Html;

?>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?= $mText; ?></h3>
        <ul class="pull-right breadcrumb">
            <li><?= Html::a('Home', ['/site/index']); ?></li>
            <li><?= Html::a($mText, ['/service/index1']); ?></li>
            <li class="active"><?=Html::a($names, ['/basic-gen/basic-gen12']); ?></li>
        </ul>
    </div>
</div>
<div class="well-sm grid-view">
    <div class="row"><div class="col-xs-1"></div>
        <div class="col-xs-10">
                <div class="box-header">
                  <h3 class="box-title"><?=$names  .   '  ' .  $bed_n . '[' . $bed_c  .']'?>เตียง  ตั้งแต่ <?=Yii::$app->mycomponent->ShortDateThai($date1) ;?>   ถึงวันที่  
                      <?=Yii::$app->mycomponent->ShortDateThai($date2);?></h3>
                </div><!-- /.box-header -->            
                  <table id="example2" class="table table-bordered table-hover service-info">
                    <thead>
                      <tr>
                          <th class="text-center">รายการ</th>
                          <th class="text-center">ระยะเวลา(วัน)</th>
                          <th class="text-center">จำนวนวันนอน(ทั้งหมด)</th>
                          <th class="text-center">อัตราการครองเตียง</th>                          
                      </tr>
                    </thead>
                    <tbody>
                     <?php                      
                        foreach ($dataProvider as $value1) {
                     ?>
                        <tr>
                            <td class="text-right">อัตราการครองเตียง</td>                            
                            <td class="text-center"><?=  number_format($value1['days']);?></td>        
                            <td class="text-center"><?=  number_format($value1['day_slp']);?></td>                           
                            <td class="text-center"><?=  number_format($value1['bed_rate'],2);?></td>                                                    
                        </tr> 
                     <?php   
                        }
                     ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
        <div class="col-xs-1"></div>                
              </div><!-- /.box -->
          </div>    

</div>
