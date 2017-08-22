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
            <li><?=
                Html::a($mText, ['/ltc/index']);
                ;
                ?></li>
            <li class="active"><?= Html::a($names, ['/ltc/ltc3-index']); ?></li>
        </ul>
    </div>
</div>
<div class="service-info margin-left-5 margin-right-5">
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
        'attribute'=>'hn',
        'label'=>'เลขดัชนี',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
    ],       
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'pname',
        'label'=>'ชื่อผูป่วย',
        'vAlign'=>'middle',
        'hAlign'=>'left',   
    ],    
    [   
        'headerOptions' => ['style'=>'text-align:center'],              
        'attribute'=>'birthdate',
        'label'=>'วันเกิด',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
        'value'=>function($data){
            return Yii::$app->mycomponent->ShortDateThai($data['birthdate']); 
        }
    ],     
    [
        'headerOptions' => ['style'=>'text-align:center'],            
        'attribute'=>'visitdate',
        'label'=>'วันเยี่ยม',
        'vAlign'=>'middle',
        'hAlign'=>'left',
        'format'=>'raw',    
        'value'=>function($data){
            return Yii::$app->mycomponent->ShortDateThai($data['visitdate']); 
        }        
    ],    
    [ 
        'headerOptions' => ['style'=>'text-align:center'],       
        'attribute'=>'October',
        'label'=>'ต.ค.',
        'vAlign'=>'middle',
        'hAlign'=>'left',    
    ],      
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'November',
        'label'=>'พ.ย.',
        'vAlign'=>'middle',
        'hAlign'=>'left',     
    ],       
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'December',
        'label'=>'ธ.ค.',
        'vAlign'=>'middle',
        'hAlign'=>'left',     
    ],    
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'January',
        'label'=>'ม.ค.',
        'vAlign'=>'middle',
        'hAlign'=>'left',     
    ],     
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'February',
        'label'=>'ก.พ.',
        'vAlign'=>'middle',
        'hAlign'=>'left',     
    ],     
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'March',
        'label'=>'มี.ค.',
        'vAlign'=>'middle',
        'hAlign'=>'left',     
    ],     
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'April',
        'label'=>'เม.ย.',
        'vAlign'=>'middle',
        'hAlign'=>'left',     
    ],     
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'May',
        'label'=>'พ.ค.',
        'vAlign'=>'middle',
        'hAlign'=>'left',     
    ],      
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'June',
        'label'=>'มิ.ย.',
        'vAlign'=>'middle',
        'hAlign'=>'left',     
    ],   
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'July',
        'label'=>'ก.ค.',
        'vAlign'=>'middle',
        'hAlign'=>'left',     
    ],    
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'August',
        'label'=>'ส.ค.',
        'vAlign'=>'middle',
        'hAlign'=>'left',     
    ],  
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'September',
        'label'=>'ก.ย.',
        'vAlign'=>'middle',
        'hAlign'=>'left',     
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
//'summary' => "{begin} - {end} {count} {totalCount} {page} {pageCount}",  
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']], 
'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;รายงานการเยี่ยมบ้าน ' .  $type_n .
                  ' หมู่ ' . $village_moo . '  '.  $village_name . ' ตั้งแต่วันที่    ' .  
                  Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                  Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
],
'toolbar' => [ 
//'{export}',
$fullExportMenu,
]
]);
?>
</div>
