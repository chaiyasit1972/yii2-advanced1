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
                'label'=>'รายการ',
                'vAlign'=>'middle',
                'hAlign'=>'left',          
               ],
               [ 
                'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],        
                'attribute'=>'goal',
                'header'=>'เป้าหมาย',
                'vAlign'=>'middle',
                'hAlign'=>'center',        
               ],       
               [ 
                'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],        
                'attribute'=>'total',
                'header'=>'จำนวนผู้รับบริการทั้งหมด',
                'vAlign'=>'middle',
                'hAlign'=>'center',     
               ],   
               [ 
                'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],        
                'attribute'=>'result',
                'header'=>'ผลงาน',
                'vAlign'=>'middle',
                'hAlign'=>'center',    
               ],     
               [ 
                'headerOptions' => ['style'=>'text-align:center','class'=>'blue'],        
                'header'=>'ร้อยละ<br>จากจำนวนผู้รับบริการทั้งหมด',
                'vAlign'=>'middle',
                'hAlign'=>'center',   
                'value'=>function($data){
                     if($data['total']==0||$data['result']==0){
                       return '';  
                     }else{
                       return (int)(($data['result']*100)/($data['total']));  
                     }
                },
                'format'=>['decimal',2],                
              ],       
        ];
        $fullExportMenu = ExportMenu::widget([
               'options' => ['id'=>'expt1'],    
               'dataProvider' => $dataProvider,
               'columns' => $gridColumns,
               'target'=>  ExportMenu::TARGET_POPUP,
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
?>
<div class="service-info margin-left-5 margin-right-5 margin-bottom-5">
<?php    
echo GridView::widget([
               'dataProvider' => $dataProvider,
               'columns' => $gridColumns, 
               'tableOptions' =>['class'=>'table table-striped table-bordered table-hover dataTable no-footer DTTT_selectable'],    
               'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",       
               'pjax' => true, 
               'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']], 
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
                            ['content'=>'ผลการดำเนินงาน', 'options'=>['colspan'=>3, 'class'=>'text-center warning']],  
                            ['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center warning']],                             
                        ],
                        'options'=>['class'=>'skip-export'] 
                    ]
               ],   
               'showPageSummary'=>true,      
               'toolbar' => [ 
                      $fullExportMenu,
                      ['content'=>"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" ],    
              ]
        ]);
?>
</div>