<?php
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\mpdf\Pdf;
use kartik\helpers\Html;
use kartik\grid\ActionColumn;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
//use prawee\assets\PwAsset;

//PwAsset::register($this);

$model = $dataProvider->getModels();

?>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?= $mText; ?></h3>
        <ul class="pull-right breadcrumb">
            <li><?= Html::a('Home', ['/site/index']); ?></li>
            <li><?= Html::a($mText, ['/service/index1']); ?></li>
            <li class="active"><?=Html::a($names, ['/basic-gen/basic-gen10']); ?></li>
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
    ], 
    [   
        'headerOptions' => ['style'=>'text-align:center'],        
        'attribute'=>'type',
        'label'=>'type',
        'vAlign'=>'middle',
        'hAlign'=>'left',   
        'hidden'=>true
    ],     
    [   
        'headerOptions' => ['style'=>'text-align:center'],        
        //'attribute'=>$models['spclty'],
        'label'=>'แผนก/สาขา',
        'vAlign'=>'middle',
        'hAlign'=>'left',      
        'value'=>function($model){
                 return $model['spclty'];
        }
       // 'hidden'=>true        
    ],  
    [   
        'headerOptions' => ['style'=>'text-align:center'],        
        'attribute'=>'sname',
        'label'=>'รายการแผนก/สาขา',
        'vAlign'=>'middle',
        'hAlign'=>'left',           
    ],       
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'man',
        'label'=>'จำนวนทั้งหมด',
        'vAlign'=>'middle',
        'hAlign'=>'center', 
        'format'=>'raw',    
    ],
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'icd10',
        'label'=>'รหัสโรค',
        'vAlign'=>'middle',
        'hAlign'=>'center',  
    ],
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'diag',
        'label'=>'รายโรค',
        'vAlign'=>'middle',
        'hAlign'=>'left',  
        'pageSummary' => 'รวมทั้งหมด',           
    ],  
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'man1',
        'label'=>'จำนวน',
        'vAlign'=>'middle',
        'hAlign'=>'center',
        'format'=>'raw',    
        'value' => function($data){
                return Html::a($data['man1'],['basic-gen10_detail','id'=>$data['spclty'],'d1'=>$data['date1'],'d2'=>$data['date2'],
                                     'sname'=>$data['sname'],'type'=>$data['type']],[
                       'class' => 'mPop',
                       'title' => Yii::t('yii', 'List View'),                    
                ]);
        },              
    ], 
    ['class' => 'kartik\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model,$key) {                     
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',['basic-gen/basic-gen10_detail','id'=>$model['spclty'],
                                             'd1'=>$model['date1'],'d2'=>$model['date2'],'sname'=>$model['sname'],'type'=>$model['type']],
                                            [
                                                'class' => 'xmodal',
                                                'title' => 'เปิดดูข้อมูล',
                                               // 'data-toggle' => 'modal',
                                                'data-target' => '#vmodal',
                                               // 'data-id' => $key,
                                                'data-pjax' => '0',
                        ]);
                    },
   
                ]
    ],
       /*                     [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{view}{delete}',
        'buttons' => [
                        'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-check"></span>', $url, 
                        [
                            'title' => Yii::t('app', 'Change today\'s lists'),
                        ]);
                    }                           
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                return yii\helpers\Url::to(['customers/today']);
                
            }
        }
     ], */                      
];
$fullExportMenu = ExportMenu::widget([
'options' =>['id' =>'expt'],    
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
'id' =>'gridId',    
'dataProvider' => $dataProvider,
'columns' => $gridColumns, 
'tableOptions' =>['class'=>'table table-striped table-bordered table-hoverr'],   
'responsive' => true,
'summary' =>"<small>แสดง</small> {begin} - {end} <small>จาก</small> {totalCount} record",    
'pjax' => true, 
'pjaxSettings' => [
       'neverTimeout'=>true,
       'enablePushState' => false,
       'options' => ['id' => 'kv-pjax-container']
], 
'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;'.  $names .  $time . ' ตั้งแต่วันที่    ' .  
                  Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                  Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
],         
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
    
    
   <?php
        Modal::begin([
            'id' => 'vmodal',
            'header' => '<h4 class="modal-title">แสดงรายการ</h4>',
            'size'=>'modal-lg',
            'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">ปิด</a>',
        ]);

        echo "<div id='vmodalContent'></div>";

        Modal::end();
        ?>     
    
</div>
    