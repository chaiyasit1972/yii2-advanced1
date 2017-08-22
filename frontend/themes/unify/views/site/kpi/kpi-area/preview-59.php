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
            <li><?= Html::a($mText, ['/service/index2']);?></li>
            <li class="active"><?= Html::a($names,['kpi-area/index59']); ?></li>
        </ul>
    </div>
</div>
<div class="page-content margin-left-5 margin-right-5">
        <?php
               $gridColumns = [
                      [
                             'class' => '\kartik\grid\SerialColumn',
                             'headerOptions' => ['style'=>'text-align:center'], 
                             'header' => 'ลำดับที่',
                             'vAlign'=>'middle',
                             'hAlign'=>'center',   
                      ],
                      [ 
                             'headerOptions' => ['style'=>'text-align:center'],     
                             'label' => 'รายการ',
                             'attribute'=>'pname',
                             'vAlign'=>'middle',
                             'hAlign'=>'left',   
                      ],     
                      [ 
                             'headerOptions' => ['style'=>'text-align:center'],     
                             'label' => 'เป้าหมาย',
                             'attribute'=>'goal',
                             'vAlign'=>'middle',
                             'hAlign'=>'center',  
                             //'format'=>['decimal',''] 
                      ],    
                      [ 
                             'headerOptions' => ['style'=>'text-align:center'],     
                             'label' => 'ผลงาน',
                             'attribute'=>'result',
                             'vAlign'=>'middle',
                             'hAlign'=>'center', 
                             //'format'=>['decimal','']                           
                      ],    
                      [ 
                             'headerOptions' => ['style'=>'text-align:center'],     
                             'header' => 'ร้อยละ',
                             'attribute'=>'total',
                             'vAlign'=>'middle',
                             'hAlign'=>'center',
                             'format'=>['decimal',2]                           
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
                             'label' => 'Select',                          
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
                      'pjax' => true,
                      'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
                      'panel' => [
                              'type' => GridView::TYPE_PRIMARY,
                              'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;' .  $names . '  ตั้งแต่วันที่    ' .  
                                     Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '.  
                                     Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
                      ],
                      'export' => [
                             'label' => 'Page',
                             'fontAwesome' => true,
                             'options' => [
                                     'class' => 'btn btn-info btn-sm',
                             ],
                      ],
                      'beforeHeader'=>[
                             [
                                     'columns'=>[
                                            ['content'=>'', 'options'=>['colspan'=>2, 'class'=>'text-center ']], 
                                            ['content'=>'ผลการดำเนินงาน', 'options'=>['colspan'=>3, 'class'=>'text-center ']],               
                                     ],
                                    'options'=>['class'=>'skip-export'] 
                             ]
                      ],     
                      'toolbar' => [
                              $fullExportMenu,
                              ['content'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' 
                              ],    
                      ]
               ]);
?>
</div>
