<?php
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
                Html::a($mText, ['/dental/index']);
                ;
                ?></li>
            <li class="active"><?= Html::a($names, ['/dental/dental13-index']); ?></li>
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
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'hn',
                'label'=>'HN',
                'vAlign'=>'middle',
                'hAlign'=>'left',              
            ],    
            [ 
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'pname',
                'label'=>'ชื่อผู้ป่วย',
                'vAlign'=>'middle',
                'hAlign'=>'left',  
            ],   
            [
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'house_regist_type_id',
                'label'=>'house_type',
                'vAlign'=>'middle',
                'hAlign'=>'center',  
                'value'=>function($data){
                      return is_null($data['house_regist_type_id'])?'':$data['house_regist_type_id'];
                }
            ],
            [
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'village_moo',
                'label'=>'หมู่',
                'vAlign'=>'middle',
                'hAlign'=>'left',     
                'value'=>function($data){
                      return is_null($data['village_moo'])?'':$data['village_moo'];
                }        
            ],   
            [
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'village_name',
                'label'=>'บ้าน/ชุมชน',
                'vAlign'=>'middle',
                'hAlign'=>'left',   
                'value'=>function($data){
                    return is_null($data['village_name'])?'':$data['village_name'];             
                }   
            ],
            [
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'vstdate',
                'label'=>'วันรับริการ',
                'vAlign'=>'middle',
                'hAlign'=>'center',        
            ],    
            [
                'headerOptions' => ['style'=>'text-align:center'],      
                'attribute'=>'dname',
                'label'=>'การรักษา',
                'vAlign'=>'middle',
                'hAlign'=>'left',       
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
echo GridView::widget([
'dataProvider' => $dataProvider,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hoverr'],    
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']], 
'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h6 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;'. $names .$type .  ' ตั้งแต่วันที่    ' .  
                  Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                  Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
],
'showPageSummary'=>true,    
'toolbar' => [ 
$fullExportMenu,
     ['content'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      &nbsp;&nbsp;'
     ],       
]
]);
?>            
 </div>     
</div>


