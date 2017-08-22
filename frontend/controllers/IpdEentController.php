<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class IpdEentController extends Controller
{
    public $mText = "งานผู้ป่วยใน (ตาหูคอจมูก ตึกผู้ป่วย 5/3)";
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
        $names="งานผู้ป่วยใน (ตาหูคอจมูก ตึกผู้ป่วย 5/3)"; 
         return $this -> render('/site/ipd-eent/index',['mText'=>$this->mText,'names'=>$names]);
    } 
    public function actionEent1Index() {
        $model = new Formmodel();
        $names="รายงาน 5 อันดับโรค ผู้ป่วยใน ตา หู คอ จมูก"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
                 $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=eent/";   
                 return $this->redirect($url.'eent1.mrt&d1='.$date1.'&d2='.$date2);  

        }
            return $this -> render('/site/ipd-eent/eent1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }  

}    