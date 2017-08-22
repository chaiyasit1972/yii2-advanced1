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
                Html::a($mText, ['/child/index']);
                ;
                ?></li>
            <li class="active"><?= $names; ?></li>
        </ul>
    </div>
</div>
<div class="service-info">
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
        'label'=>'Hn',
        'vAlign'=>'middle',
        'hAlign'=>'center',       
    ],        
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'pname',
        'label'=>'ชื่อผู้ป่วย',
        'vAlign'=>'middle',
        'hAlign'=>'left', 
        'pageSummary'=>'รวมทั้งหมด'        
    ],             
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'age_y',
        'label'=>'อายุ(ปี)',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
        'value' => function($data){
                return is_null($data['age_y'])?'':$data['age_y'];
        }        
    ],   
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'age_m',
        'label'=>'อายุ(เดือน)',
        'vAlign'=>'middle',
        'hAlign'=>'center',   
        'value' => function($data){
                return is_null($data['age_m'])?'':$data['age_m'];
        },
        'hidden' =>true,        
    ],             
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'vaccine_date',
        'label'=>'วันที่รับบริการ',
        'vAlign'=>'middle',
        'hAlign'=>'center',       
    ],   
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'pttype',
        'label'=>'สิทธิ',
        'vAlign'=>'middle',
        'hAlign'=>'left',    
        'hidden' => true        
    ],      
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'addrpart',
        'label'=>'บ้านเลขที่',
        'vAlign'=>'middle',
        'hAlign'=>'center',    
        'hidden' => true
    ],        
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'moopart',
        'label'=>'หมู่ที่',
        'vAlign'=>'middle',
        'hAlign'=>'center',      
        'hidden' => true        
    ],        
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'tmb',
        'label'=>'ตำบล',
        'vAlign'=>'middle',
        'hAlign'=>'center',       
        'hidden' => true        
    ],        
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'amp',
        'label'=>'อำเภอ',
        'vAlign'=>'middle',
        'hAlign'=>'center',     
        'hidden' => true        
    ],    
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'chw',
        'label'=>'จังหวัด',
        'vAlign'=>'middle',
        'hAlign'=>'center',
        'hidden' => true        
    ],    
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'statusx',
        'label'=>'ที่อยู่',
        'vAlign'=>'middle',
        'hAlign'=>'center',       
    ],         
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'development',
        'label'=>'พัฒนาการ',
        'vAlign'=>'middle',
        'hAlign'=>'center',  
        'value' => function($data){
                return is_null($data['development'])?'':$data['development'];
        }
    ], 
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'food',
        'label'=>'อาหาร/นม',
        'vAlign'=>'middle',
        'hAlign'=>'center',  
        'value' => function($data){
                return is_null($data['food'])?'':$data['food'];
        }
    ], 
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'bottle',
        'label'=>'การใช้ขวดนม',
        'vAlign'=>'middle',
        'hAlign'=>'center',  
        'value' => function($data){
                return is_null($data['bottle'])?'':$data['bottle'];
        }
    ],             
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'nutrition',
        'label'=>'อายุ/น้ำหนัก',
        'vAlign'=>'middle',
        'hAlign'=>'left',  
        'value' => function($data){
                return is_null($data['nutrition'])?'':$data['nutrition'];
        }
    ],          
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'height_level',
        'label'=>'อายุ/ส่วนสูง',
        'vAlign'=>'middle',
        'hAlign'=>'left',  
        'value' => function($data){
                return is_null($data['height_level'])?'':$data['height_level'];
        }
    ],  
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'bmi_level',
        'label'=>'น้ำหนัก/ส่วนสูง',
        'vAlign'=>'middle',
        'hAlign'=>'left',  
        'value' => function($data){
                return is_null($data['bmi_level'])?'':$data['bmi_level'];
        }
    ],     
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'vaccine',
        'label'=>'วัคซีน[lot no]',
        'vAlign'=>'middle',
        'hAlign'=>'left',  
        'value' => function($data){
                return is_null($data['vaccine'])?'':$data['vaccine'];
        }
    ],    
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'result',
        'label'=>'hct',
        'vAlign'=>'middle',
        'hAlign'=>'left',  
        'value' => function($data){
                return is_null($data['result'])?'':$data['result'];
        }
    ], 
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'result1',
        'label'=>'Protein urine',
        'vAlign'=>'middle',
        'hAlign'=>'left',  
        'value' => function($data){
                return is_null($data['result1'])?'':$data['result1'];
        }
    ], 
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'result2',
        'label'=>'Glucose urine',
        'vAlign'=>'middle',
        'hAlign'=>'left',  
        'value' => function($data){
                return is_null($data['result2'])?'':$data['result2'];
        }
    ], 
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'result3',
        'label'=>'WBC',
        'vAlign'=>'middle',
        'hAlign'=>'left',  
        'value' => function($data){
                return is_null($data['result3'])?'':$data['result3'];
        }
    ], 
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'result4',
        'label'=>'RBC',
        'vAlign'=>'middle',
        'hAlign'=>'left',  
        'value' => function($data){
                return is_null($data['result4'])?'':$data['result4'];
        }
    ], 
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'result5',
        'label'=>'Epithelium cell',
        'vAlign'=>'middle',
        'hAlign'=>'left',  
        'value' => function($data){
                return is_null($data['result5'])?'':$data['result5'];
        }
    ], 
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'result6',
        'label'=>'Bacteria',
        'vAlign'=>'middle',
        'hAlign'=>'left',  
        'value' => function($data){
                return is_null($data['result6'])?'':$data['result6'];
        }
    ], 
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'result7',
        'label'=>'Blood',
        'vAlign'=>'middle',
        'hAlign'=>'left',  
        'value' => function($data){
                return is_null($data['result7'])?'':$data['result7'];
        }
    ],  
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'result8',
        'label'=>'Leukocyte',
        'vAlign'=>'middle',
        'hAlign'=>'left',  
        'value' => function($data){
                return is_null($data['result8'])?'':$data['result8'];
        }
    ],               
    [ 
        'headerOptions' => ['style'=>'text-align:center'],      
        'attribute'=>'drug',
        'label'=>'ยา',
        'vAlign'=>'middle',
        'hAlign'=>'left',  
        'value' => function($data){
                return is_null($data['drug'])?'':$data['drug'];
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
        'heading' => '<h6 class="panel-title"><i class="glyphicon glyphicon-book"></i>&nbsp;'. $names . '   ตั้งแต่วันที่    ' .  
                  Yii::$app->mycomponent->ShortDateThai($date1) .'   ถึงวันที่     '. 
                  Yii::$app->mycomponent->ShortDateThai($date2).'</h3>',
],
'beforeHeader'=>[
        [
            'columns'=>[
                ['content'=>'', 'options'=>['colspan'=>9, 'class'=>'text-center ']], 
                ['content'=>'โภชนาการ', 'options'=>['colspan'=>3, 'class'=>'text-center ']],    
                ['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center ']],    
                ['content'=>'ผล lab', 'options'=>['colspan'=>9, 'class'=>'text-center ']], 
                ['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center ']],                 
            ],
            'options'=>['class'=>'skip-export'] // remove this row from export
        ]
],       
'showPageSummary'=>true,    
'toolbar' => [ 
$fullExportMenu,
     ['content'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
     ],        
]
]);
?>            
 </div>     
</div>
