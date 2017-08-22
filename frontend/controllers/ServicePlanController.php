<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class ServicePlanController extends Controller
{
    public $mText = "รายงานตัวชี้วัด Service Plan ปีงบประมาณ";
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
        $model = new Formmodel();        
        $names="รายงานตัวชี้วัด Service Plan "; 
        if($model->load(Yii::$app->request->post())){
               $select1 = $model->select1;
               return $this->redirect(['preview', 'name' =>$names, 'select1' =>$select1]);                
        }
              return $this -> render('/site/service-plan/index',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);        
    }
    public function actionPreview($name,$select1) {
        $names = "รายงานตัวชี้วัด Service Plan (ปีงบประมาณ 25" . $select1 . ")" ;
        $file = 'index'.$select1;
        return $this -> render('/site/service-plan/'.$file,['mText'=>$this->mText.'&nbsp;25'. $select1 ,'names'=>$names,
                             'select1'=>$select1]);
    }
    public function actionServicePlan601_1($year) {
        $model = new Formmodel();
        $names = "ร้อยละของผู้ป่วยที่ได้รับการผ่าตัดคลอดในโรงพยาบาลระดับ M2 ลงไป";
        $pct = "สาขาสูติกรรม";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;        
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=serviceplan/";   
            return $this->redirect($url.'serviceplan601_1.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/service-plan/service-plan',['mText'=>$this->mText ."&nbsp;".$year,
                                           'pct'=>$pct,'names'=>$names,'model' => $model]);               
    }    
    public function actionServicePlan601_2($year) {
        $model = new Formmodel();
        $names = "อัตราตายของมารดาจากการตกเลือดหลังคลอด";
        $pct = "สาขาสูติกรรม";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;        
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=serviceplan/";   
            return $this->redirect($url.'serviceplan601_2.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/service-plan/service-plan',['mText'=>$this->mText ."&nbsp;".$year,
                                           'pct'=>$pct,'names'=>$names,'model' => $model]);               
    }    
    public function actionServicePlan602_1($year) {
        $model = new Formmodel();
        $names = "อัตราป่วยตายโรคปอดบวมในเด็ก อายุ 1 เดือน ถึง 5 ปี บริบูรณ์ ลดลงร้อยละ 10";
        $pct = "สาขากุมารเวชกรรม";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;        
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=serviceplan/";   
            return $this->redirect($url.'serviceplan602_1.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/service-plan/service-plan',['mText'=>$this->mText ."&nbsp;".$year,
                                           'pct'=>$pct,'names'=>$names,'model' => $model]);               
    }      
    
    public function actionServicePlan603_1($year) {
        $model = new Formmodel();
        $names = "อัตราตายจาก Sepsis/Septic Shock";  
        $pct = "สาขาอายุรกรรม";        
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=serviceplan/";   
            return $this->redirect($url.'serviceplan603_1.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/service-plan/service-plan',['mText'=>$this->mText ."&nbsp;".$year,
                                           'pct'=>$pct,'names'=>$names,'model' => $model]);       

    }

    public function actionServicePlan603_2($year) {
        $model = new Formmodel();        
        $names = "อัตราตายจากการติดเชื้อในกระแสเลือด (Community Acquired Sepsis)";  
        $pct = "สาขาอายุรกรรม";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=serviceplan/";   
            return $this->redirect($url.'serviceplan603_2.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/service-plan/service-plan',['mText'=>$this->mText ."&nbsp;".$year,
                                           'pct'=>$pct, 'names'=>$names,'model' => $model]);              
    }    
    public function actionServicePlan603_3($year) {
        $model = new Formmodel();        
        $names = "อัตราการเกิด การกำเริบเฉียบพลันในผู้ป่วยโรคปอดอุดกั้นเรื้อรัง (PDX= J440,J441)";  
        $pct = "สาขาอายุรกรรม";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=serviceplan/";   
            return $this->redirect($url.'serviceplan603_3.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/service-plan/service-plan',['mText'=>$this->mText ."&nbsp;".$year,
                                           'pct'=>$pct, 'names'=>$names,'model' => $model]);              
    }  
    
    public function actionServicePlan604_1($year) {
        $model = new Formmodel();
        $names = "อัตราไส้ติ่งแตกในผู้ป่วยไส้ติ่งอักเสบ";  
        $pct = "สาขาศัลยกรรม";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=serviceplan/";   
            return $this->redirect($url.'serviceplan604_1.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/service-plan/service-plan',['mText'=>$this->mText ."&nbsp;".$year,
                                           'pct'=>$pct,'names'=>$names,'model' => $model]);       
    }    
    public function actionServicePlan604_2($year) {
        $model = new Formmodel();
        $names = "ร้อยละของผู้ป่วยเสียชีวิตด้วยอาการปวดท้องเฉียบพลัน Acute Abdomen";  
        $pct = "สาขาศัลยกรรม";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=serviceplan/";   
            return $this->redirect($url.'serviceplan604_2.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/service-plan/service-plan',['mText'=>$this->mText ."&nbsp;".$year,
                                           'pct'=>$pct,'names'=>$names,'model' => $model]);       
    }    
    public function actionServicePlan604_3($year) {
        $model = new Formmodel();
        $names = "ร้อยละของผู้ป่วยที่เสียชีวิตด้วยอาการภาวะขาดเลือดที่แขนหรือขา";  
        $pct = "สาขาศัลยกรรม";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=serviceplan/";   
            return $this->redirect($url.'serviceplan604_3.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/service-plan/service-plan',['mText'=>$this->mText ."&nbsp;".$year,
                                           'pct'=>$pct,'names'=>$names,'model' => $model]);       
    }  
    public function actionServicePlan604_4($year) {
        $model = new Formmodel();
        $names = "ร้อยละของการถูกตัดขาตั้งแต่ระดับข้อเท้าขึ้นมาของผู้ป่วยภาวะขาดเลือดที่ขา";  
        $pct = "สาขาศัลยกรรม";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=serviceplan/";   
            return $this->redirect($url.'serviceplan604_4.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/service-plan/service-plan',['mText'=>$this->mText ."&nbsp;".$year,
                                           'pct'=>$pct,'names'=>$names,'model' => $model]);       
    }  

    public function actionServicePlan605_1($year) {
        $model = new Formmodel();
        $names = "อัตราของการดูแลรักษาของผู้ป่วยที่มีกระดูกหักไม่ซับซ้อนใน รพ.ระดับ M2 ลงไป เป้าหมาย >  &nbsp;ร้อยละ 70";  
        $pct = "สาขาศัลยกรรมกระดูก";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $clinic = Yii::$app->request->post('clinic');
               $type = explode(',', $clinic);               
               if($type[0]==1){
                       $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=serviceplan/";   
                      return $this->redirect($url.'serviceplan605_1_1.mrt&d1='.$date1.'&d2='.$date2);   
               }else{
                       $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=serviceplan/";   
                      return $this->redirect($url.'serviceplan605_1_2.mrt&d1='.$date1.'&d2='.$date2);                    
               }
        }
            return $this -> render('/site/service-plan/service-plan-index',['mText'=>$this->mText ."&nbsp;".$year,
                                           'pct'=>$pct,'names'=>$names,'model' => $model]);       
    }      
    
    public function actionServicePlan606_1($year) {
        $model = new Formmodel();
        $names = "รายงาน 5 อันดับโรคของผู้ป่วยมะเร็ง(PDX C00-C99)";  
        $pct = "สาขามะเร็ง";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=serviceplan/";   
               return $this->redirect($url.'serviceplan606_1.mrt&d1='.$date1.'&d2='.$date2);                    
   
        }
            return $this -> render('/site/service-plan/service-plan',['mText'=>$this->mText ."&nbsp;".$year,
                                           'pct'=>$pct,'names'=>$names,'model' => $model]);       
    }          
    
    
}