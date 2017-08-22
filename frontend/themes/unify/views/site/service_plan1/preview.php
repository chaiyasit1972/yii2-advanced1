<?php
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\mpdf\Pdf;
use kartik\helpers\Html;
  
?>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?= $mText; ?></h3>
        <ul class="pull-right breadcrumb">
            <li><?= Html::a('Home', ['/site/index']); ?></li>
            <li><?= Html::a($mText, ['/service/index3']); ?></li>
            <li class="active"><?= Html::a($names,['service-plan1/index']); ?></li>
        </ul>
    </div>
</div>
<div class="page-content margin-left-5 margin-right-5">
<?php
$gridColumns = [
    [
        'class' => '\kartik\grid\SerialColumn',
        'header' => 'ลำดับที่',
        'headerOptions' => ['style'=>'text-align:center'],
        'hAlign'=>'center',
        'width'=>'60px',
        'hidden'=>false
    ],          
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'pname',
        'label'=>'ตัวชี้วัด',
        'vAlign'=>'middle',
        'hAlign'=>'left',   
    ],    
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'goal',
        'label'=>'เป้าหมาย',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
    ],      
    [ 
        'headerOptions' => ['style'=>'text-align:center'],       
        'attribute'=>'oct',
        'label'=>'ต.ค.'.  substr($yrs-1, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',    
    ],      
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'nov',
        'label'=>'พ.ย.'.  substr($yrs-1, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',      
    ],       
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'dec',
        'label'=>'ธ.ค.'.  substr($yrs-1, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',    
    ],    
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'jan',
        'label'=>'ม.ค.'.  substr($yrs, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',    
    ],     
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'feb',
        'label'=>'ก.พ.'.  substr($yrs, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',    
    ],     
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'mar',
        'label'=>'มี.ค.'.  substr($yrs, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',    
    ],     
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'apr',
        'label'=>'เม.ย.'.  substr($yrs, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',     
    ],     
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'may',
        'label'=>'พ.ค.'.  substr($yrs, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',    
    ],      
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'jun',
        'label'=>'มิ.ย.'.  substr($yrs, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',     
    ],   
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'jul',
        'label'=>'ก.ค.'.  substr($yrs, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',    
    ],    
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'aug',
        'label'=>'ส.ค.'.  substr($yrs, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',    
    ],  
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'sep',
        'label'=>'ก.ย.'.  substr($yrs, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',    
    ],    
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'total',
        'label'=>'รวมทั้งหมด',
        'vAlign'=>'middle',
        'hAlign'=>'center',
        'format' => ['decimal',0]
    ],        
];
$fullExportMenu = ExportMenu::widget([
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
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']], 
'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp; ' .$names.' ตั้งแต่วันที่    ' .  
                  Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                  Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
],  
                      'beforeHeader'=>[
                             [
                                     'columns'=>[
                                            ['content'=>'', 'options'=>['colspan'=>3, 'class'=>'text-center warning']], 
                                            ['content'=>'ผลการดำเนินงาน', 'options'=>['colspan'=>12, 'class'=>'text-center warning']], 
                                            ['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center warning']],                                          
                                     ],
                                     'options'=>['class'=>'skip-export'] 
                             ]
                      ],     
'toolbar' => [ 
$fullExportMenu,
]
]);
?>
</div>
