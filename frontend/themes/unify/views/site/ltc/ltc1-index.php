<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;

?>
<head>
    <style type="text/css">
        .indent{ 
                    /*padding-left: 1.0em;*/
                    padding-top: 0.4em;
                 }
    </style>
</head>
<div class="breadcrumbs">
    <div class="container">
        <h3 class="pull-left"><?=$mText;?></h3>
        <ul class="pull-right breadcrumb">
            <li><?=Html::a('Home',['/site/index']);?></li>
            <li><?=Html::a($mText,['/ltc/index']);;?></li>
            <li class="active"><?=$names;?></li>
        </ul>
    </div>
</div>
<?php    
        $this->registerJs("

            var input1 = 'input[name=\"Formmodel[radio_list]\"]';
              setHideInput(1,$(input1).val(),'.field-blog-tag');
              $(input1).click(function(val){
                setHideInput(1,$(this).val(),'.field-blog-tag');
              });
          
          function setHideInput(set,value,objTarget)
          {
            console.log(set+'='+value);
              if(set==value)
              {
                $(objTarget).show(100);
              }
              else
              {
                $(objTarget).hide(100);
              }
          }
        ");    
?>
        <div class="container content">
            <div class="row">
                <div class="col-md-12">
                      <?php    
                            $form = ActiveForm::begin([
                                'id' => 'login-form-inline', 
                                'type' => ActiveForm::TYPE_INLINE,
                                'options' => [
                                                   //'target' => '_blank',
                                                   'class' => 'sky-form',
                                                 ],            
                                'formConfig' => [ 
                                                          'labelSpan' => 1, 
                                                          'deviceSize' => ActiveForm::SIZE_SMALL,                                                          
                                                      ]            
                            ]); 

                       ?>     
        <div class="panel panel-success margin-bottom-5">            
            <div class="panel-heading">
                <h3><?= $names; ?></h3>
            </div><label class="label"></label>
                      <div class="panel">                         
                          <div class="panel-body">
                              <div class="col-md-3 text-right">
                                  <div class="form-group">
                                      <label class="label">วันที่รายงาน&nbsp; : &nbsp;&nbsp;
                                            <?php echo DatePicker::widget([
                                                   'attribute' => 'date1',
                                                   'name' =>'date1', 
                                                   'language' => 'th',
                                                   'dateFormat' => 'yyyy-MM-dd',       
                                                   'options' => [
                                                         'style' => 'width:105px;height:36px;text-align:center;',
                                                         'placeholder' => '    /  /  ',            
                                                         'class' => 'form-control'
                                                   ],       
                                                   ]);                        
                                            ?>
                                      </label>
                                  </div>
                              </div>     
                                  <div class="col-md-8 indent">   
                                      <div class="form-group">
                                            <label class="radio-inline"> เลือกรายงาน : &nbsp;&nbsp;&nbsp;&nbsp;
                                                <?php
                                                      $list = [0 => ' ทั้งหมด', 1 => ' แยกกลุ่มอายุ'];
                                                      echo $form->field($model, 'radio_list')->radioList($list, ['inline'=>true]);
                                                ?>         
                                            </label>
                                            <div class="form-group field-blog-tag">
                                                    <?= $form->field($model, 'text1')->textInput(['placeholder' =>'',
                                                                         'style' =>'width:70px;text-align:center;','value' => 0]);                        
                                                    ?>--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?= $form->field($model, 'text2',
                                                                    [
                                                                           'inputOptions' => [
                                                                                   'style' => 'width:70px;text-align:center;',
                                                                                   'placeholder' => '',
                                                                                   'value' => 0
                                                                           ]
                                                                    ]        
                                                            );
                                                    ?>
                                            </div>                                                                                   
                                        </div>                
                                  </div>                                                                                           
                                     <?php echo Html::submitButton('Previews', ['class' => 'btn-u btn-u-green']); ?>
                          </div>     
                      </div>                
                      <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <br /><br /><br /><br /><br /><br /><br /><br />