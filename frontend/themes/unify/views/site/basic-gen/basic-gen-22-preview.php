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
            <li class="active"><?=Html::a($names, ['/basic-gen/basic-gen22']); ?></li>
        </ul>
    </div>
</div>
<div class="page-content margin-left-5 margin-right-5">
<?php
        $gridColumns = [
            [     
                'headerOptions' => ['style'=>'text-align:center'],
                'attribute'=>'mdc',
                'label'=>'MDC',           
                'hAlign'=>'center',
                'width'=>'60px',
            ],        
            [   
                'headerOptions' => ['style'=>'text-align:center'],        
                'attribute'=>'mdc_name',
                'label'=>'ชื่อกลุ่มโรค',
                'vAlign'=>'middle',
                'hAlign'=>'left',  
                'pageSummary' => 'รวมทั้งหมด',          
            ],       
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'total',
                'label'=>'จำนวน',
                'vAlign'=>'middle',
                'hAlign'=>'center', 
                'format'=>'raw',        
                'pageSummary' => true,          
            ],   
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'adjrw',
                'label'=>'ค่า Adjrw รวม',
                'vAlign'=>'middle',
                'hAlign'=>'center',           
                'pageSummary' => true,           
            ],  
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'cmi',
                'label'=>'ค่า CMI',
                'vAlign'=>'middle',
                'hAlign'=>'center',
                'format'=>'raw',      
                'pageSummary' => true,            
            ],   

            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'noper',
                'label'=>'จำนวน',
                'vAlign'=>'middle',
                'hAlign'=>'center', 
                'format'=>'raw',        
                'pageSummary' => true,          
            ],   
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'noper_adjrw',
                'label'=>'ค่า Adjrw รวม',
                'vAlign'=>'middle',
                'hAlign'=>'center',           
                'pageSummary' => true,           
            ],  
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'noper_cmi',
                'label'=>'ค่า CMI',
                'vAlign'=>'middle',
                'hAlign'=>'center',
                'format'=>'raw',      
                'pageSummary' => true,            
            ],   

            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'oper',
                'label'=>'จำนวน',
                'vAlign'=>'middle',
                'hAlign'=>'center', 
                'format'=>'raw',        
                'pageSummary' => true,          
            ],   
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'oper_adjrw',
                'label'=>'ค่า Adjrw รวม',
                'vAlign'=>'middle',
                'hAlign'=>'center',           
                'pageSummary' => true,           
            ],  
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'oper_cmi',
                'label'=>'ค่า CMI',
                'vAlign'=>'middle',
                'hAlign'=>'center',
                'format'=>'raw',      
                'value'=>function($data){
                     return is_null($data['oper_cmi'])?'':$data['oper_cmi'];
                },
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
        'beforeHeader'=>[
                [
                    'columns'=>[
                        ['content'=>'', 'options'=>['colspan'=>2, 'class'=>'text-center warning']], 
                        ['content'=>'ทั้งหมด', 'options'=>['colspan'=>3, 'class'=>'text-center warning']], 
                        ['content'=>'กลุ่มโรคไม่ผ่าตัด', 'options'=>['colspan'=>3, 'class'=>'text-center warning']],
                        ['content'=>'กลุ่มโรคผ่าตัด', 'options'=>['colspan'=>3, 'class'=>'text-center warning']],                  
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
    