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
                Html::a($mText, ['/basic-gen/index1']);
                ?></li>
            <li class="active"><?= Html::a($names, ['/basic-gen/basic-gen8']);?></li>
        </ul>
    </div>
</div>
<div class="page-container">
   <?php
   switch ($type1) {
       case 1:
       ?>    
          <div class="row">
            <div class="col-xs-12">
                <div class="margin-left-10 margin-right-10">
                <div class="panel-heading">
                  <h3 class="box-title"><?=$names ;?>  ทั้งหมด   ตั้งแต่ <?=Yii::$app->mycomponent->ShortDateThai($date1) ;?>   ถึงวันที่  
                      <?=Yii::$app->mycomponent->ShortDateThai($date2);?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example2" class="service-info table table-bordered table-hover">
                    <thead>
                      <tr>
                          <th class="text-center" rowspan="2">รายการ</th>
                          <th class="text-center" colspan="4">ประเภทจุดรับผู้ป่วย</th>
                          <th class="text-center" rowspan="2">รวมทั้งหมด</th>                     
                      </tr>
                      <tr>
                          <th class="text-center">จุดผู้ป่วยนอก(ครั้ง)</th>
                          <th class="text-center">จุดผู้ป่วย ER(ครั้ง)</th>          
                          <th class="text-center">จุดผู้ใน(ครั้ง)</th>
                          <th class="text-center">ไม่ได้ระบุ(ครั้ง)</th>                              
                      </tr>
                    </thead>
                    <tbody>       
                      <?php
                             foreach ($dataProvider as $value1) {
                      ?>           
                        <tr>
                            <td class="text-center">จำนวนผู้ป่วยส่งต่อ</td>
                            <td class="text-center"><?=$value1['ropd']?></td>
                            <td class="text-center"><?=$value1['repd']?></td>
                            <td class="text-center"><?=$value1['ripd']?></td> 
                            <td class="text-center"><?=$value1['rnpd']?></td>                             
                            <td class="text-center"><?=$value1['total']?></td>                            
                        </tr>
                      <?php  
                              }  
                      ?>                       
                    </tbody>
                  </table> 
                </div>
              </div>
            </div>
          </div>
       <?php                 
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
                 'attribute'=>'spclty',
                 'label'=>'รายการแผนก/สาขา',
                 'vAlign'=>'middle',
                 'hAlign'=>'left',  
                 'pageSummary' => 'รวมทั้งหมด',          
             ],       
             [ 
                 'headerOptions' => ['style'=>'text-align:center'],      
                 'attribute'=>'ropd',
                 'label'=>'จุดผู้ป่วยนอก(ครั้ง)',
                 'vAlign'=>'middle',
                'hAlign'=>'center',
                'pageSummary' => true,          
            ],    
             [ 
                 'headerOptions' => ['style'=>'text-align:center'],      
                 'attribute'=>'ripd',
                 'label'=>'จุดผู้ป่วยใน(ครั้ง)',
                 'vAlign'=>'middle',
                'hAlign'=>'center',
                'pageSummary' => true,          
            ], 
             [ 
                 'headerOptions' => ['style'=>'text-align:center'],      
                 'attribute'=>'repd',
                 'label'=>'จุดผู้ป่วยอุบัติเหตุ(ครั้ง)',
                 'vAlign'=>'middle',
                'hAlign'=>'center',
                'pageSummary' => true,          
            ], 
             [ 
                 'headerOptions' => ['style'=>'text-align:center'],      
                 'attribute'=>'rnpd',
                 'label'=>'ไม่ระบุ(ครั้ง)',
                 'vAlign'=>'middle',
                'hAlign'=>'center',
                'pageSummary' => true,          
            ],             
             [ 
                 'headerOptions' => ['style'=>'text-align:center'],      
                 'attribute'=>'total',
                 'label'=>'รวมทั้งหมด',
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
        ?>
        <div class="service-info margin-left-5 margin-right-5">    
        <?php
            echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns, 
            'tableOptions' =>['class'=>'table table-striped table-bordered table-hoverr'],   

            'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
            'pjax' => true, 
            'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']], 
            'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;'.  $names . 'แยก '.  $type2 . ' ตั้งแต่วันที่    ' .  
                              Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                              Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
            ],
            'beforeHeader'=>[
                    [
                        'columns'=>[
                            ['content'=>'', 'options'=>['colspan'=>2, 'class'=>'text-center warning']], 
                            ['content'=>'ประเภทจุดรับผู้ป่วย', 'options'=>['colspan'=>4, 'class'=>'text-center warning']], 
                            ['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center warning']],                 
                        ],
                        'options'=>['class'=>'skip-export'] // remove this row from export
                    ]
            ],                  
            'showPageSummary'=>true,        
            'toolbar' => [ 
            //'{export}',
            $fullExportMenu,
            ]
        ]);   
        ?>
        </div>
        <?php    
       break;
       case 3:
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
                 'attribute'=>'icd10',
                 'label'=>'รหัสโรค',
                 'vAlign'=>'middle',
                 'hAlign'=>'left',        
             ],  
             [   
                 'headerOptions' => ['style'=>'text-align:center'],        
                 'attribute'=>'diag',
                 'label'=>'การวินิจฉัย',
                 'vAlign'=>'middle',
                 'hAlign'=>'left',  
                 'pageSummary' => 'รวมทั้งหมด',          
             ],              
             [ 
                 'headerOptions' => ['style'=>'text-align:center'],      
                 'attribute'=>'ropd',
                 'label'=>'จุดผู้ป่วยนอก(ครั้ง)',
                 'vAlign'=>'middle',
                'hAlign'=>'center',
                'pageSummary' => true,          
            ],    
             [ 
                 'headerOptions' => ['style'=>'text-align:center'],      
                 'attribute'=>'ripd',
                 'label'=>'จุดผู้ป่วยใน(ครั้ง)',
                 'vAlign'=>'middle',
                'hAlign'=>'center',
                'pageSummary' => true,          
            ], 
             [ 
                 'headerOptions' => ['style'=>'text-align:center'],      
                 'attribute'=>'repd',
                 'label'=>'จุดผู้ป่วยอุบัติเหตุ(ครั้ง)',
                 'vAlign'=>'middle',
                'hAlign'=>'center',
                'pageSummary' => true,          
            ], 
             [ 
                 'headerOptions' => ['style'=>'text-align:center'],      
                 'attribute'=>'rnpd',
                 'label'=>'ไม่ระบุ(ครั้ง)',
                 'vAlign'=>'middle',
                'hAlign'=>'center',
                'pageSummary' => true,          
            ],             
             [ 
                 'headerOptions' => ['style'=>'text-align:center'],      
                 'attribute'=>'total',
                 'label'=>'รวมทั้งหมด',
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
        ?>
        <div class="service-info margin-left-5 margin-right-5">
        <?php
            echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns, 
            'tableOptions' =>['class'=>'table table-striped table-bordered table-hoverr'],   

            'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
            'pjax' => true, 
            'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']], 
            'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;'.  $names . 'แยก '.  $type2 . ' ตั้งแต่วันที่    ' .  
                              Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                              Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
            ],
            'beforeHeader'=>[
                    [
                        'columns'=>[
                            ['content'=>'', 'options'=>['colspan'=>3, 'class'=>'text-center warning']], 
                            ['content'=>'ประเภทจุดรับผู้ป่วย', 'options'=>['colspan'=>4, 'class'=>'text-center warning']], 
                            ['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center warning']],                 
                        ],
                        'options'=>['class'=>'skip-export'] // remove this row from export
                    ]
            ],                  
            'showPageSummary'=>true,        
            'toolbar' => [ 
            //'{export}',
            $fullExportMenu,
            ]
        ]);    
       ?>
        </div>
       <?php
       break;       
       default :
       break;    
   }
?>
</div>    