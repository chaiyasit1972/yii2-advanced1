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
                Html::a($mText, ['/suka/index']);
                ;
                ?></li>
            <li class="active"><?= Html::a($names, ['/suka/suka2-index']); ?></li>
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
        'attribute'=>'cid',
        'label'=>'cid',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
    ],     
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'hn',
        'label'=>'HN',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
    ],     
    [   
        'headerOptions' => ['style'=>'text-align:center'],        
        'attribute'=>'pname',
        'label'=>'ชื่อ - สกุล',
        'vAlign'=>'middle',
        'hAlign'=>'left',   
        'format'=>'raw',        
    ],       
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'birthday',
        'label'=>'วันเกิด',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
    ],   
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'age_y',
        'label'=>'อายุ',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
    ],       
    [ 
        'headerOptions' => ['style'=>'text-align:center'],       
        'attribute'=>'addrpart',
        'label'=>'บ้านเลขที่',
        'vAlign'=>'middle',
        'hAlign'=>'center',    
    ],     
    [ 
        'headerOptions' => ['style'=>'text-align:center'],       
        'attribute'=>'moopart',
        'label'=>'หมู่',
        'vAlign'=>'middle',
        'hAlign'=>'center',    
    ],   
    [ 
        'headerOptions' => ['style'=>'text-align:center'],       
        'attribute'=>'village_name',
        'label'=>'หมู่บ้าน/ชุมชน',
        'vAlign'=>'middle',
        'hAlign'=>'left',    
    ],     
    [ 
        'headerOptions' => ['style'=>'text-align:center'],       
        'attribute'=>'icd10',
        'label'=>'icd10',
        'vAlign'=>'middle',
        'hAlign'=>'center',    
    ], 
    [ 
        'headerOptions' => ['style'=>'text-align:center'],       
        'attribute'=>'diag',
        'label'=>'Diagnosis',
        'vAlign'=>'middle',
        'hAlign'=>'left',    
    ],   
    [ 
        'headerOptions' => ['style'=>'text-align:center'],       
        'attribute'=>'vstdate',
        'label'=>'วันที่เริ่มวินิจฉัย',
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
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;' . $names. '  โรค  '. $type . '  ' . $moo. '</h3>',
],
'toolbar' => [ 
//'{export}',
$fullExportMenu,
]
]);
?>
</div>
