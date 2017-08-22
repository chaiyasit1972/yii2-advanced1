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
                Html::a($mText, ['/practice/index']);
                ;
                ?></li>
            <li class="active"><?= Html::a($names, ['/practice/practice6-index']); ?></li>
        </ul>
    </div>
</div>
<div class="service-info margin-left-10 margin-right-10">
<?php
$gridColumns = [
    [
        'class' => '\kartik\grid\SerialColumn',
        'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],        
        'header' => 'ลำดับที่',
        'hAlign'=>'center',
        'width'=>'60px',
        'hidden'=>false
    ],
    [  
        'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],                
        'attribute'=>'cid',
        'label'=>'เลขประชาชน',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
    ],    
    [  
        'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],                
        'attribute'=>'hn',
        'label'=>'เลขดัชนี',
        'vAlign'=>'middle',
        'hAlign'=>'center',  
        'value'=>function($data){
               return is_null($data['hn'])?'':$data['hn'];
        }
    ],
    [ 
        'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],        
        'attribute'=>'pname',
        'label'=>'ชื่อผู้ป่วย',
        'vAlign'=>'middle',
        'hAlign'=>'left',   
    ],   
    [  
        'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],                
        'attribute'=>'birthday',
        'label'=>'วันเกิด',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
        'value'=>function($data){
               return is_null($data['birthday'])?'':$data['birthday'];
        }          
    ],    
    [   
        'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],                
        'attribute'=>'addrpart',
        'label'=>'บ้านเลขที่',
        'vAlign'=>'middle',
        'hAlign'=>'left',   
        'value'=>function($data){
               return is_null($data['addrpart'])?'':$data['addrpart'];
        }        
    ],    
    [
        'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],                
        'attribute'=>'moopart',
        'label'=>'หมู่ที่',
        'vAlign'=>'middle',
        'hAlign'=>'center',
        'format'=>'raw',
        'value'=>function($data){
               return is_null($data['moopart'])?'':$data['moopart'];
        }        
    ],    
    [ 
        'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],        
        'attribute'=>'tmb',
        'label'=>'ตำบล',
        'vAlign'=>'middle',
        'hAlign'=>'left',    
        'value'=>function($data){
               return is_null($data['tmb'])?'':$data['tmb'];
        }          
    ],      
    [ 
        'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],              
        'attribute'=>'amp',
        'label'=>'อำเภอ',
        'vAlign'=>'middle',
        'hAlign'=>'left',  
        'value'=>function($data){
               return is_null($data['amp'])?'':$data['amp'];
        }          
    ],    
    [ 
        'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],         
        'attribute'=>'chw',
        'label'=>'จังหวัด',
        'vAlign'=>'middle',
        'hAlign'=>'left',     
        'value'=>function($data){
               return is_null($data['chw'])?'':$data['chw'];
        }          
    ],  
    [ 
        'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],             
        'attribute'=>'vaccine_date',
        'label'=>'วันที่รับบริการ',
        'vAlign'=>'middle',
        'hAlign'=>'left',   
    ],      
    [ 
        'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],              
        'attribute'=>'student_vaccine_name',
        'label'=>'ชื่อวัคซีน',
        'vAlign'=>'middle',
        'hAlign'=>'left',      
    ],          
];
$fullExportMenu = ExportMenu::widget([
'dataProvider' => $dataProvider,
'columns' => $gridColumns,
'target'=>  ExportMenu::TARGET_POPUP,
'exportConfig' => [
    ExportMenu::FORMAT_TEXT => false,
    ExportMenu::FORMAT_PDF => false,
    ExportMenu::FORMAT_HTML => false,
],    
'fontAwesome' => true,
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
'tableOptions' =>['class'=>'table table-striped table-bordered table-hover dataTable'],    
'summary' =>"แสดง {begin} - {end} จาก {totalCount} record",       
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']], 
'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '&nbsp;' .  $names . 
                  Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '.  Yii::$app->mycomponent->ShortDateThai($date2),
],
'exportConfig' => [
       GridView::PDF => ['label' => 'Save as Pdf'],
],    
'export' => [             
       'label' => 'PDF',
       'fontAwesome' => true,
       'options' => [
            'class' => 'btn btn-info btn-sm',
       ],
],  
'toolbar' => [ 
//'{export}',
$fullExportMenu,
['content'=>"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" ],    
]
]);
?>
</div>
