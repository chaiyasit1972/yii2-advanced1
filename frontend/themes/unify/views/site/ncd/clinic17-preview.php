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
            <li class="active"><?= Html::a($names, ['/ncd-clinic2/clinic17-index']); ?></li>
        </ul>
    </div>
</div>
<div class="service-info margin-left-5 margin-right-5">
<?php
        $gridColumns = [
               [
                      'class' => '\kartik\grid\SerialColumn',
                      'header' => 'ลำดับที่',
                      'headerOptions' => ['style'=>'text-align:center'],
                      'hAlign'=>'center',
                      'width'=>'60px'
               ],
               [   
                      'attribute'=>'hn',
                      'label'=>'เลขดัชนี',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',   
               ],
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],        
                      'attribute'=>'pname',
                      'label'=>'ชื่อผู้ป่วย',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',   
               ], 
               [
                      'attribute'=>'screen_date',
                      'label'=>'วันคัดกรอง',
                      'vAlign'=>'',
                      'hAlign'=>'left',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['screen_date'])?'':$data['screen_date'];
                      }
               ], 
               [
                      'attribute'=>'station',
                      'label'=>'รพ.สต./สถานที่',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw'
               ],  
               [
                      'attribute'=>'addrpart',
                      'label'=>'บ้านเลขที่',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'hidden' => true                   
               ], 
               [
                      'attribute'=>'moopart',
                      'label'=>'หมู่ที่',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'hidden' => true
               ],                     
               [
                      'attribute'=>'tmb',
                      'label'=>'ตำบล',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'hidden' => true
               ],                       
               [
                      'attribute'=>'amp',
                      'label'=>'อำเภอ',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'hidden' => true
               ],                        
               [
                      'attribute'=>'chw',
                      'label'=>'จังหวัด',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'hidden' => true
               ],                         
               [
                      'attribute'=>'result_left',
                      'label'=>'ผลการตรวจเท้าซ้าย',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['result_left'])?'':$data['result_left'];
                      }                   
               ],    
               [
                      'attribute'=>'result_right',
                      'label'=>'ผลการตรวจเท้าขวา',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['result_right'])?'':$data['result_right'];
                      }                   
               ],  
               [
                      'attribute'=>'foot_ulcer',
                      'label'=>'การตรวจพบแผลที่เท้า',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['foot_ulcer'])?'':$data['foot_ulcer'];
                      }                   
               ], 
               [
                      'attribute'=>'foot_amp',
                      'label'=>'ประวัติการตัดนิ้ว/ขา/เท้า',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['foot_amp'])?'':$data['foot_amp'];
                      }                   
               ],                 
               [
                      'attribute'=>'foot_nail',
                      'label'=>'การตรวจปัญหาที่เล็บ',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['foot_nail'])?'':$data['foot_nail'];
                      }                   
               ],                            
               [
                      'attribute'=>'foot_foot',
                      'label'=>'การตรวจพบเท้าผิดรูป',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['foot_foot'])?'':$data['foot_foot'];
                      }                   
               ],    
               [
                      'attribute'=>'foot_temp',
                      'label'=>'การสัมผัสไออุ่นบริเวรเท้า',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['foot_temp'])?'':$data['foot_temp'];
                      }                   
               ], 
               [
                      'attribute'=>'foot_skin',
                      'label'=>'ผลการตรวจสีผิวหนัง',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['foot_skin'])?'':$data['foot_skin'];
                      }                   
               ], 
               [
                      'attribute'=>'foot_die',
                      'label'=>'การตรวจพบเนื้อตาย',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['foot_die'])?'':$data['foot_die'];
                      }                   
               ],                        
               [
                      'attribute'=>'foot_sens',
                      'label'=>'ประวัติการเสียความรู้สึก',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['foot_sens'])?'':$data['foot_sens'];
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
                        'type' => 'success',
                        'heading' => '<h4><i class="glyphicon glyphicon-book"></i>&nbsp;' .  $names .'  ตั้งแต่วันที่    ' .  
                                          Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '.
                                          Yii::$app->mycomponent->ShortDateThai($date2).'</h4>',
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

