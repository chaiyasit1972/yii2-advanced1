<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class KpiController extends Controller
{
    public $mText = "รายงานตัวชี้วัด(แยกปีงบประมาณ)";
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
        $names="รายงานตัวชี้วัด(แยกปีงบประมาณ)"; 
        if($model->load(Yii::$app->request->post())){
               $select1 = $model->select1;
               return $this->redirect(['preview', 'name' =>$names, 'select1' =>$select1]);                
        }
              return $this -> render('/site/kpi/index',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);        
    }
    public function actionPreview($name,$select1) {
        $names = "รายงานตัวชี้วัด Kpi (ปีงบประมาณ 25" . $select1 . ")" ;
        $file = 'index'.$select1;
        return $this -> render('/site/kpi/'.$file,['mText'=>$this->mText.'&nbsp;25'. $select1,'names'=>$names,
                              'select1'=>$select1]);
    }
    public function actionKpi1Index($year) {
        $model = new Formmodel();
        $names="ร้อยละของหญิงมีครรภ์ได้รับการฝากครรภ์ครั้งแรกภายใน 12 สัปดาห์"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-1.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                 'model' => $model]);
    } 
    public function actionKpi2Index($year) {
        $model = new Formmodel();
        $names="ร้อยละของหญิงมีครรภ์ได้รับการฝากครรภ์ครบ 5 ครั้งตามเกณฑ์"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-2.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                 'model' => $model]);
    }     
    public function actionKpi3Index($year) {
        $model = new Formmodel();
        $names="ร้อยละของเด็กอายุ 9,18,30,42 เดือน ได้รับการตรวจคัดกรองพัฒนาการ"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-3.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                  'model' => $model]);
    } 
    public function actionKpi4Index($year) {
        $model = new Formmodel();
        $names="ร้อยละของเด็กอายุ 9,18,30,42 เดือน ที่ได้รับการตรวจคัดกรองพัฒนาการพบส่งสัยล่าช้า"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-4.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                 'model' => $model]);
    } 
    public function actionKpi5Index($year) {
        $model = new Formmodel();
        $names="ร้อยละของเด็กอายุ 9,18,30,42 42 เดือน ที่ได้รับการตรวจคัดกรองพัฒนาการ
                     และพบส่งสัยล่าช้าได้รับการตรวจกระตุ้นพัฒนาการ"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-5.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                 'model' => $model]);
    } 
    public function actionKpi6Index($year) {
        $model = new Formmodel();
        $names=" ร้อยละของเด็กอายุ 9,18,30,42 42 เดือน มีพัฒนาการสมวัย"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-6.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                 'model' => $model]);
    }
    public function actionKpi7Index($year) {
        $model = new Formmodel();
        $names="ร้อยละของประชากรไทยอายุ 35 ปีขึ้นไป ได้รับการคัดกรองเบาหวาน "; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-7.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                 'model' => $model]);
    }
    public function actionKpi8Index($year) {
        $model = new Formmodel();
        $names="ร้อยละกลุ่มเสี่ยงเบาหวานได้รับการติดตามผลระดับน้ำตาลในเลือด "; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-8.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                  'model' => $model]);
    }
    public function actionKpi9Index($year) {
        $model = new Formmodel();
        $names=" ร้อยละของประชากรไทยอายุ 35 ปีขึ้นไป ได้รับการคัดกรองความดันโลหิตสูง "; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-9.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                 'model' => $model]);
    }
    public function actionKpi10Index($year) {
        $model = new Formmodel();
        $names="ร้อยละกลุ่มเสี่ยงความดันโลหิตสูงได้รับการติดตามผลระดับความดันโลหิต"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-10.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                 'model' => $model]);
    }
    public function actionKpi11Index($year) {
        $model = new Formmodel();
        $names="อัตราผู้ป่วยเบาหวานรายใหม่ลดลง (ร้อยละ)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-11.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                 'model' => $model]);
    }
    public function actionKpi12Index($year) {
        $model = new Formmodel();
        $names="อัตราผู้ป่วยความดันโลหิตสูงรายใหม่ลดลง (ร้อยละ)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-12.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                 'model' => $model]);
    }    
    public function actionKpi13Index($year) {
        $model = new Formmodel();
        $names="ความชุกของผู้สูบบุหรี่ของประชากรไทย อายุ 15 ปีขึ้นไป"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-13.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                  'model' => $model]);
    }    
    public function actionKpi14Index($year) {
        $model = new Formmodel();
        $names="ความชุกของผู้ดื่มสุราของประชากรไทย อายุ 15 ปีขึ้นไป"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-14.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                  'model' => $model]);
    }    
    public function actionKpi15Index($year) {
        $model = new Formmodel();
        $names="ร้อยละของผู้ป่วยโรคเบาหวานที่ควบคุมได้"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-15.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                  'model' => $model]);
    }    
    public function actionKpi16Index($year) {
        $model = new Formmodel();
        $names="ร้อยละของผู้ป่วยโรคความดันโลหิตสูงที่ควบคุมได้"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-16.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                  'model' => $model]);
    }  
    public function actionKpi17aIndex($year) {
        $model = new Formmodel();
        $names="ร้อยละของผู้ป่วยเบาหวาน ที่ขึ้นทะเบียนได้รับการประเมินโอกาสเสี่ยง
                     ต่อโรคหัวใจและหลอดเลือด (CVD Risk)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-17a.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                 'model' => $model]);
    }  
    public function actionKpi17bIndex($year) {
        $model = new Formmodel();
        $names="ร้อยละของผู้ป่วยความดันโลหิตสูง ที่ขึ้นทะเบียนได้รับการประเมินโอกาสเสี่ยง
                     ต่อโรคหัวใจและหลอดเลือด (CVD Risk)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-17b.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                 'model' => $model]);
    }     
    public function actionKpi18aIndex($year) {
        $model = new Formmodel();
        $names="ร้อยละของผู้ป่วย DM ที่ได้รับการตรวจภาวะแทรกซ้อนทาง ตา"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-18a.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                 'model' => $model]);
    }      
    public function actionKpi18bIndex($year) {
        $model = new Formmodel();
        $names="ร้อยละของผู้ป่วย DM ที่ได้รับการตรวจภาวะแทรกซ้อนทาง เท้า"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-18b.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                  'model' => $model]);
    }      
    public function actionKpi18cIndex($year) {
        $model = new Formmodel();
        $names="ร้อยละของผู้ป่วย DM ที่ได้รับการตรวจ Hba1C"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-18c.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                 'model' => $model]);
    }      
    public function actionKpi18dIndex($year) {
        $model = new Formmodel();
        $names="ร้อยละของผู้ป่วย DM ที่ได้รับการตรวจ Lipid Profile"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-18d.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                  'model' => $model]);
    }
    public function actionKpi18eIndex($year) {
        $model = new Formmodel();
        $names="ร้อยละของผู้ป่วย DM ที่ได้รับการตรวจ eGFR"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-18e.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                 'model' => $model]);
    }
    public function actionKpi18fIndex($year) {
        $model = new Formmodel();
        $names="ร้อยละของผู้ป่วย DM ที่ได้รับการตรวจ micro albumin"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-18f.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                 'model' => $model]);
    }
    public function actionKpi19aIndex($year) {
        $model = new Formmodel();
        $names=" ร้อยละของผู้ป่วยความดันโลหิตสูง ที่ได้รับการตรวจ Lipid Profile"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-19a.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                  'model' => $model]);
    }
    public function actionKpi19bIndex($year) {
        $model = new Formmodel();
        $names="ร้อยละของผู้ป่วยความดันโลหิตสูง ที่ได้รับการตรวจ Urine Protein"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-19b.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                 'model' => $model]);
    }
    public function actionKpi19cIndex($year) {
        $model = new Formmodel();
        $names="ร้อยละของผู้ป่วยความดันโลหิตสูง ที่ได้รับการตรวจ FBS"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-19c.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                 'model' => $model]);
    }
    public function actionKpi19dIndex($year) {
        $model = new Formmodel();
        $names=" ร้อยละของผู้ป่วยความดันโลหิตสูง ที่ได้รับการตรวจ eGFR"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-19d.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                  'model' => $model]);
    }    
    public function actionKpi20Index($year) {
        $model = new Formmodel();
        $names="อัตราตายของผู้ป่วยโรคหลอดเลือดสมอง"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-20.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                 'model' => $model]);
    } 
    public function actionKpi21Index($year) {
        $model = new Formmodel();
        $names="ร้อยละของหญิงตั้งครรภ์ได้รับยาเสริมไอโอดีน"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-21.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                 'model' => $model]);
    }     
    public function actionKpi22Index($year) {
        $model = new Formmodel();
        $names="อัตราการคลอดมีชีพในหญิงอายุ 15 - 19 ปี"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-22.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                 'model' => $model]);
    }     
    public function actionKpi23Index($year) {
        $model = new Formmodel();
        $names="ร้อยละของการตั้งครรภ์ซ้ำในวัยรุ่นอายุ 15 - 19 ปี"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=kpi/";   
            return $this->redirect($url.'kpi60-23.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/kpi/kpi-index',['mText'=>$this->mText."&nbsp;".$year,'names'=>$names,
                                 'model' => $model]);
    }   
    
}