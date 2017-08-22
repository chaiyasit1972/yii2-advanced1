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
            <li><?= Html::a($mText, ['/service/index1']); ?></li>
            <li class="active"><?=Html::a($names, ['/basic-gen/basic-gen14']); ?></li>
        </ul>
    </div>
</div>
<div class="page-content margin-left-5 margin-right-5">
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
                'attribute'=>'pdx',
                'label'=>'รหัสโรค',
                'vAlign'=>'middle',
                'hAlign'=>'left',     
            ],       
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'diag',
                'label'=>'ชื่อโรค',
                'vAlign'=>'middle',
                'hAlign'=>'left',   
            ],  
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'num',
                'label'=>'จำนวนผู้ป่วย',
                'vAlign'=>'middle',
                'hAlign'=>'center',     
            ],      
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'total',
                'label'=>'ค่าใช้จ่ายทั้งหมด',
                'vAlign'=>'middle',
                'hAlign'=>'center',
                'format'=>['decimal',2],
            ],  
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'rate',
                'label'=>'ค่าใช้จ่ายเฉลี่ย',
                'vAlign'=>'middle',
                'hAlign'=>'center',
                'format'=>['decimal',2],                
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
                'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;'.  $names . ' ตั้งแต่วันที่    ' .  
                          Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                          Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
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