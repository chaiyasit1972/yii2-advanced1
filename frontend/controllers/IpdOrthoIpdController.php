<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class IpdOrthoIpdController extends Controller
{
    public $mText = "งานศัลกรรมกระดูก";
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
    public function actionIpd1Index() {
        $model = new Formmodel();
        $names="รายงานปริมาณผู้ป่วยในแผนกศัลยกรรมกระดูก"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;    
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_ortho/";   
            return $this->redirect($url.'ipd1.mrt&d1='.$date1.'&d2='.$date2);                  
           //   return $this->redirect(['preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/ipd-ortho/ipd/ipd1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }  
    public function actionIpd2Index() {
        $model = new Formmodel();
        $names="รายงานการส่งต่อแผนกศัลยกรรมกระดูก"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_ortho/";   
               return $this->redirect($url.'ipd2.mrt&d1='.$date1.'&d2='.$date2);                             
        }
            return $this -> render('/site/ipd-ortho/ipd/ipd2-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }     
    public function actionIpd3Index() {
        $model = new Formmodel();
        $names="รายงานการรับการส่งต่อแผนกศัลยกรรมกระดูก"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_ortho/";   
               return $this->redirect($url.'ipd3.mrt&d1='.$date1.'&d2='.$date2);                             
        }
            return $this -> render('/site/ipd-ortho/ipd/ipd3-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionIpd4Index() {
        $model = new Formmodel();
        $names="รายงานผู้ป่วยในแผนกศัลยกรรมกระดูก(simple fracture)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;    
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_ortho/";   
            return $this->redirect($url.'ipd4.mrt&d1='.$date1.'&d2='.$date2);                  
           //   return $this->redirect(['preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/ipd-ortho/ipd/ipd4-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionIpd5Index() {
        $model = new Formmodel();
        $names="รายงานรับ Refer(refer in) Admit Adjrw < 0.5"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;    
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_ortho/";   
            return $this->redirect($url.'ipd5.mrt&d1='.$date1.'&d2='.$date2);                  
           //   return $this->redirect(['preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/ipd-ortho/ipd/ipd5-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionIpd6Index() {
        $model = new Formmodel();
        $names="รายงานส่ง Refer(refer out) Admit Adjrw < 0.5"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;    
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_ortho/";   
            return $this->redirect($url.'ipd6.mrt&d1='.$date1.'&d2='.$date2);                  
           //   return $this->redirect(['preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/ipd-ortho/ipd/ipd6-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionIpd7Index() {
        $model = new Formmodel();
        $names="รายงานรับ Refer(refer in) Simple Fracture"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;    
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_ortho/";   
            return $this->redirect($url.'ipd7.mrt&d1='.$date1.'&d2='.$date2);                  
           //   return $this->redirect(['preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/ipd-ortho/ipd/ipd7-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }      
    public function actionIpd8Index() {
        $model = new Formmodel();
        $names="รายงาน Non displace fracture เกิดจากอุบัติเหตุ ไม่ได้ผ่าตัด"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;    
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_ortho/";   
            return $this->redirect($url.'ipd8.mrt&d1='.$date1.'&d2='.$date2);                  
           //   return $this->redirect(['preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/ipd-ortho/ipd/ipd8-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }
    public function actionIpd9Index() {
        $model = new Formmodel();
        $names="รายงาน CF IPD เกิดจากอุบัติเหตุ ไม่ได้ผ่าตัด"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;    
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_ortho/";   
            return $this->redirect($url.'ipd9.mrt&d1='.$date1.'&d2='.$date2);                  
           //   return $this->redirect(['preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/ipd-ortho/ipd/ipd9-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }    
    
}    