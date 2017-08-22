<?php

use kartik\helpers\Html;

?>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?= $mText; ?></h3>
        <ul class="pull-right breadcrumb">
            <li><?= Html::a('Home', ['/site/index']); ?></li>
            <li><?=
                Html::a($mText, ['/opd/index']);
                ;
                ?></li>
            <li class="active"><?= Html::a($names,['opd/opd1-index']); ?></li>
        </ul>
    </div>
</div>

<section class="content">
          <div class="row  margin-left-10 margin-right-20">
            <div class="col-xs-12">
                <div class="panel panel-red margin-bottom-40">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-globe"></i> 
                             <?=$names;?>  ตั้งแต่ <?=Yii::$app->mycomponent->ShortDateThai($date1) ;?>   ถึงวันที่  
                             <?=Yii::$app->mycomponent->ShortDateThai($date2);?>                        
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-striped">
                      <tr>
                          <th rowspan="3" class="text-center"></th>
                          <th colspan="4" class="text-center">ประเภทผู้ป่วย</th>
                          <th colspan="3" class="text-center">ชนิดผู้ป่วย</th>
                          <th colspan="2" class="text-center">รวมทั้งหมด</th>                          
                      </tr>
                      <tr>
                          <th colspan="2" class="text-center">ในเวลา</th>
                          <th colspan="2" class="text-center">นอกเวลา</th>     
                          <th class="text-center">รายใหม่</th>
                          <th colspan="2" class="text-center">รายเก่า</th>
                      </tr>
                      <tr>
                          <th class="text-center">คน</th>
                          <th class="text-center">ครั้ง</th>
                          <th class="text-center">คน</th>
                          <th class="text-center">ครั้ง</th>      
                          <th class="text-center">คน</th>
                          <th class="text-center">คน</th>                          
                          <th class="text-center">ครั้ง</th>  
                          <th class="text-center">คน</th>
                          <th class="text-center">ครั้ง</th>                            
                      </tr>
                    </thead>
                    <tbody>
                     <?php                      
                        foreach ($dataProvider as $value1) {
                     ?>
                        <tr>
                            <td class="text-right"><?=$value1['names'];?></td>
                            <td class="text-center"><?=number_format($value1['inman']);?></td>                            
                            <td class="text-center"><?=number_format($value1['inmen']);?></td>        
                            <td class="text-center"><?=number_format($value1['outman']);?></td>                            
                            <td class="text-center"><?=number_format($value1['outmen']);?></td>                            
                            <td class="text-center"><?=number_format($value1['newman']);?></td>                            
                            <td class="text-center"><?=number_format($value1['oldman']);?></td>        
                            <td class="text-center"><?=number_format($value1['oldmen']);?></td>                            
                            <td class="text-center"><?=number_format($value1['tman']);?></td>
                            <td class="text-center"><?=number_format($value1['tmen']);?></td>                            
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