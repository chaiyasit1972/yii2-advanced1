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
            <li class="active"><?= Html::a($names, ['/ncd-clinic1/clinic5-index']); ?></li>
        </ul>
    </div>
</div>
<div class="service-info margin-left-5 margin-right-5">
<?php
        $gridColumns = [
               [
                        'class' => '\kartik\grid\SerialColumn',
                        'header' => 'ลำดับที่',
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],  
                        'hAlign'=>'center',
                        'width'=>'60px',
                        'hidden'=>false
               ],
               [   
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],          
                        'attribute'=>'hn',
                        'label'=>'เลขดัชนี',
                        'vAlign'=>'middle',
                        'hAlign'=>'center',   
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
                        'attribute'=>'sex',
                        'label'=>'เพศ',
                        'vAlign'=>'middle',
                        'hAlign'=>'center',   
               ],    
               [
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],          
                        'attribute'=>'age_y',
                        'label'=>'อายุ',
                        'vAlign'=>'middle',
                        'hAlign'=>'center',
                        'format'=>'raw',
               ],    
               [ 
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],  
                        'attribute'=>'vstdate',
                        'label'=>'วันที่รับบริการ',
                        'vAlign'=>'middle',
                        'hAlign'=>'left',       
               ],      
               [ 
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],  
                        'attribute'=>'addrpart',
                        'label'=>'บ้านเลขที่',
                        'vAlign'=>'middle',
                        'hAlign'=>'left',      
               ], 
               [ 
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],       
                        'attribute'=>'moopart',
                        'label'=>'หมู่ที่',
                        'vAlign'=>'middle',
                        'hAlign'=>'left',   
               ],   
               [ 
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],  
                        'attribute'=>'tmb',
                        'label'=>'ตำบล',
                        'vAlign'=>'middle',
                        'hAlign'=>'left',  
                        'value'=>function($data){
                          return is_null($data['tmb'])?'':$data['tmb'];
                        }                
               ],      
               [ 
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],      
                        'attribute'=>'amp',
                        'label'=>'อำเภอ',
                        'vAlign'=>'middle',
                        'hAlign'=>'left',   
               ], 
               [ 
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],     
                        'attribute'=>'chw',
                        'label'=>'จังหวัด',
                        'vAlign'=>'middle',
                        'hAlign'=>'left',   
               ],       
               [ 
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],     
                        'attribute'=>'bpsx',
                        'label'=>'SBP เฉลี่ย',
                        'vAlign'=>'middle',
                        'hAlign'=>'center',   
               ],     
               [ 
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],     
                        'attribute'=>'bpdx',
                        'label'=>'DBP เฉลี่ย',
                        'vAlign'=>'middle',
                        'hAlign'=>'center',   
               ],       
               [ 
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],     
                        'attribute'=>'cholesterol',
                        'label'=>'Cholesteral',
                        'vAlign'=>'middle',
                        'hAlign'=>'center',   
               ],
               [ 
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],     
                        'attribute'=>'smoking',
                        'label'=>'ผลบุหรี่',
                        'vAlign'=>'middle',
                        'hAlign'=>'center',   
               ],       
               [ 
                        'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],     
                        'attribute'=>'stage',
                        'label'=>'ผลของระดับโอกาสเสี่ยง',
                        'format'=>'raw',
                        'vAlign'=>'middle',
                        'hAlign'=>'center',
                        'value'=>function($data){
                               $values=[
                                  'ต่ำ'=>'label rounded-2x label-brown',
                                  'ปานกลาง'=>'label rounded-2x label-yellow',
                                  'สูง'=>'label rounded-2x label-orange', 
                                  'สูงมาก'=>'label rounded-2x label-danger', 
                                  'สูงอันตราย'=>'label rounded-2x label-red',    
                                  ''=>'badge label-default' 
                               ];

                         return is_null($data['stage'])?'':Html::tag('span',Html::encode($data['stage']),['class'=>$values[$data['stage']]]);
                        }             
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
                'itemsBefore' => [
                        '<li class="dropdown-header">Export All Data</li>',
                      ],
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
                              'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;' .  $names . '  '.
                                      $type_n.'   ตั้งแต่วันที่    ' .  
                                      Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '.  
                                      Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
                      ],
                      'exportConfig' => [
                              GridView::PDF => ['label' => 'Save as Pdf'],
                      ],    
                      'export' => [             
                           'label' => 'PDF',
                           'fontAwesome' => true,
                           'options' => [
                                'class' => 'btn btn-info btn-sm',
                           ],
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