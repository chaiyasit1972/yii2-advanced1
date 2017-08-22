<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class FundQofController extends Controller
{
    public $mText = "กองทุน QOF";
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
        $names="กองทุน QOF"; 
         return $this -> render('/site/fund-qof/index',['mText'=>$this->mText,'names'=>$names]);
    } 
     public function actionQof5Index() {
        $names="ร้อยละของหญิงมีครรภ์(ในเขตรับผิดชอบ) ได้รับการฝากครรภ์ครั้งแรกภายใน 12 สัปดาห์ ";
        $model = new Formmodel();
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=fund-qof/";   
               return $this->redirect($url.'qof5.mrt&d1='.$date1.'&d2='.$date2);                       
        }
            return $this -> render('/site/fund-qof/qof-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
}    
}