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
            <li class="active"><?= Html::a($names, ['/ncd-clinic2/clinic10-index']); ?></li>
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
                      'width'=>'60px',
                      'hidden'=>false
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
                      'attribute'=>'sex',
                      'label'=>'เพศ',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',   
               ],     
               [   
                      'attribute'=>'age_y',
                      'label'=>'อายุ',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',   
               ],    
               [
                      'attribute'=>'addrpart',
                      'label'=>'บ้านเลขที่',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'hidden'=>true
               ],    
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],        
                      'attribute'=>'moopart',
                      'label'=>'หมู่ที่',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',   
                      'hidden'=>true        
               ],      
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],        
                      'attribute'=>'tmb',
                      'label'=>'ตำบล',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',   
                      'hidden'=>true        
               ], 
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],        
                      'attribute'=>'weight',
                      'label'=>'น้ำหนัก',
                      'vAlign'=>'middle',
                      'hAlign'=>'left', 
                      'value'=>function($data){
                              return is_null($data['weight'])?'':$data['weight'];   
                      }
               ],     
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],        
                      'attribute'=>'pdx',
                      'label'=>'การวินิจฉัย',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',   
               ],    
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],        
                      'attribute'=>'vstdate',
                      'label'=>'วันที่ปัจจุบัน',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',   
               ], 
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],        
                      'attribute'=>'creatinine',
                      'label'=>'creatinine ปัจจุบัน',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',   
               ], 
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],        
                      'attribute'=>'gfr',
                      'label'=>'GFRปัจจุบัน',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',   
               ], 
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],        
                      'attribute'=>'stage',
                      'label'=>'stage ปัจจุบัน',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',   
               ], 
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],        
                      'attribute'=>'bf_vstdate',
                      'label'=>'วันที่ก่อน',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',   
               ], 
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],        
                      'attribute'=>'bf_cre',
                      'label'=>'creatinine ก่อน',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',   
               ], 
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],        
                      'attribute'=>'bf_gfr',
                      'label'=>'GFR ก่อน',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',   
               ], 
               [ 
                      'headerOptions' => ['style'=>'text-align:center'],        
                      'attribute'=>'bf_stage',
                      'label'=>'stage ก่อน',
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
                             'heading' => '<h4 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;' .  $names . 
                                             ' [ ' . $clinic_n . ' ]  ตั้งแต่วันที่    ' .  
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
    

