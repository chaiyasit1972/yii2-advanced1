<?php
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\mpdf\Pdf;
use kartik\helpers\Html;
use kartik\grid\ActionColumn;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$model = $dataProvider->getModels();

?>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?= $mText; ?></h3>
        <ul class="pull-right breadcrumb">
            <li><?= Html::a('Home', ['/site/index']); ?></li>
            <li><?= Html::a($mText, ['/service/index1']); ?></li>
            <li class="active"><?=Html::a($names, ['/basic-gen/basic-gen6']); ?></li>
        </ul>
    </div>
</div>
<div class="service-info margin-left-5 margin-right-5">
    <div class="row">
    <div class="col col-md-12">
   <?php
   switch ($type) {
       case 1:
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
        'attribute'=>'death_cause_text',
        'label'=>'สาเหตุการตายหลัก',
        'vAlign'=>'middle',
        'hAlign'=>'left',  
        'pageSummary' => 'รวมทั้งหมด',          
    ],       
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'dtotal',
        'label'=>'จำนวน',
        'vAlign'=>'middle',
        'hAlign'=>'center',
        'pageSummary' => true,          
    ],    
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'in_hos',
        'label'=>'ตายใน รพ.',
        'vAlign'=>'middle',
        'hAlign'=>'center',
        'pageSummary' => true,          
    ],       
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'out_hos',
        'label'=>'ตายนอก รพ.',
        'vAlign'=>'middle',
        'hAlign'=>'center',
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
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;'.  $names . ' ตั้งแต่วันที่    ' .  
                  Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                  Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
],
'showPageSummary'=>true,        
'toolbar' => [ 
//'{export}',
$fullExportMenu,
]
]);
       break;
       case 2:
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
        'attribute'=>'death_cause_text',
        'label'=>'สาเหตุการตายหลัก',
        'vAlign'=>'middle',
        'hAlign'=>'left',  
        'pageSummary' => 'รวมทั้งหมด',          
    ],       
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'total',
        'label'=>'จำนวนทั้งหมด',
        'vAlign'=>'middle',
        'hAlign'=>'center',  
        'format'=>'raw',          
        'pageSummary' => true,   
        /*'value' => function($data){
               return Html::a($data['total'], ['service2_detail','id' => $data['death_cause'],'d1' => $data['date1'],'d2' => $data['date2']], 
                                    [
                                            'class' => 'mPop',
                                            'title' => Yii::t('yii', 'ดูรายละเอียด'),
                                    ]);
        },*/
    ],
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'icd10',
        'label'=>'รหัสโรค',
        'vAlign'=>'middle',
        'hAlign'=>'center',  
    ],
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'inames',
        'label'=>'รายโรค สูงสุด',
        'vAlign'=>'middle',
        'hAlign'=>'left',  
    ],  
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'dtotal',
        'label'=>'จำนวน',
        'vAlign'=>'middle',
        'hAlign'=>'center',
        'pageSummary' => true,            
    ], 
    ['class' => 'kartik\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model,$key) {                     
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',['basic-gen6_detail',
                                                  'id' => $model['death_cause'],'d1' => $model['date1'],'d2' => $model['date2'],
                                                  'tx' => $model['death_cause_text']],
                                            [
                                                'class' => 'xmodal',
                                                'title' => 'เปิดดูข้อมูล',
                                     ]);
                    },
   
                ]
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
//'{export}',
$fullExportMenu,
]
]);

       break;
       default:
       break;
   }
   
   
   
   ?> 
    
    <?php
                $this->registerJs("                        
                                        $('.xmodal').click(function (){
                                            $('#vmodal').modal('show')
                                            .find('#vmodalContent')
                                            .load($(this).attr('href'));
                                         return false;
                                        });
                                     ");
?>    
   <?php
        Modal::begin([
            'id' => 'vmodal',
            'header' => '<h4 class="modal-title">แสดงรายการ</h4>',
            'size'=>'modal-lg',
            'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">ปิด</a>',
        ]);

        echo "<div id='vmodalContent'></div>";

        Modal::end();
        ?> 
</div>    
</div>
</div>