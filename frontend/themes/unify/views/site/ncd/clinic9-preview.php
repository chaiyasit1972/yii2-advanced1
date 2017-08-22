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
                Html::a($mText, ['/ncd-clinic/index']);
                ;
                ?></li>
            <li class="active"><?= Html::a($names, ['/ncd-clinic2/clinic9-index']); ?></li>
        </ul>
    </div>
</div>
<div class="service-info margin-left-5 margin-right-5">
<?php
        $gridColumns = [
               [
                      'class' => '\kartik\grid\SerialColumn',
                      'header' => 'ลำดับที่',
                      'headerOptions' => ['style'=>'text-align:center','class'=>'info blue'],  
                      'hAlign'=>'center',
                      'width'=>'60px',
               ],
               [   
                      'headerOptions' => ['style'=>'text-align:center','class'=>'info blue'],          
                      'attribute'=>'pname',
                      'label'=>'ชื่อผู้ป่วย',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',  
               ],
               [ 
                      'headerOptions' => ['style'=>'text-align:center','class'=>'info blue'],              
                      'attribute'=>'screen_date',
                      'label'=>'วันที่คัดกรอง',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',   
               ],       
               [  
                      'headerOptions' => ['style'=>'text-align:center','class'=>'info blue'],          
                      'attribute'=>'addrpart',
                      'label'=>'บ้านเลขที่',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',   
               ],    
               [  
                      'headerOptions' => ['style'=>'text-align:center','class'=>'info blue'],          
                      'attribute'=>'moo',
                      'label'=>'หมู่/ชุมชน',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',   
               ],    
               [  
                      'headerOptions' => ['style'=>'text-align:center','class'=>'info blue'],          
                      'attribute'=>'dna',
                      'label'=>'ผล',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',   
               ],   
               [  
                      'headerOptions' => ['style'=>'text-align:center','class'=>'info blue'],          
                      'attribute'=>'smok',
                      'label'=>'ผล',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',   
               ], 
               [  
                      'headerOptions' => ['style'=>'text-align:center','class'=>'info blue'],          
                      'attribute'=>'bp',
                      'label'=>'ผล',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',   
               ],   
               [  
                      'headerOptions' => ['style'=>'text-align:center','class'=>'info blue'],          
                      'attribute'=>'dm',
                      'label'=>'ผล',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',   
               ],     
               [  
                      'headerOptions' => ['style'=>'text-align:center','class'=>'info blue'],          
                      'attribute'=>'lipid',
                      'label'=>'ผล',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',   
               ],   
               [  
                      'headerOptions' => ['style'=>'text-align:center','class'=>'info blue'],          
                      'attribute'=>'waist',
                      'label'=>'ผล',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',   
               ],   
               [  
                      'headerOptions' => ['style'=>'text-align:center','class'=>'info blue'],          
                      'attribute'=>'stro',
                      'label'=>'ผล',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',   
               ],   
               [  
                      'headerOptions' => ['style'=>'text-align:center','class'=>'info blue'],          
                      'attribute'=>'hear',
                      'label'=>'ผล',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',   
               ],   
               [  
                      'headerOptions' => ['style'=>'text-align:center','class'=>'info blue'],          
                      'attribute'=>'total',
                      'label'=>'ผล',
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
                             'heading' => '<i class="glyphicon glyphicon-book"></i>&nbsp;' .  $names .   '    '. $clinic .  'ตั้งแต่วันที่    ' .  
                                     Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                                     Yii::$app->mycomponent->ShortDateThai($date2),
                      ],
                      'beforeHeader'=>[
                             [
                                     'columns'=>[
                                            ['content'=>'', 'options'=>['colspan'=>5, 'class'=>'text-center ']], 
                                            ['content'=>'กรรมพันธุ์', 'options'=>['colspan'=>1, 'class'=>'text-center ']],
                                            ['content'=>'การสูบบุหรี่', 'options'=>['colspan'=>1, 'class'=>'text-center ']],
                                            ['content'=>'ความดันโลหิต', 'options'=>['colspan'=>1, 'class'=>'text-center ']],
                                            ['content'=>'เบาหวาน', 'options'=>['colspan'=>1, 'class'=>'text-center']],
                                            ['content'=>'ไขมันในเลือด', 'options'=>['colspan'=>1, 'class'=>'text-center ']],
                                            ['content'=>'รอบเอว', 'options'=>['colspan'=>1, 'class'=>'text-center ']],
                                            ['content'=>'Stroke', 'options'=>['colspan'=>1, 'class'=>'text-center ']],
                                            ['content'=>'Stemi', 'options'=>['colspan'=>1, 'class'=>'text-center ']],
                                            ['content'=>'รวมคะแนน', 'options'=>['colspan'=>1, 'class'=>'text-center ']],                
                                     ],
                                    'options'=>['class'=>'skip-export'] 
                             ]
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
        