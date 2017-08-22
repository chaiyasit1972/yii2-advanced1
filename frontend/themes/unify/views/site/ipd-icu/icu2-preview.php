<?php
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\mpdf\Pdf;
use kartik\helpers\Html;
use kartik\grid\ActionColumn;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$model = $dataProvider->getModels();
$year = [
       'm10' => $yers-1,
       'm11' => $yers-1,
       'm12' => $yers-1,
       'm01' => $yers, 
       'm02' => $yers,     
       'm03' => $yers, 
       'm04' => $yers, 
       'm05' => $yers, 
       'm06' => $yers, 
       'm07' => $yers, 
       'm08' => $yers, 
       'm09' => $yers,     
];
$da = ['da1' => $date1, 'da2' => $date2];
?>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?=$mText;?></h3>
        <ul class="pull-right breadcrumb">
            <li><?=Html::a('Home',['/site/index']);?></li>
            <li><?=Html::a($mText,['/ipd-icu/index']);;?></li>
            <li class="active"><?=$names;?></li>
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
        'attribute'=>'pdx',
        'label'=>'Icd10',
        'vAlign'=>'middle',
        'hAlign'=>'left',   
    ],    
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'diag',
        'label'=>'Diagnosis(โรคหลัก)',
        'vAlign'=>'middle',
        'hAlign'=>'left',   
        'pageSummary' => 'รวมทั้งหมด',            
    ],       
    [ 
        'headerOptions' => ['style'=>'text-align:center'],       
        'attribute'=>'oct',
        'label'=>'ต.ค.'.  substr($yrs-1, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',    
        'format' => 'raw',
        'value' => function($model) use ($year) {
                      return Html::a($model['oct'],['icu2_detail','m'=>'10','y'=>$year['m10']],
                                [
                                     'class' => 'mPop',
                                     'title' => Yii::t('yii', 'List View'),                    
                                ]);
                      },         
    ],      
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'nov',
        'label'=>'พ.ย.'.  substr($yrs-1, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',   
        'format' => 'raw',        
        'value' => function($model) use ($year) {
                      return Html::a($model['nov'],['icu2_detail','m'=>'11','y'=>$year['m11']],
                                [
                                     'class' => 'mPop',
                                     'title' => Yii::t('yii', 'List View'),                    
                                ]);
                      },         
    ],       
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'dec',
        'label'=>'ธ.ค.'.  substr($yrs-1, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',
        'format' => 'raw',        
        'value' => function($model) use ($year) {
                      return Html::a($model['dec'],['icu2_detail','m'=>'12','y'=>$year['m12']],
                                [
                                     'class' => 'mPop',
                                     'title' => Yii::t('yii', 'List View'),                    
                                ]);
                      },          
    ],    
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'jan',
        'label'=>'ม.ค.'.  substr($yrs, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',    
        'format' => 'raw',        
        'value' => function($model) use ($year) {
                      return Html::a($model['jan'],['icu2_detail','m'=>'1','y'=>$year['m01']],
                                [
                                     'class' => 'mPop',
                                     'title' => Yii::t('yii', 'List View'),                    
                                ]);
                      },          
    ],     
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'feb',
        'label'=>'ก.พ.'.  substr($yrs, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center', 
        'format' => 'raw',        
        'value' => function($model) use ($year) {
                      return Html::a($model['feb'],['icu2_detail','m'=>'2','y'=>$year['m02']],
                                [
                                     'class' => 'mPop',
                                     'title' => Yii::t('yii', 'List View'),                    
                                ]);
                      },          
    ],     
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'mar',
        'label'=>'มี.ค.'.  substr($yrs, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',  
        'format' => 'raw',        
        'value' => function($model) use ($year) {
                      return Html::a($model['mar'],['icu2_detail','m'=>'3','y'=>$year['m03']],
                                [
                                     'class' => 'mPop',
                                     'title' => Yii::t('yii', 'List View'),                    
                                ]);
                      },          
    ],     
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'apr',
        'label'=>'เม.ย.'.  substr($yrs, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',  
        'format' => 'raw',        
        'value' => function($model) use ($year) {
                      return Html::a($model['apr'],['icu2_detail','m'=>'4','y'=>$year['m04']],
                                [
                                     'class' => 'mPop',
                                     'title' => Yii::t('yii', 'List View'),                    
                                ]);
                      },           
    ],     
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'may',
        'label'=>'พ.ค.'.  substr($yrs, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',    
        'format' => 'raw',        
        'value' => function($model) use ($year) {
                      return Html::a($model['may'],['icu2_detail','m'=>'5','y'=>$year['m05']],
                                [
                                     'class' => 'mPop',
                                     'title' => Yii::t('yii', 'List View'),                    
                                ]);
                      },           
    ],      
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'jun',
        'label'=>'มิ.ย.'.  substr($yrs, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',    
        'format' => 'raw',        
        'value' => function($model) use ($year) {
                      return Html::a($model['jun'],['icu2_detail','m'=>'6','y'=>$year['m06']],
                                [
                                     'class' => 'mPop',
                                     'title' => Yii::t('yii', 'List View'),                    
                                ]);
                      },           
    ],   
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'jul',
        'label'=>'ก.ค.'.  substr($yrs, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',    
        'format' => 'raw',        
        'value' => function($model) use ($year) {
                      return Html::a($model['jul'],['icu2_detail','m'=>'7','y'=>$year['m07']],
                                [
                                     'class' => 'mPop',
                                     'title' => Yii::t('yii', 'List View'),                    
                                ]);
                      },           
    ],    
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'aug',
        'label'=>'ส.ค.'.  substr($yrs, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',    
        'format' => 'raw',        
        'value' => function($model) use ($year) {
                      return Html::a($model['aug'],['icu2_detail','m'=>'8','y'=>$year['m08']],
                                [
                                     'class' => 'mPop',
                                     'title' => Yii::t('yii', 'List View'),                    
                                ]);
                      },           
    ],  
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'sep',
        'label'=>'ก.ย.'.  substr($yrs, 2, 2),
        'vAlign'=>'middle',
        'hAlign'=>'center',   
        'format' => 'raw',        
        'value' => function($model) use ($year) {
                      return Html::a($model['sep'],['icu2_detail','m'=>'9','y'=>$year['m09']],
                                [
                                     'class' => 'mPop',
                                     'title' => Yii::t('yii', 'List View'),                    
                                ]);
                      },           
    ],    
    [ 
        'headerOptions' => ['style'=>'text-align:center'],           
        'attribute'=>'total',
        'label'=>'รวมทั้งหมด',
        'vAlign'=>'middle',
        'hAlign'=>'center',
        'format' => 'raw',                
 
        'pageSummary'=>true        
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
Pjax::begin(['id'=>'customer_pjax_id']);
echo GridView::widget([
'dataProvider' => $dataProvider,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hoverr'],   
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']], 
'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp; ' .$names.' ตั้งแต่วันที่    ' .  
                  Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                  Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
],  
                      'beforeHeader'=>[
                             [
                                     'columns'=>[
                                            ['content'=>'', 'options'=>['colspan'=>2, 'class'=>'text-center warning']], 
                                            ['content'=>'ผลการดำเนินงาน', 'options'=>['colspan'=>12, 'class'=>'text-center warning']], 
                                            ['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center warning']],                                          
                                     ],
                                     'options'=>['class'=>'skip-export'] 
                             ]
                      ],    
'showPageSummary'=>true,        
'toolbar' => [ 
$fullExportMenu,
]
]);
Pjax::end();  
?>
<?php
$this->registerJs("
                        $('.mPop').click(function (){
                            $('#zmodal').modal('show')
                            .find('#zmodalContent')
                            .load($(this).attr('href'));
                         return false;
                        });
                        
                        $('.xmodal').click(function (){
                            $('#vmodal').modal('show')
                            .find('#vmodalContent')
                            .load($(this).attr('href'));
                         return false;
                        });

                    "     
        );
?>    
   <?php
        Modal::begin([
            'id' => 'zmodal',
            'header' => '<h4 class="modal-title">แสดงรายการ</h4>',
            'size'=>'modal-lg',
            'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">ปิด</a>',
        ]);

        echo "<div id='zmodalContent'></div>";

        Modal::end();
        ?>     
</div>
