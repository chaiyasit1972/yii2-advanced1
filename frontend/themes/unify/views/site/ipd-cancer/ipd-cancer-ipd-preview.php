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
            <li><?= Html::a($mText, ['/ipd-cancer/index']); ?></li>
            <li class="active"><?=Html::a($names, ['/ipd-cancer/index']); ?></li>
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
                'attribute'=>'cid',
                'label'=>'เลขบัตรประชาชน',
                'vAlign'=>'middle',
                'hAlign'=>'center',     
            ],               
            [   
                'headerOptions' => ['style'=>'text-align:center'],        
                'attribute'=>'hn',
                'label'=>'HN',
                'vAlign'=>'middle',
                'hAlign'=>'center',     
            ],       
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'pname',
                'label'=>'ชื่อผู้ป่วย',
                'vAlign'=>'middle',
                'hAlign'=>'left',   
            ],  
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'birthday',
                'label'=>'ว/ด/ป เกิด',
                'vAlign'=>'middle',
                'hAlign'=>'center',     
            ],      
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'marrystatus',
                'label'=>'สถานภาพสมรส',
                'vAlign'=>'middle',
                'hAlign'=>'center',
            ],  
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'age_y',
                'label'=>'อายุ',
                'vAlign'=>'middle',
                'hAlign'=>'center',
                'format'=>['decimal',0],                
            ], 
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'addrpart',
                'label'=>'บ้านเลขที่',
                'vAlign'=>'middle',
                'hAlign'=>'left',           
            ],  
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'moopart',
                'label'=>'หมู่ที่',
                'vAlign'=>'middle',
                'hAlign'=>'center',           
            ],  
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'tmb',
                'label'=>'ตำบล',
                'vAlign'=>'middle',
                'hAlign'=>'center',           
            ],  
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'amp',
                'label'=>'อำเภอ',
                'vAlign'=>'middle',
                'hAlign'=>'center',           
            ],  
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'chw',
                'label'=>'จังหวัด',
                'vAlign'=>'middle',
                'hAlign'=>'center',           
            ],  
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'pttype',
                'label'=>'สิทธิการรักษา',
                'vAlign'=>'middle',
                'hAlign'=>'left',           
            ],  
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'strdate',
                'label'=>'วันที่เริ่มวินิจฉัย',
                'vAlign'=>'middle',
                'hAlign'=>'center',           
            ],  
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'icd10',
                'label'=>'icd10',
                'vAlign'=>'middle',
                'hAlign'=>'center',           
            ],  
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'diag',
                'label'=>'Diagnosis',
                'vAlign'=>'middle',
                'hAlign'=>'left',           
            ],  
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'doctor',
                'label'=>'แพทย์ที่วินิจฉัย',
                'vAlign'=>'middle',
                'hAlign'=>'left',           
            ],              
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'text',
                'label'=>'สถานะการคีย์',
                'vAlign'=>'middle',
                'hAlign'=>'left',           
            ],          
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'enddate',
                'label'=>'last visit',
                'vAlign'=>'middle',
                'hAlign'=>'left',           
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
                'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;'. 'รายงานทะเบียนผู้ป่วยมะเร็ง(ผู้ป่วยใน C00-D48) ตั้งแต่วันที่    ' .  
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