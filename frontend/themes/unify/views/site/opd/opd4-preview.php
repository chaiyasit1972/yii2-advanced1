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
            <li><?=
                Html::a($mText, ['/opd/index']);
                ;
                ?></li>
            <li class="active"><?= Html::a($names, ['/opd/opd4-index']); ?></li>
        </ul>
    </div>
</div>
<div class="service-info margin-left-5 margin-right-5">
<?php
        $gridColumns = [
            [
                        'class' => '\kartik\grid\SerialColumn',
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],        
                        'header' => 'ลำดับที่',
                        'hAlign'=>'center',
                        'width'=>'60px'
            ],
            [
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],        
                        'attribute'=>'hn',
                        'label'=>'เลขดัชนี',
                        'vAlign'=>'middle',
                        'hAlign'=>'left',
                        'format'=>'raw'
            ],       
            [ 
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],    
                        'attribute'=>'pname',
                        'label'=>'ชื่อผู้ป่วย',
                        'vAlign'=>'middle',
                        'hAlign'=>'left',   
            ],     
            [ 
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],    
                        'attribute'=>'age_y',
                        'label'=>'อายุ',
                        'vAlign'=>'middle',
                        'hAlign'=>'center',   
            ],     
            [ 
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],    
                        'attribute'=>'vstdate_before',
                        'label'=>'วันก่อนหน้านี้',
                        'vAlign'=>'middle',
                        'hAlign'=>'center',   
            ],    
            [ 
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],    
                        'attribute'=>'vstdate_now',
                        'label'=>'วันที่ปัจจุบัน',
                        'vAlign'=>'middle',
                        'hAlign'=>'center',   
            ],       
            [ 
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],    
                        'attribute'=>'days',
                        'label'=>'ระยะห่าง(วัน)',
                        'vAlign'=>'middle',
                        'hAlign'=>'center',  
            ],           
            [ 
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],    
                        'attribute'=>'icd10_befor',
                        'label'=>'icd10 ก่อนหน้านี้',
                        'vAlign'=>'middle',
                        'hAlign'=>'center',
            ], 
            [ 
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],    
                        'attribute'=>'icd10_now',
                        'label'=>'icd10 ปัจจุบัน',
                        'vAlign'=>'middle',
                        'hAlign'=>'center',
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
                      'tableOptions' =>['class'=>'table table-striped table-bordered table-hover'],   
                      'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",        
                      'pjax' => true,   
                      'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']], 
                      'panel' => [
                             'type' => GridView::TYPE_PRIMARY,
                             'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;' .  $names . '  ตั้งแต่วันที่    ' .  
                                            Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '.  
                                            Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
                      ],
                      'toolbar' => [ 
                             $fullExportMenu,
                             ['content'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' 
                             ],               
                      ]
        ]);
?>
</div>
