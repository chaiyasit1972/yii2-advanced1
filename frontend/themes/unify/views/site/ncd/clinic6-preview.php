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
            <li class="active"><?= Html::a($names, ['/ncd-clinic1/clinic6-index']); ?></li>
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
               ],
               [   
                      'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],          
                      'attribute'=>'pname',
                      'label'=>'รายการ(กิจกรรม DMHT)',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',  
                      'hAlign'=>'left',    
                      'format'=>'raw',               
               ],    
               [   
                      'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],          
                      'attribute'=>'numi',
                      'label'=>'ในเขต',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',   
               ],
               [ 
                      'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],              
                      'attribute'=>'numo',
                      'label'=>'นอกเขต',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',   
               ],       
               [  
                      'headerOptions' => ['style'=>'text-align:center','class'=>'warning blue'],          
                      'attribute'=>'total',
                      'label'=>'รวม',
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
                      'type' => 'primary',
                      'heading' => '<i class="glyphicon glyphicon-book"></i>&nbsp;' .  $names . '  '.$clinic_n.'   ตั้งแต่วันที่    ' .  
                                     Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '.  
                                     Yii::$app->mycomponent->ShortDateThai($date2),
                      ],
                      'beforeHeader'=>[
                             [
                                     'columns'=>[
                                            ['content'=>'', 'options'=>['colspan'=>2, 'class'=>'text-center warning']], 
                                            ['content'=>'ผลการดำเนินงาน', 'options'=>['colspan'=>3, 'class'=>'text-center warning']],                
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
    <p class="center-block"><h2>ปล.มีรายงานบางตัวที่มีเงื่อนไขตรวจสอบย้อนหลัง ตั้งแต่ปี 2553</h2></p>    
</div>
        