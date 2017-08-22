<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class AdmitController extends Controller
{
    public $mText = "งานศูนย์ Admit ผู้ป่วย";
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
         $names = "งานศูนย์ Admit ผู้ป่วย";
         return $this -> render('/site/admit/index',['mText'=>$this->mText,'names'=>$names]);
    } 
     public function actionAdmit1Index() {
        $model = new Formmodel();
        $names="รายงานสถานะของห้องพิเศษ (check ห้อง-เตียง พิเศษว่าง)"; 
        $sql1="select concat(ward,',',name) as id,name as names from ward where ward not in ('01','02','09','10','11','14') order by ward;";
        $locations = \Yii::$app->db1->createCommand($sql1)->queryAll();    
        $listData=ArrayHelper::map($locations,'id','names');           
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $ward = explode(',',Yii::$app->request->post('ward'));
               $w = $ward[0];
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=admit/";   
            return $this->redirect($url.'admit1.mrt&d1='.$date1.'&w='.$w);                         
        }
            return $this -> render('/site/admit/admit1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model,
                                'data' => $listData]);
    } 

}    

