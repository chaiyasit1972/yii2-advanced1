<?php
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\mpdf\Pdf;
use kartik\helpers\Html;
use miloschuman\highcharts\Highcharts;

?>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?= $mText; ?></h3>
        <ul class="pull-right breadcrumb">
            <li><?= Html::a('Home', ['/site/index']); ?></li>
            <li><?=
                Html::a($mText, ['/opd/index']);
                ;
                ?></li>
            <li class="active"><?= Html::a($names, ['/opd/opd3-index']); ?></li>
        </ul>
    </div>
</div>
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
<div class="alert alert-danger margin-left-5 margin-right-5">
        <h4>     <?=$names .   'ตั้งแต่วันที่    ' .  
                  Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '.  Yii::$app->mycomponent->ShortDateThai($date2);?>
        </h4>     
</div>  
<div class="row service-info margin-left-5 margin-right-5">
<div class="col-md-6 col-sm-6">
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
                      'format'=>'decimal',
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
                             'itemsBefore' => ['<li class="dropdown-header">Export All Data</li>'],
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
                                     'options'=>['class'=>'skip-export'] 
                             ]
                      ],  
                      'showPageSummary'=>true,    
                      'toolbar' => [ 
                             $fullExportMenu,
                             ['content'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' 
                             ],               
                      ]
        ]);
?>            
</div>
<div class="col-md-6">    
<div id="chart1" class="box box-default col-md-12">
<?php
$this->registerJs("$(function () {
    $('#chart1').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'รายงาน 5 อันดับโรคผู้ป่วยนอก(9 แผนกหลัก) เรียงตาม $time'
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
            data:$main
            
        }
        ],

    });
});", yii\web\View::POS_END);
?>
</div>    
</div>
</div>
