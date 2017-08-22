<?php
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\grid\FormulaColumn;
use kartik\mpdf\Pdf;
use kartik\helpers\Html;

?>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?= $mText; ?></h3>
        <ul class="pull-right breadcrumb">
            <li><?= Html::a('Home', ['/site/index']); ?></li>
            <li><?= Html::a($mText, ['/service/index1']); ?></li>
            <li class="active"><?=Html::a($names, ['/basic-gen/basic-gen21']); ?></li>
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
                'attribute'=>'spname',
                'label'=>'รายการแผนก/สาขา',
                'vAlign'=>'middle',
                'hAlign'=>'left',  
                'pageSummary' => 'รวมทั้งหมด',          
            ],       
            [ 
                'class'=>'\kartik\grid\DataColumn',        
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'total',
                'label'=>'จำนวนผู้ป่วยทั้งหมด',
                'vAlign'=>'middle',
                'hAlign'=>'center', 
                'format'=>'raw',        
                'pageSummary' => true,          
            ],
            [ 
                'class'=>'\kartik\grid\DataColumn',        
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'adjrw',
                'label'=>'ค่า Adjrw รวม',
                'vAlign'=>'middle',
                'hAlign'=>'center',           
                'pageSummary' => true,           
            ],
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'noper',
                'label'=>'กลุ่มไม่ผ่าตัด',
                'vAlign'=>'middle',
                'hAlign'=>'center', 
                'pageSummary' => true,           
            ],  
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'oper',
                'label'=>'กลุ่มผ่าตัด',
                'vAlign'=>'middle',
                'hAlign'=>'center',
                'format'=>'raw',
                'pageSummary' => true,            
            ],   
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'income',
                'label'=>'ค่าใช้จ่าย',
                'vAlign'=>'middle',
                'hAlign'=>'center',
                'format'=>['decimal',2],
                'pageSummary' => true,            
            ],              
        /*    [
                'class'=>'\kartik\grid\FormulaColumn',
                'header'=>'ค่า CMI',
                'vAlign'=>'middle',
                'hAlign'=>'center',
                'value'=>function($model,$key,$index,$widget){
                                $p=  compact('model','key','index');
                                return $widget->col(2,$p) !=0 ? $widget->col(3,$p)/$widget->col(2,$p):0;
                                //return $widget ->col(2,$p);
                },
                'format'=>['decimal',2],  
                'pageSummary' => true,    
                'pageSummaryFunc'=>  GridView::F_AVG        
            ],*/
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'cmi',
                'label'=>'ค่า CMI',
                'vAlign'=>'middle',
                'hAlign'=>'center',
                'format'=>['decimal',2],
                'pageSummary' => true,            
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
                'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;'.  $names    .'&nbsp;&nbsp; '.
                          ' &nbsp;&nbsp;ตั้งแต่วันที่    ' .  
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
    