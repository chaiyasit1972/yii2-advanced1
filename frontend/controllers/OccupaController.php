<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class OccupaController extends Controller
{
    public $mText = "งานอาชีวะอนามัย";
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
         $names = "งานอาชีวะอนามัย";
         return $this -> render('/site/occupa/index',['mText'=>$this->mText,'names'=>$names]);
    } 
     public function actionOccupa1Index() {
        $model = new Formmodel();
        $names="รายงานอาชีวะอนามัย(Y96)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=occupa/";   
            return $this->redirect($url.'occupa1.mrt&d1='.$date1.'&d2='.$date2);                         
        }
            return $this -> render('/site/occupa/occupa-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
     public function actionOccupa2Index() {
        $model = new Formmodel();
        $names="รายงานผลการตรวจสุขภาพ(โครงการพิเศษ คัดกรองความเสี่ยงตามกลุ่มโรค)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=occupa/";   
            return $this->redirect($url.'occupa2.mrt&d1='.$date1.'&d2='.$date2);                         
        }
            return $this -> render('/site/occupa/occupa-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    
}    

