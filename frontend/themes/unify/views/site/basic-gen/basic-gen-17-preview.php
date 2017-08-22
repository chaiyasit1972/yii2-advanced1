<?php
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\mpdf\Pdf;
use kartik\helpers\Html;
use miloschuman\highcharts\Highcharts;

?>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?= $mText; ?></h3>
        <ul class="pull-right breadcrumb">
            <li><?= Html::a('Home', ['/site/index']); ?></li>
            <li><?= Html::a($mText, ['/service/index1']); ?></li>
            <li class="active"><?=Html::a($names, ['/basic-gen/basic-gen17']); ?></li>
        </ul>
    </div>
</div>
<div class="row">
<div class="col-md-1"></div>    
<div class="col-md-10">
<div class="alert alert-info margin-left-5 margin-right-5">
        <h4>     <?=$names .  '('. $wname .')  ตั้งแต่วันที่    ' .  
                  Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '.  Yii::$app->mycomponent->ShortDateThai($date2);?>
        </h4>     
</div>  
<div class="service-info margin-left-5 margin-right-5">
<table class="table table-striped table-bordered table-hover">
  <thead>
    <tr>
        <th class="text-center" rowspan="2">ลำดับที่</th>
        <th class="text-center" rowspan="2">รายการ</th>       
        <th class="text-center" colspan="2">จำนวน</th>           
        <th class="text-center" rowspan="2">หน่วยนับ</th>                
    </tr>
    <tr>
        <th class="text-center">ชาย</th>
        <th class="text-center">หญิง</th>        
    </tr>
 </thead>
 <tbody>
<?php         
$posts = $dataProvider->getModels();
  $i=0;
  foreach ($posts as $data){
      $i=$i+1;
      if($i>=7){
       ?>   
     <tr>
    <td class="text-center"><?=$data['id'];?></td>
    <td class="text-left"><?=$data['name'];?></td>
    <td class="text-center" colspan="2"><?=$data['man'];?></td>
    <td class="text-center"><?=$data['unit'];?></td>        
   </tr>   
     <?php
      }else{
  ?>
<tr>
    <td class="text-center"><?=$data['id'];?></td>
    <td class="text-left"><?=$data['name'];?></td>
    <td  class="text-center"><?=$data['man'];?></td>
    <td  class="text-center"><?=$data['female'];?></td>    
    <td  class="text-center"><?=$data['unit'];?></td>       
</tr>
 <?php
  }
  }
  ?>                 
</tbody>
</table>
</div>
    <div class="col-md-1"></div>    
</div>
</div>