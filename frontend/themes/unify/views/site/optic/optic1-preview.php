<?php
use kartik\tabs\TabsX;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\mpdf\Pdf;

?>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?= $mText; ?></h3>
        <ul class="pull-right breadcrumb">
            <li><?= Html::a('Home', ['/site/index']); ?></li>
            <li><?=
                Html::a($mText, ['/optic/index']);
                ;
                ?></li>
            <li class="active"><?= Html::a($names, ['/optic/optic1-index']); ?></li>
        </ul>
    </div>
</div>
<div class="service-info margin-left-5 margin-right-5">

<!-- contet1 -->
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
                      'attribute'=>'hn',
                      'header'=>'HN',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',        
               ],  
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],      
                      'attribute'=>'refer_number',
                      'header'=>'เลขที่ส่งต่อ',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',        
               ],  
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],      
                      'attribute'=>'pname',
                      'header'=>'ชื่อผู้ป่วย',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',        
               ],  
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],      
                      'attribute'=>'refer_date',
                      'header'=>'วันที่ส่งต่อ',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',        
               ],  
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],      
                      'attribute'=>'pre_diagnosis',
                      'header'=>'pre_diagnosis',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',
                      'value' => function($data){
                              return is_null($data['pre_diagnosis'])?'':$data['pre_diagnosis'];
                      }
               ],  
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],      
                      'attribute'=>'pdx',
                      'header'=>'icd10',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',        
               ],  
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],      
                      'attribute'=>'diag',
                      'header'=>'การวินิจฉัย',
                      'vAlign'=>'middle',
                      'hAlign'=>'left', 
                      'value' => function($data){
                              return is_null($data['diag'])?'':$data['diag'];
                      }                   
               ],                        
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],      
                      'attribute'=>'doctor',
                      'header'=>'แพทย์ผู้ส่ง',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',        
               ],              
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],      
                      'attribute'=>'hospital',
                      'header'=>'โรงพยาบาล',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',        
               ],      
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],      
                      'attribute'=>'status',
                      'header'=>'สถานะ',
                      'vAlign'=>'middle',
                      'hAlign'=>'center', 
                      'hidden' => true
               ],     
        ];
        $fullExportMenu1 = ExportMenu::widget([
                      'options' => ['id' =>'expt1'],    
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
                             'itemsBefore' => ['<li class="dropdown-header">Export All Data</li>'],
                      ],
        ]);
        $grid1 = GridView::widget([
                      'dataProvider' => $dataProvider1,
                      'columns' => $gridColumns, 
                      'tableOptions' =>['class'=>'table table-striped table-bordered table-hoverr'],    
                      'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
                      'pjax' => true, 
                      'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container1']], 
                      'panel' => [
                             'type' => GridView::TYPE_PRIMARY,
                             'heading' => '<h6 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;'. $names . '   ตั้งแต่วันที่    ' .  
                                            Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                                            Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
                      ],
                      'showPageSummary'=>true,    
                      'toolbar' => [ 
                             $fullExportMenu1,
                             ['content'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' 
                             ],               
                      ]
        ]);
?>            
<!-- content2 -->
<?php
        $fullExportMenu2 = ExportMenu::widget([
                      'options' => ['id' =>'expt2'],    
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
                             'itemsBefore' => ['<li class="dropdown-header">Export All Data</li>'],
                      ],
        ]);
        $grid2 = GridView::widget([
                      'dataProvider' => $dataProvider2,
                      'columns' => $gridColumns, 
                      'tableOptions' =>['class'=>'table table-striped table-bordered table-hoverr'],    
                      'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
                      'pjax' => true, 
                      'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container2']], 
                      'panel' => [
                             'type' => GridView::TYPE_PRIMARY,
                             'heading' => '<h6 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;'. $names . '   ตั้งแต่วันที่    ' .  
                                            Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                                            Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
                      ],
                      'showPageSummary'=>true,    
                      'toolbar' => [ 
                             $fullExportMenu2,
                             ['content'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' 
                             ],               
                      ]
        ]);
?>   
<!-- content3 -->
<?php
        $fullExportMenu3 = ExportMenu::widget([
                      'options' => ['id' =>'expt3'],    
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
                             'itemsBefore' => ['<li class="dropdown-header">Export All Data</li>'],
                      ],
        ]);
        $grid3 = GridView::widget([
                      'dataProvider' => $dataProvider3,
                      'columns' => $gridColumns, 
                      'tableOptions' =>['class'=>'table table-striped table-bordered table-hoverr'],    
                      'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
                      'pjax' => true, 
                      'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container3']], 
                      'panel' => [
                             'type' => GridView::TYPE_PRIMARY,
                             'heading' => '<h6 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;'. $names . '   ตั้งแต่วันที่    ' .  
                                            Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                                            Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
                      ],
                      'showPageSummary'=>true,    
                      'toolbar' => [ 
                             $fullExportMenu3,
                             ['content'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' 
                             ],               
                      ]
        ]);
?>            
<div class="nav-tabs-custom">   
<?= TabsX::widget([
               'position' => TabsX::POS_ABOVE,
               'align' => TabsX::ALIGN_LEFT,
               'encodeLabels' => false,
               'class' =>'nav-tabs-custom',
               'items' => [
                      [
                             'label' => '<small>จำนวนผู้ป่วยส่งต่อทั้งหมด</small>',
                             'content' =>'<div class="well-sm grid-view"><div class="row">' . $grid1 . '</div></div>',
                             'active' => true
                      ],
                      [
                             'label' => '<small>ในเขตรับผิดชอบ(ในอำเภอ)</small>',
                             'content' =>'<div class="well-sm grid-view"><div class="row">' . $grid2 . '</div></div>',
                              'options' => ['id' => 'myID1'],
                      ],
                      [
                             'label' => '<small>นอกเขตรับผิดชอบ(นอกอำเภอ)</small>',
                             'content' =>'<div class="well-sm grid-view"><div class="row">' . $grid3 . '</div></div>',
                             'options' => ['id' => 'myID2'],
                      ],    
               ],
        ]);    
?>
</div>
</div>