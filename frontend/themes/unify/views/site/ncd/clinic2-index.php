<?php
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\mpdf\Pdf;
use kartik\tabs\TabsX;
use yii\helpers\Url;

?>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?= $mText; ?></h3>
        <ul class="pull-right breadcrumb">
            <li><?= Html::a('Home', ['/site/index']); ?></li>
            <li><?=
                Html::a($names, ['/ncd-clinic/index']);
                ;
                ?></li>
            <li class="active"></li>
        </ul>
    </div>
</div>
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
                      'label'=>'HN',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',       
               ],     
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],      
                      'attribute'=>'pnames',
                      'label'=>'ชื่อผู้ป่วย',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',      
               ],      
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],      
                      'attribute'=>'regdate',
                      'label'=>'วันที่ขี้นทะเบียน',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',     
               ], 
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],      
                      'attribute'=>'dchdate',
                      'label'=>'วันจำหน่าย',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'value'=>function($data){
                                return is_null($data['dchdate'])?'':$data['dchdate'];
                      }
               ], 
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],      
                      'attribute'=>'discharge',
                      'label'=>'discharge',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',     
               ],   
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],      
                      'attribute'=>'status',
                      'label'=>'สถานะ',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',     
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
                      'label'=>'หมู่',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',     
               ], 
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],      
                      'attribute'=>'tmb',
                      'label'=>'ตำบล',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',     
               ], 
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],      
                      'attribute'=>'amp',
                      'label'=>'อำเภอ',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',     
               ], 
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],      
                      'attribute'=>'chw',
                      'label'=>'จังหวัด',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',     
               ], 
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],      
                      'attribute'=>'statusx',
                      'label'=>'สถานที่',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',     
               ], 

        ];  
?>
<!-- content1 -->
<?php
        $fullExportMenu1 = ExportMenu::widget([
                'options' => ['id'=>'expt1'],
                'dataProvider' => $dataProvider1,
                'columns' => $gridColumns,
                'target'=>  ExportMenu::TARGET_POPUP,
                'exportConfig' => [
                    ExportMenu::FORMAT_TEXT => false,
                    ExportMenu::FORMAT_PDF => false,
                    ExportMenu::FORMAT_HTML => false,
                ],    
                'fontAwesome' => true,
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
        $grid1 = GridView::widget([
                'dataProvider' => $dataProvider1,
                'columns' => $gridColumns, 
                'tableOptions' =>['class'=>'table table-striped table-bordered table-hover dataTable no-footer DTTT_selectable'],    
                'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",       
                'pjax' => true, 
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container1']], 
                'panel' => [
                        'type' => GridView::TYPE_PRIMARY,
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp;
                                           ทะเบียนผู้ป่วยเบาหวานทั้งหมดในคลินิก</h3>',
                ],
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
                'options' => ['id'=>'expt2'],
                'dataProvider' => $dataProvider2,
                'columns' => $gridColumns,
                'target'=>  ExportMenu::TARGET_POPUP,
                'exportConfig' => [
                    ExportMenu::FORMAT_TEXT => false,
                    ExportMenu::FORMAT_PDF => false,
                    ExportMenu::FORMAT_HTML => false,
                ],    
                'fontAwesome' => true,
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
        $grid2 = GridView::widget([
                'dataProvider' => $dataProvider2,
                'columns' => $gridColumns, 
                'tableOptions' =>['class'=>'table table-striped table-bordered table-hover dataTable no-footer DTTT_selectable'],    
                'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",       
                'pjax' => true, 
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container2']], 
                'panel' => [
                        'type' => GridView::TYPE_PRIMARY,
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp;
                                           ทะเบียนผู้ป่วยเบาหวานที่มีรายชื่อในบัญชี 1</h3>',
                ],
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
                'options' => ['id'=>'expt3'],
                'dataProvider' => $dataProvider3,
                'columns' => $gridColumns,
                'target'=>  ExportMenu::TARGET_POPUP,
                'exportConfig' => [
                    ExportMenu::FORMAT_TEXT => false,
                    ExportMenu::FORMAT_PDF => false,
                    ExportMenu::FORMAT_HTML => false,
                ],    
                'fontAwesome' => true,
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
        $grid3 = GridView::widget([
                'dataProvider' => $dataProvider3,
                'columns' => $gridColumns, 
                'tableOptions' =>['class'=>'table table-striped table-bordered table-hover dataTable no-footer DTTT_selectable'],    
                'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",       
                'pjax' => true, 
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container3']], 
                'panel' => [
                        'type' => GridView::TYPE_PRIMARY,
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp;
                                           ทะเบียนผู้ป่วยเบาหวานที่ไม่มีรายชื่อในบัญชี 1</h3>',
                ],
                'toolbar' => [ 
                      $fullExportMenu3,
                              ['content'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' 
                              ],               
                ]
                ]);
?>
<!-- content4 -->
<?php
        $fullExportMenu4 = ExportMenu::widget([
                'options' => ['id'=>'expt4'],
                'dataProvider' => $dataProvider4,
                'columns' => $gridColumns,
                'target'=>  ExportMenu::TARGET_POPUP,
                'exportConfig' => [
                    ExportMenu::FORMAT_TEXT => false,
                    ExportMenu::FORMAT_PDF => false,
                    ExportMenu::FORMAT_HTML => false,
                ],    
                'fontAwesome' => true,
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
        $grid4 = GridView::widget([
                'dataProvider' => $dataProvider4,
                'columns' => $gridColumns, 
                'tableOptions' =>['class'=>'table table-striped table-bordered table-hover dataTable no-footer DTTT_selectable'],    
                'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",       
                'pjax' => true, 
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container4']], 
                'panel' => [
                        'type' => GridView::TYPE_PRIMARY,
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp;
                                           ทะเบียนผู้ป่วยความดันโลหิตทั้งหมดในคลินิก</h3>',
                ],
                'toolbar' => [ 
                      $fullExportMenu4,
                              ['content'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' 
                              ],               
                ]
                ]);
?>
<!-- content5 -->
<?php
        $fullExportMenu5 = ExportMenu::widget([
                'options' => ['id'=>'expt5'],
                'dataProvider' => $dataProvider5,
                'columns' => $gridColumns,
                'target'=>  ExportMenu::TARGET_POPUP,
                'exportConfig' => [
                    ExportMenu::FORMAT_TEXT => false,
                    ExportMenu::FORMAT_PDF => false,
                    ExportMenu::FORMAT_HTML => false,
                ],    
                'fontAwesome' => true,
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
        $grid5 = GridView::widget([
                'dataProvider' => $dataProvider5,
                'columns' => $gridColumns, 
                'tableOptions' =>['class'=>'table table-striped table-bordered table-hover dataTable no-footer DTTT_selectable'],    
                'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",       
                'pjax' => true, 
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container5']], 
                'panel' => [
                        'type' => GridView::TYPE_PRIMARY,
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp;
                                           ทะเบียนผู้ป่วยความดันโลหิตที่มีรายชื่อในบัญชี 1</h3>',
                ],
                'toolbar' => [ 
                      $fullExportMenu5,
                              ['content'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' 
                              ],               
                ]
                ]);
?>
<!-- content6 -->
<?php
        $fullExportMenu6 = ExportMenu::widget([
                'options' => ['id'=>'expt6'],
                'dataProvider' => $dataProvider6,
                'columns' => $gridColumns,
                'target'=>  ExportMenu::TARGET_POPUP,
                'exportConfig' => [
                    ExportMenu::FORMAT_TEXT => false,
                    ExportMenu::FORMAT_PDF => false,
                    ExportMenu::FORMAT_HTML => false,
                ],    
                'fontAwesome' => true,
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
        $grid6 = GridView::widget([
                'dataProvider' => $dataProvider6,
                'columns' => $gridColumns, 
                'tableOptions' =>['class'=>'table table-striped table-bordered table-hover dataTable no-footer DTTT_selectable'],    
                'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",       
                'pjax' => true, 
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container6']], 
                'panel' => [
                        'type' => GridView::TYPE_PRIMARY,
                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp;
                                           ทะเบียนผู้ป่วยความดันโลหิตที่ไม่มีรายชื่อในบัญชี 1</h3>',
                ],
                'toolbar' => [ 
                      $fullExportMenu6,
                              ['content'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' 
                              ],               
                ]
                ]);
?>


<?php
    $items = [
           [
               'label' => '<i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;<small>
                                       คลินิกเบาหวาน</small>',
               'active' => true,
               'items' => [
                    [
                        'label' => '<small>ทะเบียนผู้ป่วยทั้งหมดในคลินิก</small>',
                        'content' => '<div class="well-sm grid-view"><div class="row">' . $grid1 . '</div></div>',
                        'options' => ['id' => 'myID1'], 
                        'encode' =>false,
                    ],
                    [
                        'label' => '<small>ทะเบียนผู้ป่วยที่มีรายชื่อในบัญชี 1</small>',
                        'content' => '<div class="well-sm grid-view"><div class="row">' . $grid2 . '</div></div>',
                        'options' => ['id' => 'myID2'],   
                        'encode' =>false,                        
                    ],
                    [
                        'label' => '<small>ทะเบียนผู้ป่วยที่ไม่มีรายชื่อในบัญชี 1</small>',
                        'content' => '<div class="well-sm grid-view"><div class="row">' . $grid3 . '</div></div>',
                        'options' => ['id' => 'myID3'],   
                        'encode' =>false,                        
                    ],                
               ],
           ],
           [
               'label' => '<i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;<small>
                                       คลินิกความดันโลหิต</small>',
               'items' => [
                   [
                        'label' => '<span class="small">ทะเบียนผู้ป่วยทั้งหมดในคลินิก</span>',
                        'content' => '<div class="well-sm grid-view"><div class="row">' . $grid4 . '</div></div>',
                        'options' => ['id' => 'myID4'],  
                        'encode' =>false,                       
                    ],
                    [
                        'label' => '<small>ทะเบียนผู้ป่วยที่มีรายชื่อในบัญชี 1</small>',
                        'content' => '<div class="well-sm grid-view"><div class="row">' . $grid5 . '</div></div>',
                        'options' => ['id' => 'myID5'],  
                        'encode' =>false,                        
                    ],
                    [
                        'label' => '<small>ทะเบียนผู้ป่วยที่ไม่มีรายชื่อในบัญชี 1</small>',
                        'content' => '<div class="well-sm grid-view"><div class="row">' . $grid6 . '</div></div>',
                        'options' => ['id' => 'myID6'],  
                        'encode' =>false,                        
                    ], 
               ],
           ],        
       ]           
?>
<div class="panel panel-sea margin-left-5 margin-right-5 margin-bottom-5">
    <div class="panel-heading">
        <h3 class="box-title">&nbsp;ทะเบียนรายชื่อผู้ป่วยคลิกนิกโรคเรื้อรัง(สถานะ ยังรักษาอยู่,ส่งต่อรักษาที่อื่น)</h3>
    </div>
            <div class="panel">
                <div class="panel-body">               
                   <div class="tab-v1 margin-left-5 margin-right-5">     
            <?= TabsX::widget([
                        'position' => TabsX::POS_ABOVE,
                        'align' => TabsX::ALIGN_LEFT,
                        'encodeLabels' => false,
                        'items' => $items
              ]); 
            ?>
            </div>
        </div>
    </div>
</div>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />