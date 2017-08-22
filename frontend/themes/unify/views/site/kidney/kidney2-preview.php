<?php
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\mpdf\Pdf;
use kartik\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;

?>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?= $mText; ?></h3>
        <ul class="pull-right breadcrumb">
            <li><?= Html::a('Home', ['/site/index']); ?></li>
            <li><?=
                Html::a($mText, ['/kidney/index']);
                ;
                ?></li>
            <li class="active"><?= $names; ?></li>
        </ul>
    </div>
</div>
<?php
$gridColumns = [
    [
        'class' => '\kartik\grid\SerialColumn',
        'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],        
        'header' => 'ลำดับที่',
        'hAlign'=>'center',
        'width'=>'60px',
    ],
    [  
        'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],                
        'attribute'=>'names',
        'label'=>'โรค',
        'vAlign'=>'middle',
        'hAlign'=>'left',   
        'pageSummary'=>'รวมทั้งหมด'              
    ],
    [ 
        'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],        
        'attribute'=>'stage0',
        'header'=>'ปกติ<br>(eGFR>120)',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
        'pageSummary'=>true        
    ],       
    [ 
        'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],        
        'attribute'=>'stage1',
        'header'=>'stage1<br>(eGFR 90-120)',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
        'pageSummary'=>true        
    ],   
    [ 
        'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],        
        'attribute'=>'stage2',
        'header'=>'stage2<br>(eGFR 60-89)',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
        'pageSummary'=>true        
    ],     
    [ 
        'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],        
        'attribute'=>'stage3',
        'header'=>'stage3<br>(eGFR 30-59)',
        'vAlign'=>'middle',
        'hAlign'=>'center',  
        'pageSummary'=>true        
    ],      
    [ 
        'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],        
        'attribute'=>'stage4',
        'header'=>'stage4<br>(eGFR 15-29)',
        'vAlign'=>'middle',
        'hAlign'=>'center',
        'pageSummary'=>true        
    ],    
    [ 
        'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],        
        'attribute'=>'stage5',
        'header'=>'stage5<br>(eGFR<15)',
        'vAlign'=>'middle',
        'hAlign'=>'center', 
        'pageSummary'=>true        
    ],  
    [ 
        'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],        
        'header'=>'รวม',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
        'value'=>function($data){
             return $data['stage0']+$data['stage1']+$data['stage2']+$data['stage3']+$data['stage4']+$data['stage5'];
        },
        'pageSummary'=>true                
    ],      
    
];
$fullExportMenu1 = ExportMenu::widget([
            'options' => ['id'=>'expt1'],    
            'dataProvider' => $dataProvider1,
            'columns' => $gridColumns,
            'target'=>  ExportMenu::TARGET_POPUP,
            'exportConfig' => [
                ExportMenu::FORMAT_TEXT => false,
                ExportMenu::FORMAT_PDF => false,
                ExportMenu::FORMAT_HTML => false,
            ],    
            'fontAwesome' => true,
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
$fullExportMenu2 = ExportMenu::widget([
            'options' => ['id'=>'expt2'],    
            'dataProvider' => $dataProvider2,
            'columns' => $gridColumns,
            'target'=>  ExportMenu::TARGET_POPUP,
            'exportConfig' => [
                ExportMenu::FORMAT_TEXT => false,
                ExportMenu::FORMAT_PDF => false,
                ExportMenu::FORMAT_HTML => false,
            ],    
            'fontAwesome' => true,
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
$grid1 = GridView::widget([
            'dataProvider' => $dataProvider1,
            'columns' => $gridColumns, 
            'tableOptions' =>['class'=>'table table-striped table-bordered table-hover dataTable no-footer DTTT_selectable'],    
            'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",       
            'pjax' => true, 
            'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container1']], 
            'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;' .  $names .'   ตั้งแต่วันที่    ' .  
                              Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '.
                              Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
            ],
            'beforeHeader'=>[
                    [
                        'columns'=>[
                            ['content'=>'', 'options'=>['colspan'=>2, 'class'=>'text-center warning']], 
                            ['content'=>'การคัดกรองภาวะไตวาย(eGFR)', 'options'=>['colspan'=>6, 'class'=>'text-center warning']],  
                            ['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center warning']],                             
                        ],
                        'options'=>['class'=>'skip-export'] 
                    ]
            ],   
            'showPageSummary'=>true,      
            'toolbar' => [ 
            $fullExportMenu1,
            ['content'=>"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" ],    
            ]
]);
$grid2 = GridView::widget([
            'dataProvider' => $dataProvider2,
            'columns' => $gridColumns, 
            'tableOptions' =>['class'=>'table table-striped table-bordered table-hover dataTable no-footer DTTT_selectable'],    
            'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",       
            'pjax' => true, 
            'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container2']], 
            'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;' .  $names .'   ตั้งแต่วันที่    ' .  
                              Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '.
                              Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
            ],
            'beforeHeader'=>[
                    [
                        'columns'=>[
                            ['content'=>'', 'options'=>['colspan'=>2, 'class'=>'text-center warning']], 
                            ['content'=>'การคัดกรองภาวะไตวาย(eGFR)', 'options'=>['colspan'=>6, 'class'=>'text-center warning']],  
                            ['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center warning']],                             
                        ],
                        'options'=>['class'=>'skip-export'] 
                    ]
            ],   
            'showPageSummary'=>true,      
            'toolbar' => [ 
            $fullExportMenu2,
            ['content'=>"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" ],    
            ]
]);
?>
<div class="panel panel-sea margin-left-5 margin-right-5 margin-bottom-5">
    <div class="panel-heading"></div>
    <div class="panel">
        <div class="panel-body">               
            <div class="tab-v1 margin-left-5 margin-right-5">       
                <?=
                TabsX::widget([
                    'position' => TabsX::POS_ABOVE,
                    'align' => TabsX::ALIGN_LEFT,
                    'encodeLabels' => false,
                    'class' => 'nav-tabs-custom',
                    'items' => [
                        [
                            'label' => '<small>ในเขตอำเภอนางรอง</small>',
                            'content' => '<div class="well-sm grid-view"><div class="row">' . $grid1 . '</div></div>',
                            'active' => true
                        ],
                        [
                            'label' => '<small>นอกเขตอำเภอนางรอง</small>',
                            'content' => '<div class="well-sm grid-view"><div class="row">' . $grid2 . '</div></div>',
                            'options' => ['id' => 'myID1'],
                        ],
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>



