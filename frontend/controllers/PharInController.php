<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class PharInController extends Controller
{
    public $mText = "งานเภสัชกรรม(ห้องจ่ายยาผู้ป่วยใน)";
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
        $names="งานเภสัชกรรม(ห้องจ่ายยาผู้ป่วยใน)"; 
         return $this -> render('/site/phar-in/index',['mText'=>$this->mText,'names'=>$names]);
    } 
    public function actionPharIn1Index() {
        $model = new Formmodel();
        $names="รายชื่อผู้ป่วยใช้ยาวัณโรค(ผป.ใน)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=Phar_in/";   
            return $this->redirect($url.'Phar_in1.mrt&d1='.$date1.'&d2='.$date2);                     
        }
            return $this -> render('/site/phar-in/phar-in1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }   
    public function actionPharIn2Index() {
        $model = new Formmodel();
        $names="รายงานรายการยากลับบ้าน(Hme)มูลค่าสูง เฉพาะยาฉีด"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=Phar_in/";   
            return $this->redirect($url.'Phar_in2.mrt&d1='.$date1.'&d2='.$date2);                     
        }
            return $this -> render('/site/phar-in/phar-in2-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }       
    public function actionPharIn3Index() {
        $model = new Formmodel();
        $names="รายงานการใช้ยาเบาหวานในผู้ป่วย Admit"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=Phar_in/";   
            return $this->redirect($url.'Phar_in3.mrt&d1='.$date1.'&d2='.$date2);                     
        }
            return $this -> render('/site/phar-in/phar-in3-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }      
    public function actionPharIn4Index() {
        $model = new Formmodel();
        $names="รายงานยาราคาสูงแจ้งคลังยา"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=Phar_in/";   
            return $this->redirect($url.'Phar_in4.mrt&d1='.$date1.'&d2='.$date2);                     
        }
            return $this -> render('/site/phar-in/phar-in4-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }     
    public function actionPharIn5Index() {
        $model = new Formmodel();
        $names="รายงานเฝ้าระวังการใช้ยาในผู้ป่วยที่มีภาวะไตบกพร่อง"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=Phar_in/";   
            return $this->redirect($url.'Phar_in5.mrt&d1='.$date1.'&d2='.$date2);                     
        }
            return $this -> render('/site/phar-in/phar-in5-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }       
    
}    

