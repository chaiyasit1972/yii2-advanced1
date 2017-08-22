<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\mpdf\Pdf;
use kartik\helpers\Html;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

?>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?=$mText;?></h3>
        <ul class="pull-right breadcrumb">
            <li><?=Html::a('Home',['/site/index']);?></li>
            <li><?=Html::a($mText,['/service/index1']);;?></li>
            <li class="active"><?=$names;?></li>
        </ul>
    </div>
</div>
<div class="service-info"> 
    <div class="row">
        <div class="col-md-4 margin-left-5">
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
        'attribute'=>'year',
        'label'=>'ปี พ.ศ.',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
        'pageSummary' => 'Total',              
    ],    
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'totalm',
        'label'=>'ชาย',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
        'pageSummary' => true,              
    ],           
    [   
        'headerOptions' => ['style'=>'text-align:center'],        
        'attribute'=>'totalf',
        'label'=>'หญิง',
        'vAlign'=>'middle',
        'hAlign'=>'left', 
        'pageSummary' => true,        
    ],   
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'total',
        'label'=>'รวมทั้งหมด',
        'vAlign'=>'middle',
        'hAlign'=>'center',  
        'pageSummary'=>true
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
        'heading' => '<h6 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;</h6>',
],
'beforeHeader'=>[
        [
            'columns'=>[
                ['content'=>'', 'options'=>['colspan'=>2, 'class'=>'text-center warning']], 
                ['content'=>'จำนวน', 'options'=>['colspan'=>2, 'class'=>'text-center warning']], 
                ['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center warning']],                 
            ],
            'options'=>['class'=>'skip-export'] // remove this row from export
        ]
],  
'showPageSummary'=>true,    
'toolbar' => [ 
$fullExportMenu,
        ['content'=>''],        
]
]);
?>            
        </div>
        <div class="col-md-7  margin-left-5">         
<?php
echo Highcharts::widget([
    'scripts' => [
        'modules/exporting',
        'themes/sand-signika',        
        //'modules/drilldown',
        
    ],
    'options' => [
        'title' => [
            'text' => 'ข้อมูลการเกิด(การคลอด) ในเขตรับผิดชอบ',
        ],
        'xAxis' => [
            'categories' => $year//['Apples', 'Oranges', 'Pears', 'Bananas', 'Plums'],
        ],
        'labels' => [
            'items' => [
                [
                    'html' => 'ข้อมูลการเกิด ในเขตรับผิดชอบ',
                    'style' => [
                        'left' => '50px',
                        'top' => '18px',
                        'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                    ],
                ],
            ],
        ],
        'series' => [
            [
                'type' => 'column',
                'name' => 'ชาย',
                'data' => $man,
            ],
            [
                'type' => 'column',
                'name' => 'หญิง',
                'data' => $fman,
            ],
            [
                'type' => 'column',
                'name' => 'ทั้งหมด',
                'data' => $total,
            ],
            [
                'type' => 'spline',
                'name' => 'Average',
                'data' => $total, // [3, 2.67, 3, 6.33, 3.33],
                'marker' => [
                    'lineWidth' => 2,
                    'lineColor' => new JsExpression('Highcharts.getOptions().colors[4]'),
                    'fillColor' => 'white',
                ],
            ],
         /*  [
                'type' => 'pie',
                'name' => 'Total consumption',
                'data' => [
                    [
                        'name' => 'Jane',
                        'y' => 13,
                        'color' => new JsExpression('Highcharts.getOptions().colors[0]'), // Jane's color
                    ],
                    [
                        'name' => 'John',
                        'y' => 23,
                        'color' => new JsExpression('Highcharts.getOptions().colors[1]'), // John's color
                    ],
                    [
                        'name' => 'Joe',
                        'y' => 19,
                        'color' => new JsExpression('Highcharts.getOptions().colors[2]'), // Joe's color
                    ],
                ],
                'center' => [100, 80],
                'size' => 100,
                'showInLegend' => false,
                'dataLabels' => [
                    'enabled' => false,
                ],
            ],*/
        ],
    ]
]);
?>
        </div>        
    </div>
</div>
