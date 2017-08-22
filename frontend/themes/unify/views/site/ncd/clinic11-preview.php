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
            <li class="active"><?= Html::a($names, ['/ncd-clinic2/clinic11-index']); ?></li>
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
                      'attribute'=>'sex',
                      'label'=>'เพศ',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',
                      'format'=>'raw'
               ],    
               [
                      'attribute'=>'age_y',
                      'label'=>'อายุ',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw'
               ],    
               [
                      'attribute'=>'vstdate',
                      'label'=>'วันรับบริการ',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw'
               ],
               [
                      'attribute'=>'weight',
                      'label'=>'น้ำหนัก',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value'=>function($data){
                              return is_null($data['weight'])?'':$data['weight'];
                      }                     
               ],   
               [
                      'attribute'=>'lab_order_result',
                      'label'=>'ผล Creatinine',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw'
               ],      
               [
                      'attribute'=>'pdx',
                      'label'=>'pdx',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',
                      'format'=>'raw'
               ],  
               [
                      'attribute'=>'dx0',
                      'label'=>'dx0',
                      'vAlign'=>'middle',
                      'hAlign'=>'left',
                      'format'=>'raw'
               ],  
               [
                      'attribute'=>'stage',
                      'label'=>'stage',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw'
               ],  
               [
                      'attribute'=>'ckd_epi',
                      'label'=>'ckd_epi',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value'=>function($data){
                              return is_null($data['ckd_epi'])?'':$data['ckd_epi'];
                      }        
               ],  
               [
                      'attribute'=>'thai_egfr',
                      'label'=>'thai_egfr',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value'=>function($data){
                              return is_null($data['thai_egfr'])?'':$data['thai_egfr'];
                      }        
               ],      
               [
                      'attribute'=>'mdrd',
                      'label'=>'mdrd',
                      'vAlign'=>'middle',
                      'hAlign'=>'center',
                      'format'=>'raw',
                      'value'=>function($data){
                              return is_null($data['mdrd'])?'':$data['mdrd'];
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
                        'type' => 'primary',
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

