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
            <li class="active"><?= Html::a($names, ['/ncd-clinic2/clinic12-index']); ?></li>
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
                      'attribute'=>'eye_left',
                      'label'=>'eye_left',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['eye_left'])?'':$data['eye_left'];
                      }                   
               ],    
               [
                      'attribute'=>'eye_right',
                      'label'=>'eye_right',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['eye_right'])?'':$data['eye_right'];
                      }                   
               ],  
               [
                      'attribute'=>'va_left_text',
                      'label'=>'va_left_text',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['va_left_text'])?'':$data['va_left_text'];
                      }                   
               ],  
               [
                      'attribute'=>'va_right_text',
                      'label'=>'va_right_text',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['va_right_text'])?'':$data['va_right_text'];
                      }                   
               ],  
               [
                      'attribute'=>'macular',
                      'label'=>'macular',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['macular'])?'':$data['macular'];
                      }                   
               ],  
               [
                      'attribute'=>'laser',
                      'label'=>'laser',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['laser'])?'':$data['laser'];
                      }                   
               ],  
               [
                      'attribute'=>'cataract',
                      'label'=>'cataract',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['cataract'])?'':$data['cataract'];
                      }                   
               ],  
               [
                      'attribute'=>'blindness',
                      'label'=>'blindness',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['blindness'])?'':$data['blindness'];
                      }                   
               ],  
               [
                      'attribute'=>'iop_left_text',
                      'label'=>'iop_left_text',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['iop_left_text'])?'':$data['iop_left_text'];
                      },
                      'hidden' => true                                
               ],  
               [
                      'attribute'=>'iop_right_text',
                      'label'=>'iop_right_text',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['iop_right_text'])?'':$data['iop_right_text'];
                      },
                      'hidden' => true                                  
               ],  
               [
                      'attribute'=>'treatment_text',
                      'label'=>'treatment_text',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['treatment_text'])?'':$data['treatment_text'];
                      },
                      'hidden' => true                                      
               ],  
               [
                      'attribute'=>'remark_text',
                      'label'=>'remark_text',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value' => function($data){
                              return is_null($data['remark_text'])?'':$data['remark_text'];
                      },
                      'hidden' => true        
                      
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

