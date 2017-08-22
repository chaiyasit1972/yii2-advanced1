<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class IpdOrthoOpdController extends Controller
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
    public function actionOpd1Index() {
        $model = new Formmodel();
        $names="รายงานผู้ป่วยนอกแผนกศัลยกรรมกระดูก"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;    
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_ortho/";   
            return $this->redirect($url.'opd1.mrt&d1='.$date1.'&d2='.$date2);                  
           //   return $this->redirect(['preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/ipd-ortho/opd/opd1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionOpd2Index() {
        $model = new Formmodel();
        $names="รายงาน 5 อันดับโรคแรกแผนกศัลยกรรมกระดูก"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;    
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_ortho/";   
            return $this->redirect($url.'opd2.mrt&d1='.$date1.'&d2='.$date2);                  
           //   return $this->redirect(['preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/ipd-ortho/opd/opd2-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }    
    public function actionOpd3Index() {
        $model = new Formmodel();
        $names="รายงาน 10 อันดับการส่งต่อแผนกศัลยกรรมกระดูก"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;    
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_ortho/";   
            return $this->redirect($url.'opd3.mrt&d1='.$date1.'&d2='.$date2);                  
           //   return $this->redirect(['preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/ipd-ortho/opd/opd3-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }     
    public function actionOpd4Index() {
        $model = new Formmodel();
        $names="รายงานผู้ป่วยนอกแผนกศัลยกรรมกระดูก(simple fracture)จำหน่ายกลับบ้าน"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;    
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_ortho/";   
            return $this->redirect($url.'opd4.mrt&d1='.$date1.'&d2='.$date2);                  
           //   return $this->redirect(['preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/ipd-ortho/opd/opd4-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }     
    public function actionOpd5Index() {
        $model = new Formmodel();
        $names="รายงาน Non displace fracture จำหน่ายกลับบ้าน"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;    
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_ortho/";   
            return $this->redirect($url.'opd5.mrt&d1='.$date1.'&d2='.$date2);                  
           //   return $this->redirect(['preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/ipd-ortho/opd/opd5-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }        
    public function actionOpd6Index() {
        $model = new Formmodel();
        $names="รายงาน CF OPD เกิดจากอุบัติเหตุ จำหน่ายกลับบ้าน"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;    
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_ortho/";   
            return $this->redirect($url.'opd6.mrt&d1='.$date1.'&d2='.$date2);                  
           //   return $this->redirect(['preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/ipd-ortho/opd/opd6-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }    
}    

