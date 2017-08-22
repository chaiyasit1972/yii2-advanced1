<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class MentalController extends Controller
{
    public $mText = "งานสุขภาพจิต";
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
         $names = "งานสุขภาพจิต";
         return $this -> render('/site/mental/index',['mText'=>$this->mText,'names'=>$names]);
    } 
     public function actionMental1Index() {
        $model = new Formmodel();
        $names="รายงานการฆ่าตัวตาย"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=mental/";   
            return $this->redirect($url.'mental1.mrt&d1='.$date1.'&d2='.$date2);                         
        }
            return $this -> render('/site/mental/mental1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
     public function actionMental2Index() {
        $model = new Formmodel();
        $names="รายงานซึมเศร้าส่ง รพ.ศรีมหาโพธิ์"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=mental/";   
            return $this->redirect($url.'mental2.mrt&d1='.$date1.'&d2='.$date2);                         
        }
            return $this -> render('/site/mental/mental1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
}    

