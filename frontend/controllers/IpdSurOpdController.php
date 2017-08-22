<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use frontend\models\Formmodel;

class IpdSurOpdController extends Controller
{
    public $mText = "งานศัลยกรรมทั่วไป (ผู้ป่วยนอก) ";
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
    public function actionOpd1Index() {
        $model = new Formmodel();
        $names="รายงานยอดผู้ป่วยนอกแผนกศัลยกรรมทั่วไป"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;                   
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_sur/";   
               return $this->redirect($url.'opd1.mrt&d1='.$date1.'&d2='.$date2);  
        }
            return $this -> render('/site/ipd-sur/opd/opd1_index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }    

    public function actionOpd2Index() {
        $model = new Formmodel();
        $names="รายงานยอดผู้เสียชีวิตผู้ป่วยนอกแผนกศัลยกรรมทั่วไป"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;                   
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_sur/";   
               return $this->redirect($url.'opd2.mrt&d1='.$date1.'&d2='.$date2);  
        }
            return $this -> render('/site/ipd-sur/opd/opd2_index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }    
 
    public function actionOpd3Index() {
        $model = new Formmodel();
        $names="รายงานการส่งต่อ(Refer-out)ผู้ป่วยนอกแผนกศัลยกรรมทั่วไป"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;       
               $chk = $model -> select1;          
              if($chk[0] == '1'){
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_sur/";   
               return $this->redirect($url.'opd3_1.mrt&d1='.$date1.'&d2='.$date2);  
               }else{
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_sur/";   
               return $this->redirect($url.'opd3_2.mrt&d1='.$date1.'&d2='.$date2);       
               
               }
        }
            return $this -> render('/site/ipd-sur/opd/opd3_index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }    

    public function actionOpd4Index() {
        $model = new Formmodel();
        $names="รายงานการรับส่งต่อ(Refer-in)ผู้ป่วยนอกแผนกศัลยกรรมทั่วไป"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;                   
              $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_sur/";   
               return $this->redirect($url.'opd4.mrt&d1='.$date1.'&d2='.$date2);  
        }
            return $this -> render('/site/ipd-sur/opd/opd4_index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);    
    }    
    



}