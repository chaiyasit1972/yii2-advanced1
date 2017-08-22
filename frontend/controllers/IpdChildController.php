<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class IpdChildController extends Controller
{
    public $mText = "สกลฯชั้น 2 (กุมารเวชกรรม)";
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
         $names = "สกลฯชั้น 2 (กุมารเวชกรรม)";
         return $this -> render('/site/ipd-child/index',['mText'=>$this->mText,'names'=>$names]);
    } 
     public function actionChild1Index() {
        $model = new Formmodel();
        $names="รายงานอัตราป่วยตายด้วยโรคปอดบวม ในเด็กอายุ 1 เดือน ถึง 5 ปี"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_child/";   
            return $this->redirect($url.'child1.mrt&d1='.$date1.'&d2='.$date2);                         
        }
            return $this -> render('/site/ipd-child/child1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
     public function actionChild2Index() {
        $model = new Formmodel();
        $names="รายงานอัตราผู้ป่วย(IPD)ไข้เลือดออกที่มีภาวะแทรกซ้อน(แยกตามกลุ่มอายุ)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $select = Yii::$app->request->post('select1');    
               switch ($select) {
                      case 1:
                             $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_child/";   
                             return $this->redirect($url.'child2_1.mrt&d1='.$date1.'&d2='.$date2); 
                       break;
                      case 2:
                             $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_child/";   
                             return $this->redirect($url.'child2_2.mrt&d1='.$date1.'&d2='.$date2); 
                       break;
                      default:
                       break;
               }    

        }
            return $this -> render('/site/ipd-child/child2-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
}    

