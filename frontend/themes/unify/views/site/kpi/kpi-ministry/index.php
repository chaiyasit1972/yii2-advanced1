<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;

$asset = frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

?>

<div class="breadcrumbs">
    <div class="container">
        <h4 class="pull-left"><?=$mText;?></h4>
        <ul class="pull-right breadcrumb">
            <li><?=Html::a('Home',['/site/index']);?></li>
            <li><?=Html::a($names,['/service/index2']);;?></li>
        </ul>
    </div>
</div>
<div class="margin-bottom-10"></div>       
<div class="row margin-left-5 margin-right-5">
    <div class="col-md-4">
        <img class="img-responsive margin-bottom-20" src="<?= $baseUrl ?>/assets/img/bas3.jpg"  alt="">
    </div>
    <div class="col-md-8">
        <div class="tag-box tag-box-v3 form-page">  
            <?php
            $form = ActiveForm::begin([
                        'id' => 'login-form-inline',
                        'type' => ActiveForm::TYPE_INLINE,
                        'options' => [                           
                            'class' => 'sky-form',
                            //'target' => '_blank'
                        ],
                        'formConfig' => [
                            'labelSpan' => 1,
                            'deviceSize' => ActiveForm::SIZE_SMALL,
                        ]
            ]);
            ?>           
            <div class="panel">
                <div class="panel-body"><div class="headline col col-md-3 indent"> 
                        <label class="label"><h4>เลือกปีงบประมาณ :</h4></label></div>
                  <div class="col col-md-4 indent headline">
                      <label><h4>
                                <?php
                                            echo Select2::widget([
                                                'model' => $model,
                                                'attribute' => 'select1',
                                                'name' => 'select1',
                                                'data' => [
                                                    '2562' => '2562',                        
                                                    '2561' => '2561',
                                                    '2560' => '2560',
                                                    '2559' => '2559',                                                    
                                                ],
                                                'size' => Select2::SMALL,
                                                'theme' => 'krajee',
                                                'options' => ['placeholder' => '========  เลือกปีงบประมาณ ========='],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ]);
                                ?>    
                          </h4></label>
                    </div>                   
                    
                    
                    <div class="col col-md-3 text-right">
                    <?php echo Html::submitButton('ตกลง', ['class' => 'btn-u btn-u-red']); ?>
                    </div>
                </div>     
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div> 
        
    </div>
    
    