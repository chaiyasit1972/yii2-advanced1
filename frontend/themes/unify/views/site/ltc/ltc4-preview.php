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
            <li class="active"><?= Html::a($names, ['/ltc/ltc4-index']); ?></li>
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
        'attribute'=>'hn',
        'header'=>'HN',
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
        'attribute'=>'age_y',
        'header'=>'อายุ',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
    ],     
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'addrpart',
        'header'=>'บ้านเลขที่',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
    ],     
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'moopart',
        'header'=>'หมู่ที่',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
    ],     
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'tmb',
        'header'=>'ตำบล',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
    ],     
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'amp',
        'header'=>'อำเภอ',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
    ],     
        [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'chw',
        'header'=>'จังหวัด',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
    ], 
    [   
        'headerOptions' => ['style'=>'text-align:center'],              
        'attribute'=>'register_date',
        'header'=>'วันขึ้นทะเบียน',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
    ],     
    [   
        'headerOptions' => ['style'=>'text-align:center'],              
        'attribute'=>'discharge_date',
        'header'=>'วันที่จำหน่าย',
        'vAlign'=>'middle',
        'hAlign'=>'center',
        'value'=>function($data){
             return is_null($data['discharge_date'])?'':$data['discharge_date'];
        },
        'hidden' => true                  
    ],  
    [   
        'headerOptions' => ['style'=>'text-align:center'],              
        'attribute'=>'discharge',
        'header'=>'สถานะจำหน่าย',
        'vAlign'=>'middle',
        'hAlign'=>'center', 
        'value'=>function($data){
             return is_null($data['discharge'])?'':$data['discharge'];
        },
        'hidden' => true        
    ], 
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'clinic',
        'header'=>'clinic',
        'vAlign'=>'middle',
        'hAlign'=>'left', 
        'value'=>function($data){
             return is_null($data['clinic'])?'':$data['clinic'];
        }           
    ],   
    [
        'headerOptions' => ['style'=>'text-align:center'],            
        'attribute'=>'remark',
        'header'=>'หมายเหตุ',
        'vAlign'=>'middle',
        'hAlign'=>'left',
        'format'=>'raw',  
        'value'=>function($data){
             return is_null($data['remark'])?'':$data['remark'];
        },
        'hidden' => true                  
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
/*'pager' => [
        'class' => 'justinvoelker\separatedpager\LinkPager',
],*/ 
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']], 
'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;' .  $names . '  (  ' .  $type_name . ' ) </h3>',
],
'toolbar' => [ 
$fullExportMenu,
]
]);
?>
</div>
