<?php
use kartik\tabs\TabsX;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\mpdf\Pdf;
use kartik\helpers\Html;
use yii\widgets\Pjax;

?>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?= $mText; ?></h3>
        <ul class="pull-right breadcrumb">
            <li><?= Html::a('Home', ['/site/index']); ?></li>
            <li><?= Html::a($mText, ['/service/index1']); ?></li>
            <li class="active"><?=Html::a($names, ['/basic-gen/basic-gen19']); ?></li>
        </ul>
    </div>
</div>
<div class="nav-tabs-custom">    
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
                'attribute'=>'pdx1',
                'label'=>'icd10',
                'vAlign'=>'middle',
                'hAlign'=>'left',             
            ],    
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'icdname',
                'label'=>'ชื่อโรค',
                'vAlign'=>'middle',
                'hAlign'=>'left',  
            ],             
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'num',
                'label'=>'จำนวน',
                'vAlign'=>'middle',
                'hAlign'=>'center',  
            ],    
        ];
?>
<!--  grid1 -->       
<?php    
$fullExportMenu1 = ExportMenu::widget([
'options' => ['id'=>'exp1'],      
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
Pjax::begin(['id' => 'pjax1']);
$grid1 = GridView::widget([ 
'dataProvider' => $dataProvider1,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hover service-info'],    
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container1']], 
'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp;'.$names. '&nbsp;&nbsp;ตั้งแต่วันที่    ' .  
                  Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                  Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
],
    'export' => [
        'fontAwesome' => true,
  'class' => 'btn btn-danger btn-sm',
    ],
'toolbar' => [ 
$fullExportMenu1,
]
]);
Pjax::end();  
?>
<!--  grid2 -->    
<?php    
$fullExportMenu2 = ExportMenu::widget([
'options' => ['id'=>'exp2'],      
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
Pjax::begin(['id' => 'pjax2']);
$grid2 = GridView::widget([ 
'dataProvider' => $dataProvider2,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hover service-info'],    
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container2']], 
'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp;'.$names. '&nbsp;&nbsp;ตั้งแต่วันที่    ' .  
                  Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                  Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
],
    'export' => [
        'fontAwesome' => true,
  'class' => 'btn btn-danger btn-sm',
    ],
'toolbar' => [ 
$fullExportMenu2,
]
]);
Pjax::end();  
?>
<!--  grid3 -->    
<?php    
$fullExportMenu3 = ExportMenu::widget([
'options' => ['id'=>'exp3'],      
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
Pjax::begin(['id' => 'pjax3']);
$grid3 = GridView::widget([ 
'dataProvider' => $dataProvider3,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hover service-info'],    
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container3']], 
'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp;'.$names. '&nbsp;&nbsp;ตั้งแต่วันที่    ' .  
                  Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                  Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
],
    'export' => [
        'fontAwesome' => true,
  'class' => 'btn btn-danger btn-sm',
    ],
'toolbar' => [ 
$fullExportMenu3,
]
]);
Pjax::end();  
?>
<!--  grid4 -->    
<?php    
$fullExportMenu4 = ExportMenu::widget([
'options' => ['id'=>'exp4'],      
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
Pjax::begin(['id' => 'pjax4']);
$grid4 = GridView::widget([ 
'dataProvider' => $dataProvider4,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hover service-info'],    
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container4']], 
'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp;'.$names. '&nbsp;&nbsp;ตั้งแต่วันที่    ' .  
                  Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                  Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
],
    'export' => [
        'fontAwesome' => true,
  'class' => 'btn btn-danger btn-sm',
    ],
'toolbar' => [ 
$fullExportMenu4,
]
]);
Pjax::end();  
?>
<!--  grid5 -->    
<?php    
$fullExportMenu5 = ExportMenu::widget([
'options' => ['id'=>'exp5'],      
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
Pjax::begin(['id' => 'pjax5']);
$grid5 = GridView::widget([ 
'dataProvider' => $dataProvider5,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hover service-info'],    
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container5']], 
'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp;'.$names. '&nbsp;&nbsp;ตั้งแต่วันที่    ' .  
                  Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                  Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
],
    'export' => [
        'fontAwesome' => true,
  'class' => 'btn btn-danger btn-sm',
    ],
'toolbar' => [ 
$fullExportMenu5,
]
]);
Pjax::end();  
?>
<!--  grid6 -->    
<?php    
$fullExportMenu6 = ExportMenu::widget([
'options' => ['id'=>'exp6'],      
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
Pjax::begin(['id' => 'pjax6']);
$grid6 = GridView::widget([ 
'dataProvider' => $dataProvider6,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hover service-info'],    
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container6']], 
'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp;'.$names. '&nbsp;&nbsp;ตั้งแต่วันที่    ' .  
                  Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                  Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
],
    'export' => [
        'fontAwesome' => true,
  'class' => 'btn btn-danger btn-sm',
    ],
'toolbar' => [ 
$fullExportMenu6,
]
]);
Pjax::end();  
?>
<!--  grid7 -->    
<?php    
$fullExportMenu7 = ExportMenu::widget([
'options' => ['id'=>'exp7'],      
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
Pjax::begin(['id' => 'pjax7']);
$grid7 = GridView::widget([ 
'dataProvider' => $dataProvider7,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hover service-info'],    
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container7']], 
'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp;'.$names. '&nbsp;&nbsp;ตั้งแต่วันที่    ' .  
                  Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                  Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
],
    'export' => [
        'fontAwesome' => true,
  'class' => 'btn btn-danger btn-sm',
    ],
'toolbar' => [ 
$fullExportMenu7,
]
]);
Pjax::end();  
?>
<!--  grid8 -->    
<?php    
$fullExportMenu8 = ExportMenu::widget([
'options' => ['id'=>'exp8'],      
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
Pjax::begin(['id' => 'pjax8']);
$grid8 = GridView::widget([ 
'dataProvider' => $dataProvider8,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hover service-info'],    
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container8']], 
'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp;'.$names. '&nbsp;&nbsp;ตั้งแต่วันที่    ' .  
                  Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                  Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
],
    'export' => [
        'fontAwesome' => true,
  'class' => 'btn btn-danger btn-sm',
    ],
'toolbar' => [ 
$fullExportMenu8,
]
]);
Pjax::end();  
?>
<!--  grid9 -->    
<?php    
$fullExportMenu9 = ExportMenu::widget([
'options' => ['id'=>'exp9'],      
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
Pjax::begin(['id' => 'pjax9']);
$grid9 = GridView::widget([ 
'dataProvider' => $dataProvider9,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hover service-info'],    
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container9']], 
'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp;'.$names. '&nbsp;&nbsp;ตั้งแต่วันที่    ' .  
                  Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                  Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
],
    'export' => [
        'fontAwesome' => true,
  'class' => 'btn btn-danger btn-sm',
    ],
'toolbar' => [ 
$fullExportMenu9,
]
]);
Pjax::end();  
?>
<!--  grid10 -->    
<?php    
$fullExportMenu10 = ExportMenu::widget([
'options' => ['id'=>'exp10'],      
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
Pjax::begin(['id' => 'pjax10']);
$grid10 = GridView::widget([ 
'dataProvider' => $dataProvider10,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hover service-info'],    
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container10']], 
'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp;'.$names. '&nbsp;&nbsp;ตั้งแต่วันที่    ' .  
                  Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                  Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
],
    'export' => [
        'fontAwesome' => true,
  'class' => 'btn btn-danger btn-sm',
    ],
'toolbar' => [ 
$fullExportMenu10,
]
]);
Pjax::end();  
?>

<?= TabsX::widget([
    'position' => TabsX::POS_ABOVE,
    'align' => TabsX::ALIGN_LEFT,
    'encodeLabels' => false,
    'items' => [
        [
            'label' => '<small>ทั้งหมด</small>',
            'content' =>$grid1,
            'active' => true,             
        ],        
       [
            'label' => '<small>01-อายุรกรรม</small>',
            'content' =>$grid2,
            'options' => ['id' =>'tId2'],                    
        ],
        [
            'label' => '<small>02-ศัลยกรรมทั่วไป</small>',
            'content' =>$grid3,
            'options' => ['id' =>'tId3'],  
        ],
        [
            'label' => '<small>03-สูติกรรม</small>',
            'content' =>$grid4,
            'options' => ['id' =>'tId4'],  
        ], 
        [
            'label' => '<small>04-นรีเวชกรรม</small>',
            'content' =>$grid5,
            'options' => ['id' =>'tId5'],  
        ],        
        [
            'label' => '<small>05-กุมารเวชกรรม(ยกเว้น NICU)</small>',
            'content' =>$grid6,
            'options' => ['id' =>'tId6'],  
        ],     
        [
            'label' => '<small>06-โสต ศอ นาสิก</small>',
            'content' =>$grid7,
            'options' => ['id' =>'tId7'],  
        ],    
        [
            'label' => '<small>07-จักษุ</small>',
            'content' =>$grid8,
            'options' => ['id' =>'tId8'],  
        ],   
        [
            'label' => '<small>08-ศัลยกรรมกระดูก</small>',
            'content' =>$grid9,
            'options' => ['id' =>'tId9'],  
        ],   
        [
            'label' => '<small>NICU</small>',
            'content' =>$grid10,
            'options' => ['id' =>'tId10'],  
        ],   
          
    ],
]);    ?>
</div>