<?php
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\mpdf\Pdf;
use kartik\helpers\Html;
use miloschuman\highcharts\Highcharts;
/*
$this->title =$names;
$this->params['breadcrumbs'][] = ['label' => $mText, 'url' =>['/basic/person1']]; 
$this->params['breadcrumbs'][] = $this->title;  
*/
?>
<div class="breadcrumbs">
    <div class="container">
        <h4 class="pull-left">&nbsp;</h4>
        <ul class="pull-right breadcrumb">
            <li><?=Html::a('Home',['/site/index']);?></li>
            <li><?= Html::a($mText, ['/service/index1']); ?></li>
            <li class="active"><?=Html::a($names, ['/basic-gen/basic-gen1']); ?></li>
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
<div class="panel panel-warning">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                    ข้อมูลประชาการในเขตรับผิดชอบ(บัญชี 1) ทั้งหมด <?=$total?> คน ชาย = <?=$man?> หญิง = <?=$fman?> คน
                            </div>
</div>    
<div id="chart1" class="service-info margin-left-5">
<?php
$this->registerJs("$(function () {
    $('#chart1').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'แผนภูมิแท่งเปรียบเทียบประชากร'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: '<b>คน</b>'
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
            name:'ประชากร',
            colorByPoint: true,
            data:$main
            
        }
        ],
        drilldown: {
            series:$sub
            
        }
    });
});", yii\web\View::POS_END);
?>
</div>    

