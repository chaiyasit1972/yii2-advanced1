<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class AncController extends Controller
{
    public $mText = "งานอนามัยแม่และเด็ก";
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
        $names="งานอนามัยแม่และเด็ก"; 
         return $this -> render('/site/anc/index',['mText'=>$this->mText,'names'=>$names]);
    } 
     public function actionAnc1Index() {
        $names="รายงานสรุป งานอนามัยแม่และเด็ก";
        $model = new Formmodel();
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=anc/";   
               return $this->redirect($url.'anc1.mrt&d1='.$date1.'&d2='.$date2);                       
        }
            return $this -> render('/site/anc/anc1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
}
     public function actionAnc2Index() {
        $names="รายงานร้อยละของ ANC ที่ได้รับการฝากครรภ์ครั้งแรกภายใน 12 week";
        $model = new Formmodel();
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=anc/";   
               return $this->redirect($url.'anc2.mrt&d1='.$date1.'&d2='.$date2);                       
        }
            return $this -> render('/site/anc/anc2-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
}
}    

