<?php
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\mpdf\Pdf;

?>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?= $mText; ?></h3>
        <ul class="pull-right breadcrumb">
            <li><?= Html::a('Home', ['/site/index']); ?></li>
            <li><?= Html::a($mText, ['/service/index1']); ?></li>
            <li class="active"><?=Html::a($names, ['/basic-gen/basic-gen20']); ?></li>
        </ul>
    </div>
</div><div class="well-sm grid-view">
 <div class="row margin-left-5 margin-right-5">
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
                'attribute'=>'names',
                'label'=>'รายการข้อมูล',
                'vAlign'=>'middle',
                'hAlign'=>'left',     
                //'group'=>true,  // enable grouping,
                //'groupedRow'=>true,
            ],    
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'detail',
                'label'=>'รายการหน่วยนับ',
                'vAlign'=>'middle',
                'hAlign'=>'left',  
            ],   
            [
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'October',
                'label'=>'ต.ค.',
                'vAlign'=>'middle',
                'hAlign'=>'center', 
                'value'=>function($data){
                    return number_format($data['October'],2);
                }
            ],
            [
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'November',
                'label'=>'พ.ย.',
                'vAlign'=>'middle',
                'hAlign'=>'center', 
                'value'=>function($data){
                    return number_format($data['November'],2);
                }        
            ],
            [
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'December',
                'label'=>'ธ.ค.',
                'vAlign'=>'middle',
                'hAlign'=>'center', 
                'value'=>function($data){
                    return number_format($data['December'],2);
                }        
            ],
            [
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'January',
                'label'=>'ม.ค.',
                'vAlign'=>'middle',
                'hAlign'=>'center',
                'value'=>function($data){
                    return number_format($data['January'],2);
                }        
            ],  
            [
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'February',
                'label'=>'ก.พ.',
                'vAlign'=>'middle',
                'hAlign'=>'center',
                'value'=>function($data){
                    return number_format($data['February'],2);
                }        
            ],
            [
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'March',
                'label'=>'มี.ค.',
                'vAlign'=>'middle',
                'hAlign'=>'center', 
                'value'=>function($data){
                    return number_format($data['March'],2);
                }        
            ],
            [
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'April',
                'label'=>'เม.ย.',
                'vAlign'=>'middle',
                'hAlign'=>'center', 
                'value'=>function($data){
                    return number_format($data['April'],2);
                }        
            ],
            [
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'May',
                'label'=>'พ.ค.',
                'vAlign'=>'middle',
                'hAlign'=>'center', 
                'value'=>function($data){
                    return number_format($data['May'],2);
                }        
            ],  
            [
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'June',
                'label'=>'มิ.ย.',
                'vAlign'=>'middle',
                'hAlign'=>'center', 
                'value'=>function($data){
                    return number_format($data['June'],2);
                }        
            ],
            [
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'July',
                'label'=>'ก.ค.',
                'vAlign'=>'middle',
                'hAlign'=>'center', 
                'value'=>function($data){
                    return number_format($data['July'],2);
                }        
            ],
            [
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'August',
                'label'=>'ส.ค.',
                'vAlign'=>'middle',
                'hAlign'=>'center', 
                'value'=>function($data){
                    return number_format($data['August'],2);
                }        
            ],
            [
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'September',
                'label'=>'ก.ย.',
                'vAlign'=>'middle',
                'hAlign'=>'center', 
                'value'=>function($data){
                    return number_format($data['September'],2);
                }        
            ],      
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'total',
                'label'=>'จำนวนทั้งหมด',
                'vAlign'=>'middle',
                'hAlign'=>'center',  
                'value'=>function($data){
                    return number_format($data['total'],2);
                },        
                //'pageSummary'=>true
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
   ]
);
echo GridView::widget([
'dataProvider' => $dataProvider,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hoverr'],    
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']], 
'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h6 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;'. $names .  '  ' .  $tname .   ' ตั้งแต่วันที่    ' .  
                  Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                  Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
],
'beforeHeader'=>[
        [
            'columns'=>[
                ['content'=>'', 'options'=>['colspan'=>3, 'class'=>'text-center warning']], 
                ['content'=>'รายเดือน', 'options'=>['colspan'=>12, 'class'=>'text-center warning']], 
                ['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center warning']],                 
            ],
            'options'=>['class'=>'skip-export']
        ]
],  
'showPageSummary'=>true,    
'toolbar' => [ 
     $fullExportMenu,
     ['content'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      &nbsp;&nbsp;'
     ],  
]
]);
?>            
 </div>     
</div>
