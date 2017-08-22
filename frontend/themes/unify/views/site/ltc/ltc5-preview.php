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
            <li class="active"><?= Html::a($names, ['/ltc/ltc5-index']); ?></li>
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
    ],
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'cid',
        'header'=>'เลขประชาชน',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
    ],    
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'pname',
        'header'=>'ชื่อผู้ป่วย',
        'vAlign'=>'middle',
        'hAlign'=>'left',   
    ],    
    [   
        'headerOptions' => ['style'=>'text-align:center'],              
        'attribute'=>'birthdate',
        'header'=>'วันเกิด',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
    ],     
    [   
        'headerOptions' => ['style'=>'text-align:center'],              
        'attribute'=>'death_date',
        'header'=>'วันที่เสียชีวิต',
        'vAlign'=>'middle',
        'hAlign'=>'center',
        'value'=>function($data){
             return is_null($data['death_date'])?'':$data['death_date'];
        }
    ],  
    [   
        'headerOptions' => ['style'=>'text-align:center'],              
        'attribute'=>'village_moo',
        'header'=>'หมู่',
        'vAlign'=>'middle',
        'hAlign'=>'left',        
    ], 
    [
        'headerOptions' => ['style'=>'text-align:center'],            
        'attribute'=>'village_name',
        'header'=>'หมู่บ้าน/ชุมชน',
        'vAlign'=>'middle',
        'hAlign'=>'left',
        'format'=>'raw',        
    ],   
    [
        'headerOptions' => ['style'=>'text-align:center'],            
        'attribute'=>'name504',
        'header'=>'สาเหตุหลัก',
        'vAlign'=>'middle',
        'hAlign'=>'left',
        'format'=>'raw',
        'value'=>function($data){
             return is_null($data['name504'])?'':$data['name504'];
        }                
    ],   
    [
        'headerOptions' => ['style'=>'text-align:center'],            
        'attribute'=>'icdname',
        'header'=>'การวินิจฉัย',
        'vAlign'=>'middle',
        'hAlign'=>'left',
        'format'=>'raw',        
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
'summary' => "{begin} - {end} {count} {totalCount} {page} {pageCount}",  
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']], 
'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;' .  $names . '  (  ' .  $text . ' ) </h3>',
],
'toolbar' => [ 
$fullExportMenu,
]
]);
?>
</div>
