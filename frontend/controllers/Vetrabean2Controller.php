<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class Vetrabean2Controller extends Controller
{
    public $mText = "งานห้องบัตร(เวชระเบียน)";
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionIndex() {
        $model = new Formmodel();
        $names="รายงาน 20 อันดับโรค ผู้ป่วยนอก/ใน (แยก เทศบาล/อบต.)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;     
               if ($model -> select1 == '1') {
                   // ผู้ป่วยนอก
                   switch ($model -> radio_list) {
                       case 1:
                         // เขตเทศบาลนางรอง
                         $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=vetrabean/";   
                         return $this->redirect($url.'vetrabean2_1_in.mrt&d1='.$date1.'&d2='.$date2);  
                       break;
                       case 2:
                         // เขต อบต. นางรอง  
                         $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=vetrabean/";   
                         return $this->redirect($url.'vetrabean2_2_out.mrt&d1='.$date1.'&d2='.$date2);                             
                       break;
                       default:
                       break;
                   }
               } else {
                   // ผู้ป่วยใน
                   switch ($model -> radio_list) {                   
                       case 1:
                         // เขตเทศบาลนางรอง                           
                         $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=vetrabean/";   
                         return $this->redirect($url.'vetrabean2_3_in.mrt&d1='.$date1.'&d2='.$date2);  
                       break;                   
                       case 2:
                         // เขต อบต. นางรอง                             
                         $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=vetrabean/";   
                         return $this->redirect($url.'vetrabean2_4_out.mrt&d1='.$date1.'&d2='.$date2);                               
                       break;
                       default:
                       break;                   
               }
     
                   
        }
           
    }
 return $this -> render('/site/vetrabean/vetrabean2/index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);    
    }
}