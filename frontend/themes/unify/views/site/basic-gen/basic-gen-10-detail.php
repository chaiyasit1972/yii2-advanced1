<?php

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\mpdf\Pdf;
use prawee\assets\PwAsset;

PwAsset::register($this);

?>
<div class="box box-info">
   <?php
$gridColumns = [
    [
        'class' => '\kartik\grid\SerialColumn',
        'header' => 'ลำดับที่',
        'headerOptions' => ['style'=>'text-align:center'],
        'hAlign'=>'center',
        'width'=>'60px',
    ],  
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'icd10',
        'label'=>'รหัสโรค',
        'vAlign'=>'middle',
        'hAlign'=>'center',             
       ],    
    [   
        'headerOptions' => ['style'=>'text-align:center'],        
        'attribute'=>'diag',
        'label'=>'การวินิจฉัย',
        'vAlign'=>'middle',   
        'pageSummary' => 'รวมทั้งหมด',           
    ],       
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'cc',
        'label'=>'จำนวนทั้งหมด',
        'vAlign'=>'middle',
        'hAlign'=>'center', 
        'format'=>'raw',  
        'pageSummary' => true,          
    ],
  ];
$fullExportMenu = ExportMenu::widget([
'options'=>['id' => 'expt1'],   
'dataProvider' => $dataProvider,
'columns' => $gridColumns,
'target' => ExportMenu::TARGET_BLANK,
'exportConfig' => [
    ExportMenu::FORMAT_TEXT => false,
    ExportMenu::FORMAT_PDF => false,
    ExportMenu::FORMAT_HTML => false,
],    
'fontAwesome' => true,
'rowOptions' => ['class' => GridView::TYPE_DANGER],    
'pjaxContainerId' => 'kv-pjax-container',
'columnSelectorOptions'=>[
        'label' => 'Cols',
        'class' => 'btn btn-success btn-sm ',    
],        
'dropdownOptions' => [
'label' => 'Export All',
'class' => 'btn btn-danger btn-sm',
'itemsBefore' => [
'<li class="dropdown-header">Export All Data</li>',
],
],
]);
echo GridView::widget([
'dataProvider' => $dataProvider,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hoverr'],   
'responsive' => true,
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => [
       'neverTimeout'=>true,
       'enablePushState' => false,
       'options' => ['id' => 'kv-pjax-container']
], 
'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp; 10 อันดับโรคแรก แผนก  &nbsp;&nbsp;'.
          $sname. ' ตั้งแต่วันที่    ' .  
                  Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                  Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
],
'showPageSummary'=>true,        
'toolbar' => [ 
'{export}',
//$fullExportMenu,
]
]);

?>

</div>

