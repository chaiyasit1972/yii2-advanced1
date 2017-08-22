<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class QofController extends Controller
{
    public $mText = "รายงานตัวชี้วัด QOF (แยกปีงบประมาณ)";
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
        $names="รายงานตัวชี้วัด QOF(แยกปีงบประมาณ)"; 
        if($model->load(Yii::$app->request->post())){
               $select1 = $model->select1;
               return $this->redirect(['preview', 'name' =>$names, 'select1' =>$select1]);                
        }
              return $this -> render('/site/qof/index',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);        
    }
    public function actionPreview($name,$select1) {
        $names = "รายงานตัวชี้วัด QOF (ปีงบประมาณ 25" . $select1 . ")" ;
        $file = 'index'.$select1;
        return $this -> render('/site/qof/'.$file,['mText'=>$this->mText,'names'=>$names]);
    }
    public function actionQof1Index() {
        $model = new Formmodel();
        $names="ร้อยละของประชากรไทยอายุ 35-74 ปี ได้รับการคัดกรองเบาหวาน โดยการตรวจวัด ระดับน้าตาลในเลือด(UC)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=qof/";   
            return $this->redirect($url.'qof1.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/qof/qof1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }  
    public function actionQof2Index() {
        $model = new Formmodel();
        $names="ร้อยละของประชากรไทยอายุ 35-74 ปี ที่ได้รับการคัดกรองและวินิจฉัยเป็นเบาหวาน(UC)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=qof/";   
            return $this->redirect($url.'qof2.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/qof/qof1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }  
    public function actionQof3Index() {
        $model = new Formmodel();
        $names="ร้อยละของประชากรไทยอายุ 35-74ปี ได้รับการคัดกรองความดันโลหิตสูง (UC)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=qof/";   
            return $this->redirect($url.'qof3.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/qof/qof1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }      
    public function actionQof4Index() {
        $model = new Formmodel();
        $names="ร้อยละของประชากรไทยอายุ 35-74 ปี ที่ได้รับการคัดกรองและวินิจฉัยเป็นความดันโลหิตสูง (UC)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=qof/";   
            return $this->redirect($url.'qof4.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/qof/qof1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }      
    public function actionQof5Index() {
        $model = new Formmodel();
        $names="ร้อยละของหญิงมีครรภ์ได้รับการฝากครรภ์ครั้งแรกภายใน 12 สัปดาห์"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=qof/";   
            return $this->redirect($url.'qof5.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/qof/qof1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }         
    public function actionQof6Index() {
        $model = new Formmodel();
        $names="ร้อยละสะสมความครอบคลุมการตรวจคัดกรองมะเร็งปากมดลูกในสตรี 30-60 ปี ภายใน 5 ปี"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=qof/";   
            return $this->redirect($url.'qof6.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/qof/qof1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }
    public function actionQof7Index() {
        $model = new Formmodel();
        $names="ร้อยละการใช้ยาปฏิชีวนะในโรคอุจจาระร่วงเฉียบพลันในผู้ป่วยนอกโรคอุจจาระร่วงเฉียบพลัน Acute Diarrhea (AD)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=qof/";   
            return $this->redirect($url.'qof7.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/qof/qof1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }
    public function actionQof8Index() {
        $model = new Formmodel();
        $names="ร้อยละการใช้ยาปฏิชีวนะในโรคอุจจาระร่วงเฉียบพลันในผู้ป่วยนอกโรคติดเชื้อระบบทางเดินหายใจ Respiratory"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=qof/";   
            return $this->redirect($url.'qof8.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/qof/qof1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }   
    public function actionQof9Index() {
        $model = new Formmodel();
        $names="การลดลงของอัตราการนอนโรงพยาบาลด้วยภาวะที่ควรควบคุมด้วยบริการผู้ป่วยนอก(ACSC) ในโรคลมชัก (epilepsy)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $date3 = $model->date3;
               $date4 = $model->date4;               
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=qof/";   
            return $this->redirect($url.'qof9.mrt&d1='.$date1.'&d2='.$date2.'&d3='.$date3.'&d4='.$date4);                  
        }
            return $this -> render('/site/qof/qof2-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionQof10Index() {
        $model = new Formmodel();
        $names="การลดลงของอัตราการนอนโรงพยาบาลด้วยภาวะที่ควรควบคุมด้วยบริการผู้ป่วยนอก(ACSC) ในโรคปอดอุดกั้นเรื้อรัง (COPD)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $date3 = $model->date3;
               $date4 = $model->date4;                
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=qof/";   
            return $this->redirect($url.'qof10.mrt&d1='.$date1.'&d2='.$date2.'&d3='.$date3.'&d4='.$date4);                  
        }
            return $this -> render('/site/qof/qof2-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionQof11Index() {
        $model = new Formmodel();
        $names="การลดลงของอัตราการนอนโรงพยาบาลด้วยภาวะที่ควรควบคุมด้วยบริการผู้ป่วยนอก(ACSC) ในโรคหืด (asthma)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $date3 = $model->date3;
               $date4 = $model->date4;                
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=qof/";   
            return $this->redirect($url.'qof11.mrt&d1='.$date1.'&d2='.$date2.'&d3='.$date3.'&d4='.$date4);                  
        }
            return $this -> render('/site/qof/qof2-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionQof12Index() {
        $model = new Formmodel();
        $names="การลดลงของอัตราการนอนโรงพยาบาลด้วยภาวะที่ควรควบคุมด้วยบริการผู้ป่วยนอก(ACSC) ในโรคเบาหวาน (DM)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $date3 = $model->date3;
               $date4 = $model->date4;                
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=qof/";   
            return $this->redirect($url.'qof12.mrt&d1='.$date1.'&d2='.$date2.'&d3='.$date3.'&d4='.$date4);                  
        }
            return $this -> render('/site/qof/qof2-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionQof13Index() {
        $model = new Formmodel();
        $names="การลดลงของอัตราการนอนโรงพยาบาลด้วยภาวะที่ควรควบคุมด้วยบริการผู้ป่วยนอก(ACSC) ในโรคความดันโลหิตสูง (HT)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $date3 = $model->date3;
               $date4 = $model->date4;                
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=qof/";   
            return $this->redirect($url.'qof13.mrt&d1='.$date1.'&d2='.$date2.'&d3='.$date3.'&d4='.$date4);                  
        }
            return $this -> render('/site/qof/qof2-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionQof14Index() {
        $model = new Formmodel();
        $names="เด็กสงสัยพัฒนาการล่าช้าได้รับการตรวจกระตุ้นพัฒนาการ"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=qof/";   
            return $this->redirect($url.'qof14.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/qof/qof1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionQof15Index() {
        $model = new Formmodel();
        $names="ร้อยละของเด็กนักเรียนมีภาวะเริ่มอ้วนและอ้วน"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=qof/";   
            return $this->redirect($url.'qof15.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/qof/qof1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionQof16Index() {
        $model = new Formmodel();
        $names="ร้อยละการตั้งครรภ์ซ้ำในหญิงอายุน้อยกว่า 20 ปี"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=qof/";   
            return $this->redirect($url.'qof16.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/qof/qof1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }     
    public function actionQof17Index() {
        $model = new Formmodel();
        $names="ร้อยละผู้สูงอายุที่มีภาวะพึ่งพิง(ติดเตียง) และกลุ่มเป้า หมายที่ส้าคัญ
                      ได้รับการดูแลต่อเนื่องที่บ้าน โดยทีมหมอ ครอบครัวระดับต้าบล"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=qof/";   
            return $this->redirect($url.'qof17.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/qof/qof1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }     
    public function actionQof18Index() {
        $model = new Formmodel();
        $names="อัตราป่วยโรคไข้เลือดออกลดลง"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=qof/";   
            return $this->redirect($url.'qof18.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/qof/qof1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }     
    
}