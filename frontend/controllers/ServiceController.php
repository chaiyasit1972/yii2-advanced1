<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class ServiceController extends Controller
{
    public $mText = "งานบริการข้อมูล";
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
        $names="ข้อมูลพื้นฐาน & ข้อมูลทั่วไป"; 
         return $this -> render('/site/service/index',['mText'=>$this->mText,'names'=>$names]);
    } 
    public function actionIndex1() {
        $names="ข้อมูลพื้นฐาน & ข้อมูลทั่วไป"; 
         return $this -> render('/site/service/index1',['mText'=>$this->mText,'names'=>$names]);
    } 
     public function actionIndex2() {
        $names="ตัวชี้วัด KPI "; 
         return $this -> render('/site/service/index2',['mText'=>$this->mText,'names'=>$names]);
    }
    public function actionIndex3() {
        $names="ตัวชีวัด Service Plan"; 
         return $this -> render('/site/service/index3',['mText'=>$this->mText,'names'=>$names]);
    }        
     public function actionIndex4() {
        $names="งานโรคที่สนใจ & PCT"; 
         return $this -> render('/site/service/index4',['mText'=>$this->mText,'names'=>$names]);
    } 
     public function actionIndex5() {
        $names="ตัวชี้วัด QOF"; 
         return $this -> render('/site/service/index5',['mText'=>$this->mText,'names'=>$names]);
    }     
}    

