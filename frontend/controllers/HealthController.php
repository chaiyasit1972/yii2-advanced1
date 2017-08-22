<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class HealthController extends Controller
{
    public $mText = "งานแพทย์แผนไทย";
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
         $names = "งานแพทย์แผนไทย";
         return $this -> render('/site/health/index',['mText'=>$this->mText,'names'=>$names]);
    } 
     public function actionHealth1Index() {
        $model = new Formmodel();
        $names="รายงานตัวชี้วัดงานแพทย์แผนไทย"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=health/";   
            return $this->redirect($url.'health1.mrt&d1='.$date1.'&d2='.$date2);                         
        }
            return $this -> render('/site/health/health1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
     public function actionHealth2Index() {
        $model = new Formmodel();
        $names="รายงานปริมาณการใช้ยางานแพทย์แผนไทย"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               if($model->radio_list == 1){              
                $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=health/";   
                return $this->redirect($url.'health2-opd.mrt&d1='.$date1.'&d2='.$date2);                         
               }else{
                $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=health/";   
                return $this->redirect($url.'health2-ipd.mrt&d1='.$date1.'&d2='.$date2);                       
               } 
        }
            return $this -> render('/site/health/health2-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
     public function actionHealth3Index() {
        $model = new Formmodel();
        $names="รายงานกิจกรรม(หัตถการ)แพทย์แผนไทย แยกตามสิทธิ์การรักษา"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               if($model->radio_list == 1){              
                $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=health/";   
                return $this->redirect($url.'health3-opd.mrt&d1='.$date1.'&d2='.$date2);                         
               }else{
                $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=health/";   
                return $this->redirect($url.'health3-ipd.mrt&d1='.$date1.'&d2='.$date2);                       
               } 
        }
            return $this -> render('/site/health/health3-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }     
     public function actionHealth4Index() {
        $model = new Formmodel();
        $names="รายงานแพทย์แผนไทย แยกตามกลุ่มโรค"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2; 
                $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=health/";   
                return $this->redirect($url.'health4.mrt&d1='.$date1.'&d2='.$date2);                         
        }
            return $this -> render('/site/health/health1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }         
}    

