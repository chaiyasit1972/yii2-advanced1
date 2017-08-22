<?php
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\mpdf\Pdf;
use kartik\helpers\Html;
use miloschuman\highcharts\Highcharts;
use kartik\tabs\TabsX;

?>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?= $mText; ?></h3>
        <ul class="pull-right breadcrumb">
            <li><?= Html::a('Home', ['/site/index']); ?></li>
            <li><?= Html::a($mText, ['/service/index1']); ?></li>
            <li class="active"><?=Html::a($names, ['/basic-gen/basic-gen18']); ?></li>
        </ul>
    </div>
</div>
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
                'attribute'=>'icd10',
                'label'=>'icd10',
                'vAlign'=>'middle',
                'hAlign'=>'left',   
                'pageSummary' => 'Total',              
            ],    
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'diag',
                'label'=>'diag',
                'vAlign'=>'middle',
                'hAlign'=>'left',  
            ],             
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'total',
                'label'=>'จำนวน',
                'vAlign'=>'middle',
                'hAlign'=>'center',  
                'pageSummary'=>true
            ],    
        ];
?>
<!--   content1-->
<?php
$fullExportMenu1 = ExportMenu::widget([
        'options'=>['id'=>'expt1'],    
        'dataProvider' => $dataProvider1,
        'columns' => $gridColumns,
        'target' => ExportMenu::TARGET_BLANK,
        'exportConfig' => [
            ExportMenu::FORMAT_TEXT => false,
            ExportMenu::FORMAT_PDF => false,
            ExportMenu::FORMAT_HTML => false,
        ],    
        'fontAwesome' => true,
        'rowOptions' => ['class' => GridView::TYPE_DANGER],    
        'pjaxContainerId' => 'kv-pjax-container1',
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
$grid1 = GridView::widget([
        'dataProvider' => $dataProvider1,
        'columns' => $gridColumns, 
        'tableOptions' =>['class'=>'table table-striped table-bordered table-hoverr'],    
        'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
        'pjax' => true, 
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container1']], 
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
        $fullExportMenu1,
        ]
]);
?>            
<?php
$graph1=$this->registerJs("$(function () {
    $('#chart1').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '$names '
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: '<b>ครั้ง</b>'
            },
        },
        legend: {
            enabled: true
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: [
        {
            name:'การวินิจฉัย',
            colorByPoint: true,
            data:$main1
            
        }
        ],

    });
});", yii\web\View::POS_END);
?>
<!--   content2-->
<?php
$fullExportMenu2 = ExportMenu::widget([
'options'=>['id'=>'expt2'],      
'dataProvider' => $dataProvider2,
'columns' => $gridColumns,
'target' => ExportMenu::TARGET_BLANK,
'exportConfig' => [
    ExportMenu::FORMAT_TEXT => false,
    ExportMenu::FORMAT_PDF => false,
    ExportMenu::FORMAT_HTML => false,
],    
'fontAwesome' => true,
'rowOptions' => ['class' => GridView::TYPE_DANGER],    
'pjaxContainerId' => 'kv-pjax-container2',
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
$grid2 = GridView::widget([
'dataProvider' => $dataProvider2,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hoverr'],    
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container2']], 
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
$fullExportMenu2,
]
]);
?>            
<?php
$graph2=$this->registerJs("$(function () {
    $('#chart2').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '$names '
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: '<b>ครั้ง</b>'
            },
        },
        legend: {
            enabled: true
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: [
        {
            name:'การวินิจฉัย',
            colorByPoint: true,
            data:$main2
            
        }
        ],

    });
});", yii\web\View::POS_END);
?>
<!--   content3-->
<?php
$fullExportMenu3 = ExportMenu::widget([
'options'=>['id'=>'expt3'],      
'dataProvider' => $dataProvider3,
'columns' => $gridColumns,
'target' => ExportMenu::TARGET_BLANK,
'exportConfig' => [
    ExportMenu::FORMAT_TEXT => false,
    ExportMenu::FORMAT_PDF => false,
    ExportMenu::FORMAT_HTML => false,
],    
'fontAwesome' => true,
'rowOptions' => ['class' => GridView::TYPE_DANGER],    
'pjaxContainerId' => 'kv-pjax-container3',
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
$grid3 = GridView::widget([
'dataProvider' => $dataProvider3,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hoverr'],    
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container3']], 
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
$fullExportMenu3,
]
]);
?>            
<?php
$graph3=$this->registerJs("$(function () {
    $('#chart3').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '$names '
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: '<b>ครั้ง</b>'
            },
        },
        legend: {
            enabled: true
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: [
        {
            name:'การวินิจฉัย',
            colorByPoint: true,
            data:$main3
            
        }
        ],

    });
});", yii\web\View::POS_END);
?>
<!--   content4-->
<?php
$fullExportMenu4 = ExportMenu::widget([
'options'=>['id'=>'expt4'],      
'dataProvider' => $dataProvider4,
'columns' => $gridColumns,
'target' => ExportMenu::TARGET_BLANK,
'exportConfig' => [
    ExportMenu::FORMAT_TEXT => false,
    ExportMenu::FORMAT_PDF => false,
    ExportMenu::FORMAT_HTML => false,
],    
'fontAwesome' => true,
'rowOptions' => ['class' => GridView::TYPE_DANGER],    
'pjaxContainerId' => 'kv-pjax-container4',
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
$grid4 = GridView::widget([
'dataProvider' => $dataProvider4,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hoverr'],    
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container4']], 
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
$fullExportMenu4,
]
]);
?>            
<?php
$graph4=$this->registerJs("$(function () {
    $('#chart4').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '$names '
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: '<b>ครั้ง</b>'
            },
        },
        legend: {
            enabled: true
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: [
        {
            name:'การวินิจฉัย',
            colorByPoint: true,
            data:$main4
            
        }
        ],

    });
});", yii\web\View::POS_END);
?>
<!--   content5-->
<?php
$fullExportMenu5 = ExportMenu::widget([
'options'=>['id'=>'expt5'],      
'dataProvider' => $dataProvider5,
'columns' => $gridColumns,
'target' => ExportMenu::TARGET_BLANK,
'exportConfig' => [
    ExportMenu::FORMAT_TEXT => false,
    ExportMenu::FORMAT_PDF => false,
    ExportMenu::FORMAT_HTML => false,
],    
'fontAwesome' => true,
'rowOptions' => ['class' => GridView::TYPE_DANGER],    
'pjaxContainerId' => 'kv-pjax-container5',
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
$grid5 = GridView::widget([
'dataProvider' => $dataProvider5,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hoverr'],    
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container5']], 
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
$fullExportMenu5,
]
]);
?>            
<?php
$graph5=$this->registerJs("$(function () {
    $('#chart5').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '$names '
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: '<b>ครั้ง</b>'
            },
        },
        legend: {
            enabled: true
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: [
        {
            name:'การวินิจฉัย',
            colorByPoint: true,
            data:$main5
            
        }
        ],

    });
});", yii\web\View::POS_END);
?>
<!--   content6-->
<?php
$fullExportMenu6 = ExportMenu::widget([
'options'=>['id'=>'expt6'],      
'dataProvider' => $dataProvider6,
'columns' => $gridColumns,
'target' => ExportMenu::TARGET_BLANK,
'exportConfig' => [
    ExportMenu::FORMAT_TEXT => false,
    ExportMenu::FORMAT_PDF => false,
    ExportMenu::FORMAT_HTML => false,
],    
'fontAwesome' => true,
'rowOptions' => ['class' => GridView::TYPE_DANGER],    
'pjaxContainerId' => 'kv-pjax-container6',
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
$grid6 = GridView::widget([
'dataProvider' => $dataProvider6,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hoverr'],    
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container6']], 
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
$fullExportMenu6,
]
]);
?>            
<?php
$graph6=$this->registerJs("$(function () {
    $('#chart6').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '$names '
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: '<b>ครั้ง</b>'
            },
        },
        legend: {
            enabled: true
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: [
        {
            name:'การวินิจฉัย',
            colorByPoint: true,
            data:$main6
            
        }
        ],

    });
});", yii\web\View::POS_END);
?>
<!--   content7-->
<?php
$fullExportMenu7 = ExportMenu::widget([
'options'=>['id'=>'expt7'],      
'dataProvider' => $dataProvider7,
'columns' => $gridColumns,
'target' => ExportMenu::TARGET_BLANK,
'exportConfig' => [
    ExportMenu::FORMAT_TEXT => false,
    ExportMenu::FORMAT_PDF => false,
    ExportMenu::FORMAT_HTML => false,
],    
'fontAwesome' => true,
'rowOptions' => ['class' => GridView::TYPE_DANGER],    
'pjaxContainerId' => 'kv-pjax-container7',
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
$grid7 = GridView::widget([
'dataProvider' => $dataProvider7,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hoverr'],    
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container7']], 
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
$fullExportMenu7,
]
]);
?>            
<?php
$graph7=$this->registerJs("$(function () {
    $('#chart7').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '$names '
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: '<b>ครั้ง</b>'
            },
        },
        legend: {
            enabled: true
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: [
        {
            name:'การวินิจฉัย',
            colorByPoint: true,
            data:$main7
            
        }
        ],

    });
});", yii\web\View::POS_END);
?>
<!--   content8-->
<?php
$fullExportMenu8 = ExportMenu::widget([
'options'=>['id'=>'expt8'],      
'dataProvider' => $dataProvider8,
'columns' => $gridColumns,
'target' => ExportMenu::TARGET_BLANK,
'exportConfig' => [
    ExportMenu::FORMAT_TEXT => false,
    ExportMenu::FORMAT_PDF => false,
    ExportMenu::FORMAT_HTML => false,
],    
'fontAwesome' => true,
'rowOptions' => ['class' => GridView::TYPE_DANGER],    
'pjaxContainerId' => 'kv-pjax-container8',
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
$grid8 = GridView::widget([
'dataProvider' => $dataProvider8,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hoverr'],    
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container8']], 
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
$fullExportMenu8,
]
]);
?>            
<?php
$graph8=$this->registerJs("$(function () {
    $('#chart8').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '$names '
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: '<b>ครั้ง</b>'
            },
        },
        legend: {
            enabled: true
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: [
        {
            name:'การวินิจฉัย',
            colorByPoint: true,
            data:$main8
            
        }
        ],

    });
});", yii\web\View::POS_END);
?>
<!--   content9-->
<?php
$fullExportMenu9 = ExportMenu::widget([
'options'=>['id'=>'expt9'],      
'dataProvider' => $dataProvider9,
'columns' => $gridColumns,
'target' => ExportMenu::TARGET_BLANK,
'exportConfig' => [
    ExportMenu::FORMAT_TEXT => false,
    ExportMenu::FORMAT_PDF => false,
    ExportMenu::FORMAT_HTML => false,
],    
'fontAwesome' => true,
'rowOptions' => ['class' => GridView::TYPE_DANGER],    
'pjaxContainerId' => 'kv-pjax-container9',
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
$grid9 = GridView::widget([
'dataProvider' => $dataProvider9,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hoverr'],    
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container9']], 
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
$fullExportMenu9,
]
]);
?>            
<?php
$graph9=$this->registerJs("$(function () {
    $('#chart9').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '$names '
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: '<b>ครั้ง</b>'
            },
        },
        legend: {
            enabled: true
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: [
        {
            name:'การวินิจฉัย',
            colorByPoint: true,
            data:$main9
            
        }
        ],

    });
});", yii\web\View::POS_END);
?>
<!--   content10-->
<?php
$fullExportMenu10 = ExportMenu::widget([
'options'=>['id'=>'expt10'],      
'dataProvider' => $dataProvider10,
'columns' => $gridColumns,
'target' => ExportMenu::TARGET_BLANK,
'exportConfig' => [
    ExportMenu::FORMAT_TEXT => false,
    ExportMenu::FORMAT_PDF => false,
    ExportMenu::FORMAT_HTML => false,
],    
'fontAwesome' => true,
'rowOptions' => ['class' => GridView::TYPE_DANGER],    
'pjaxContainerId' => 'kv-pjax-container10',
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
$grid10 = GridView::widget([
'dataProvider' => $dataProvider10,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hoverr'],    
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container10']], 
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
$fullExportMenu10,
]
]);
?>            
<?php
$graph10=$this->registerJs("$(function () {
    $('#chart10').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '$names '
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: '<b>ครั้ง</b>'
            },
        },
        legend: {
            enabled: true
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: [
        {
            name:'การวินิจฉัย',
            colorByPoint: true,
            data:$main10
            
        }
        ],

    });
});", yii\web\View::POS_END);
?>







<div style="display: none">
    <?php
    echo Highcharts::widget([
        'scripts' => [
            'highcharts-more', // enables supplementary chart types (gauge, arearange, columnrange, etc.)
            'modules/exporting', // adds Exporting button/menu to chart
            'themes/grid',       // applies global 'grid' theme to all charts
            'highcharts-3d',
            'modules/drilldown'
        ]
    ]);
    ?>
</div> 
<div class="nav-tabs-custom tab-content tab-bordered">    
<?= TabsX::widget([
    'position' => TabsX::POS_ABOVE,
    'align' => TabsX::ALIGN_LEFT,
    'encodeLabels' => false,
    'class' =>'nav-tabs-custom',
    'items' => [
        [
            'label' => '<small>ทั้งหมด</small>',
            'content' => '<div class="row"><div class="col-md-6 col-sm-6">'.$grid1.'</div>'.   
                              '<div id="chart1" class="box box-default col-sm-6">'.$graph1.'</div></div>',
            'active' => true, 
                       
        ],        
        [
            'label' => '<small>01-อายุรกรรม</small>',
            'content' => '<div class="row margin-left-5 margin-right-5"><div class="col-md-6 col-sm-6">'.$grid2.'</div>'.    
                              '<div id="chart2" class="box box-default col-sm-6">'.$graph2.'</div></div>',
        ],
        [
            'label' => '<small>02-ศัลยกรรมทั่วไป</small>',
            'content' => '<div class="row margin-left-5 margin-right-5"><div class="col-md-5 col-sm-12">'.$grid3.'</div>'.'
                              <div id="chart3" class="box box-default col-sm-7">'.$graph3.'</div></div>',
        ],
        [
            'label' => '<small>03-สูติกรรม</small>',
            'content' => '<div class="row margin-left-5 margin-right-5"><div class="col-md-5 col-sm-12">'.$grid4.'</div>'.'    
                              <div id="chart4" class="box box-default col-sm-7">'.$graph4.'</div></div>',
            'options' => ['id' => 'myID3'],
        ], 
        [
            'label' => '<small>04-นรีเวชกรรม</small>',
            'content' => '<div class="row margin-left-5 margin-right-5"><div class="col-md-5 col-sm-12">'.$grid5.'</div>'.'    
                              <div id="chart5" class="box box-default col-sm-7">'.$graph5.'</div></div>',
            'options' => ['id' => 'myID4'],
        ],        
        [
            'label' => '<small>05-กุมารเวชกรรม(ยกเว้น NICU)</small>',
            'content' => '<div class="row margin-left-5 margin-right-5"><div class="col-md-5 col-sm-12">'.$grid6.'</div>'.'    
                              <div id="chart6" class="box box-default col-sm-7">'.$graph6.'</div></div>',
            'options' => ['id' => 'myID5'],
        ],     
        [
            'label' => '<small>06-โสต ศอ นาสิก</small>',
            'content' => '<div class="row margin-left-5 margin-right-5"><div class="col-md-5 col-sm-12">'.$grid7.'</div>'.'    
                              <div id="chart7" class="box box-default col-sm-7">'.$graph7.'</div></div>',
            'options' => ['id' => 'myID6'],
        ],    
        [
            'label' => '<small>07-จักษุ</small>',
            'content' => '<div class="row margin-left-5 margin-right-5"><div class="col-md-5 col-sm-12">'.$grid8.'</div>'.'    
                              <div id="chart8" class="box box-default col-sm-7">'.$graph8.'</div></div>',
            'options' => ['id' => 'myID7'],
        ],   
        [
            'label' => '<small>08-ศัลยกรรมกระดูก</small>',
            'content' => '<div class="row margin-left-5 margin-right-5"><div class="col-md-5 col-sm-12">'.$grid9.'</div>'.'    
                              <div id="chart9" class="box box-default col-sm-7">'.$graph9.'</div></div>',
            'options' => ['id' => 'myID8'],
        ],   
        [
            'label' => '<small>NICU</small>',
            'content' => '<div class="row margin-left-5 margin-right-5"><div class="col-md-5 col-sm-12">'.$grid10.'</div>'.'    
                              <div id="chart10" class="box box-default col-sm-7">'.$graph10.'</div></div>',
            'options' => ['id' => 'myID9'],
        ],   
          
    ],
]);    ?>
</div>